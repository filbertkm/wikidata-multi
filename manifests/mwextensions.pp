class wikidata_test::mwextensions() {

    require wikidata_test::mediawiki

    git::clone { 'mwextensions':
        ensure    => latest,
        directory => '/srv/mediawiki/extensions',
        branch => 'master',
        owner => 'mwdeploy',
        group => 'mwdeploy',
        timeout => 1800,
        require => git::clone["mediawiki"],
        origin => 'https://gerrit.wikimedia.org/r/p/mediawiki/extensions.git';
    }

    git::clone { 'wikidatagit':
        ensure => latest,
        directory => '/srv/mediawiki/extensions/WikidataBuild',
        branch => 'query',
        owner => 'mwdeploy',
        group => 'mwdeploy',
        timeout => 200,
        require => git::clone['mwextensions'],
        origin => 'https://github.com/wmde/WikidataBuildResources.git';
    }

    file {
        '/srv/mediawiki/master/extensions':
            ensure => 'link',
            force => true,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            target => '/srv/mediawiki/extensions',
            require => git::clone["mwextensions"];
    }

    exec { 'git-submodule-update':
        cwd => '/srv/mediawiki/extensions',
        command => '/usr/bin/git submodule foreach git reset --hard HEAD && /usr/bin/git submodule update --init --recursive',
        user => 'mwdeploy',
        require => git::clone["mwextensions"],
        timeout => 1800;
    }

    file {
        '/tmp/composer':
            ensure => 'directory';
    }

    exec { 'composer-self-update':
        command => '/usr/local/bin/composer self-update',
        user => 'mwdeploy',
        environment => [ "COMPOSER_HOME=/tmp/composer" ],
        require => file["/usr/local/bin/composer"];
    }

    define wikidata_test::composer-update () {
        file {
          "/srv/mediawiki/extensions/${title}/composer.lock":
            ensure => 'absent',
            require => exec["git-submodule-update"];
        }

        exec { "composer-install-${title}":
            cwd => "/srv/mediawiki/extensions/${title}",
            command => '/usr/local/bin/composer install --prefer-source',
            require => [ exec["composer-self-update"], file["/usr/local/bin/composer"], file["/srv/mediawiki/extensions/${title}/composer.lock"] ],
            user => 'mwdeploy',
            timeout => 1000;
        }

        exec { "composer-update-${title}":
            cwd => "/srv/mediawiki/extensions/${title}",
            command => '/usr/local/bin/composer update --prefer-source',
            require => [ exec["composer-install-${title}"] ],
            user => 'mwdeploy',
            timeout => 1000;
        }
    }

    wikidata_test::composer-update{ ['WikidataBuild']: }
}

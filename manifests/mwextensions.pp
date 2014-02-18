class wikidata_test::mwextensions() {

    require wikidata_test::mediawiki

    git::clone { 'mwextensions':
        ensure    => latest,
        directory => '/srv/mediawiki/extensions',
        branch => 'master',
        owner => 'mwdeploy',
        group => 'www-data',
        timeout => 1800,
        require => git::clone["mediawiki"],
        origin => 'https://gerrit.wikimedia.org/r/p/mediawiki/extensions.git';
    }

    file {
        '/srv/mediawiki/master/extensions':
            ensure => 'link',
            force => true,
            target => '/srv/mediawiki/extensions';
    }

    exec { 'update-extensions':
        cwd => '/srv/mediawiki/extensions',
        command => '/srv/mediawiki/extensions/update-extensions.sh';
    }

    exec { 'git-submodule-update':
        cwd => '/srv/mediawiki/extensions',
        command => '/usr/bin/git submodule update --init --recursive',
        require => exec["update-extensions"],
        timeout => 1800;
    }

	define wikidata_test::composer-update () {
	    exec { "composer-update-${title}":
    	    cwd => "/srv/mediawiki/extensions/${title}",
    		command => '/usr/local/bin/composer update --prefer-source',
    		require => [ exec["update-extensions"], file["/usr/local/bin/composer"] ],
			user => 'mwdeploy',
			timeout => 1000;
    	}
	}

	wikidata_test::composer-update{ ['Wikibase']: }
}

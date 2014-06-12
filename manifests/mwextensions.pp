class wikidata_test::mwextensions(
    $base_dir,
) {

    require wikidata_test::mediawiki

    git::clone { 'mwextensions':
        ensure    => latest,
        directory => "${base_dir}/extensions",
        branch => 'master',
        owner => 'mwdeploy',
        group => 'mwdeploy',
        timeout => 1800,
        require => git::clone["mediawiki"],
        origin => 'https://gerrit.wikimedia.org/r/p/mediawiki/extensions.git';
    }

    git::clone { 'wikidatagit':
        ensure => latest,
        directory => "${base_dir}/extensions/WikidataBuild",
        branch => 'demosystem',
        owner => 'mwdeploy',
        group => 'mwdeploy',
        timeout => 200,
        require => git::clone['mwextensions'],
        origin => 'https://github.com/wmde/WikidataBuildResources.git';
    }

    file {
        "${base_dir}/php-master/extensions":
            ensure => 'link',
            force => true,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            target => "${base_dir}/extensions",
            require => git::clone["mwextensions"];
    }

    exec { 'git-submodule-update':
        cwd => "${base_dir}/extensions",
        command => '/usr/bin/git submodule foreach git reset --hard HEAD && /usr/bin/git submodule update --init --recursive',
        user => 'mwdeploy',
        require => git::clone["mwextensions"],
        timeout => 1800;
    }

}

class wikidata_test::composer() {

    require wikidata_test::mwextensions

    class { 'composer::install_bin':
        composer_home => '/tmp/composer',
        install_dir => '/usr/local/bin',
        source_dir => '/srv/common';
    }

    class { 'composer::update':
        composer_home => '/tmp/composer',
        install_dir => '/usr/local/bin',
        target => '/srv/common/extensions/WikidataBuild',
        user => 'mwdeploy'
    }

}

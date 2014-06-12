class wikidata_test(
  $base_dir = '/srv/common'
) {

    generic::systemuser { 'mwdeploy': name => 'mwdeploy' }


    file {
        "${base_dir}":
            owner => 'mwdeploy',
            group => 'mwdeploy',
            ensure => directory;
    }

    class {'wikidata_test::testhome':
        base_dir => $base_dir
    }

    class {'wikidata_test::static':
        base_dir => $base_dir
    }

    class {'wikidata_test::config':
        base_dir => $base_dir
    }

    class {'wikidata_test::mediawiki':
        base_dir => $base_dir
    }

    class {'wikidata_test::mwextensions':
        base_dir => $base_dir
    }

    class {'wikidata_test::db':
        base_dir => $base_dir
    }

    class {'wikidata_test::apache':}

    class {'wikidata_test::setup':
        base_dir => $base_dir
    }

    class {'wikidata_test::changedispatcher':
        base_dir => $base_dir
    }

}

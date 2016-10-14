class wikidata_test::testhome(
    $base_dir
) {

   file {
        "${base_dir}/testhome":
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            ensure => directory;

    }

    $testfiles = ['favicon.ico', 'index.html', 'style.css', 'Wikidata-logo-demo.png']

    define testhomefiles(
        $base_dir
    ) {
        file { "${base_dir}/testhome/${title}":
            ensure => present,
            source => "puppet:///modules/wikidata_test/testhome/${title}";
        }
    }

    testhomefiles { $testfiles:
        base_dir => $base_dir
    }

}

class wikidata_multi::testhome() {

   file {
        "/srv/testhome":
            owner => 'mwdeploy',
            group => 'www-data',
            mode => 0755,
            ensure => directory;

    }

    $testfiles = ['favicon.ico', 'index.html', 'style.css', 'Wikidata-logo-demo.png']

    define testhomefiles {
        file { "/srv/testhome/${title}":
            ensure => present,
            source => "puppet:///modules/wikidata_multi/testhome/${title}";
        }
    }

    testhomefiles { $testfiles: }

}

class wikidata_test::static () {

    file {
        "/srv/static":
            owner => 'root',
            group => 'mwdeploy',
            mode => 0755,
            ensure => directory;
    }

    define wikidata_test::logo {
        file { "/srv/static/${title}":
            ensure => present,
            source => "puppet:///modules/wikidata_test/static/${title}";
        }
    }

    $logos = ["Wikidata-logo-demorepo.png", "wikivoyage-logo.png", "wikipedia-logo.png", "wikisource-logo.png"]
    wikidata_test::logo { $logos: }

}

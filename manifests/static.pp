class wikidata_multi::static () {

    file {
        "/srv/static":
            owner => 'root',
            group => 'mwdeploy',
            mode => 0755,
            ensure => directory;
    }

    define wikidata_multi::logo {
        file { "/srv/static/${title}":
            ensure => present,
            source => "puppet:///modules/wikidata_multi/static/${title}";
        }
    }

    $logos = ["Wikidata-logo-demorepo.png", "wikivoyage-logo.png", "wikipedia-logo.png", "wikisource-logo.png"]
    wikidata_multi::logo { $logos: }

}

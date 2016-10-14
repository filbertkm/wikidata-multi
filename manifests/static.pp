class wikidata_test::static(
    $base_dir
) {

    file {
        "${base_dir}/static":
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            ensure => directory;
    }

    define wikidata_test::logo(
        $base_dir
    ) {
        file { "${base_dir}/static/${title}":
            ensure => present,
            source => "puppet:///modules/wikidata_test/static/${title}";
        }
    }

    $logos = ["Wikidata-logo-demorepo.png", "wikivoyage-logo.png", "wikipedia-logo.png", "wikisource-logo.png"]
    wikidata_test::logo { $logos:
        base_dir => $base_dir
    }

}

class wikidata_test() {

    generic::systemuser { 'mwdeploy': name => 'mwdeploy' }

    class {'wikidata_test::testhome':}
	class {'wikidata_test::static':}
    class {'wikidata_test::config':}
    class {'wikidata_test::mediawiki':}
    class {'wikidata_test::mwextensions':}
    class {'wikidata_test::db':}
    class {'wikidata_test::apache':}
    class {'wikidata_test::setup':}

}

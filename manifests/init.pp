class wikidata_multi() {

    generic::systemuser { 'mwdeploy': name => 'mwdeploy' }

    class {'wikidata_multi::testhome':}
	class {'wikidata_multi::static':}
    class {'wikidata_multi::config':}
    class {'wikidata_multi::mediawiki':}
    class {'wikidata_multi::mwextensions':}
    class {'wikidata_multi::db':}
    class {'wikidata_multi::apache':}
    class {'wikidata_multi::setup':}

}

<?php

$wgConf = new SiteConfiguration;

$wgConf->settings = array(
        'wgSitename' => array(
                'wikidatawiki' => 'Test Wikidata',
                'enwiki' => 'Test Wikipedia',
		'enwikivoyage' => 'Test Wikivoyage'
	),
 	'wgServer' => array(
		'wikidatawiki' => 'http://wikidata-test-multi.instance-proxy.wmflabs.org',
		'enwiki' => 'http://wikidata-test-client.wikimedia.de',
		'dewiki' => 'http://wikidata-test-dewiki.wikimedia.de'
	),
	'wgLogo' => array(
		'wikidatawiki' => '/static/Wikidata-logo-demorepo.png',
		'enwiki' => '/static/wikipedia-logo.png',
		'enwikivoyage' => '/static/wikivoyage-logo.png'
	),
	'wgLanguageCode' => array(
		'default' => 'en',
	),
	'wgContentHandlerUseDB' => array(
		'default' => false,
		'wikidatawiki' => true
	),
	'wmgDebugMode' => array(
		'default' => true
	),
	'wmgUseWikibaseRepo' => array(
		'default' => false
	),
	'wmgUseWikibaseClient' => array(
		'default' => true,
		'wikidatawiki' => false
	)
);

$globals = $wgConf->getAll(                                                                         
	$wgDBname                                 
);

extract( $globals ); 

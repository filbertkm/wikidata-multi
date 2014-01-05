<?php

$wgConf = new SiteConfiguration;

$wgConf->settings = array(
        'wgSitename' => array(
                'wikidatawiki' => 'Test Wikidata',
                'enwiki' => 'Test Wikipedia',
		'enwikivoyage' => 'Test Wikivoyage',
		'enwikisource' => 'Test Wikisource'
	),
 	'wgServer' => array(
		'wikidatawiki' => 'http://wikidata-dev-repo.wmflabs.org',
		'enwiki' => 'http://wikidata-dev-enwiki.wmflabs.org',
		'enwikivoyage' => 'http://wikidata-dev-enwikivoyage.wmflabs.org',
		'enwikivoyage' => 'http://wikidata-dev-enwikisource.wmflabs.org'
	),
	'wgLogo' => array(
		'wikidatawiki' => '/static/Wikidata-logo-demorepo.png',
		'enwiki' => '/static/wikipedia-logo.png',
		'enwikivoyage' => '/static/wikivoyage-logo.png',
		'enwikisource' => '/static/wikisource-logo.png'
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
		'default' => false,
		'wikidatawiki' => true
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

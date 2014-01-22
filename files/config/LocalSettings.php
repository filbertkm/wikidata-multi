<?php
$wgDBname = 'wikidatawiki';

$wgEnableWikibaseRepo = false;
$wgEnableWikibaseClient = false;
$wmgUseWikibaseExperimental = true;
$wmgUseWikibaseBuild = false;
$wmgSingleInstance = false;
$wmgUseWikibaseComposer = true;

if ( isset( $_SERVER ) && array_key_exists( 'SERVER_NAME', $_SERVER ) ) {
	switch ( $_SERVER['SERVER_NAME'] ) {
		case 'wikidata-dev-enwiki.wmflabs.org':
			$wgDBname = 'enwiki';
			break;
		case 'wikidata-dev-client.wmflabs.org':
			$wgDBname = 'enwiki';
			break;
		case 'wikidata-dev-enwikivoyage.wmflabs.org':
			$wgDBname = 'enwikivoyage';
			break;
		case 'wikidata-dev-enwikisource.wmflabs.org':
			$wgDBname = 'enwikisource';
			break;
		default:
			break;
	}
}

if ( PHP_SAPI === 'cli' ) {
	if ( isset( $argv[0] ) && $argv[0] === '--wiki' ) {
		$wgDBname = $argv[1];
	}
}

require_once ( "/srv/config/CommonSettings.php" );

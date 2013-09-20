<?php
$wgDBname = 'wikidatawiki';

if ( isset( $_SERVER ) && array_key_exists( 'SERVER_NAME', $_SERVER ) ) {
	switch ( $_SERVER['SERVER_NAME'] ) {
		case 'wikidata-test-client.wikimedia.de':
			$wgDBname = 'enwiki';
			break;
		case 'wikidata-test-enwiki.wikimedia.de':
			$wgDBname = 'enwiki';
			break;
		case 'wikidata-test-enwikivoyage.wikimedia.de':
			$wgDBname = 'enwikivoyage';
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

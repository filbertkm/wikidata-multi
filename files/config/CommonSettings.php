<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once ( __DIR__ . '/SiteSettings.php' );
require_once ( __DIR__ . '/DBSettings.php' );

$wgScriptPath	   = "";
$wgArticlePath	  = "/wiki/$1";
$wgScriptExtension  = ".php";

$wgStylePath = "$wgScriptPath/skins";

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@localhost";
$wgPasswordSender = "apache@localhost";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

$wgMainCacheType	= CACHE_MEMCACHED;
$wgMemCachedServers = array( '127.0.0.1:11211' );

$wgUseGzip = true;

$wgEnableUploads = false;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";
$wgUseInstantCommons = true;
$wgShellLocale = "en_US.utf8";
#$wgHashedUploadDirectory = false;

$wgCacheDirectory = '/tmp/mw-cache-master';
$wgLocalisationCacheConf['storeDirectory'] = "$IP/cache/l10n";
$wgLocalisationCacheConf['manualRecache'] = true;

$wgLanguageCode = "en";

$wgSecretKey = "8140bc4d66dee24f98d639a975280f618cf9fcebcccce781fcff8be188dcbab2";
$wgUpgradeKey = "150af8202bfee232";

$wgDefaultSkin = "vector";
$wgVectorUseIconWatch = true;

$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsIcon = "";
$wgRightsUrl = '//creativecommons.org/licenses/by-sa/3.0/';
$wgRightsText = 'Creative Commons Attribution-Share Alike 3.0 Unported';
$wgCopyrightIcon = '<a href="//wikimediafoundation.org/"><img src="//bits.wikimedia.org/images/wikimedia-button.png" width="88" height="31" alt="Wikimedia Foundation"/></a>';

if ( $wgDBname === 'wikidatawiki' ) {
	$wgHooks['SkinCopyrightFooter'][] = function( $title, $type, &$msg, &$link, &$forContent ) {
		if ( $title->getNamespace() === NS_MAIN ) {
			$msg = 'Creative Commons Public Domain 1.0';
			$link = '//creativecommons.org/publicdomain/zero/1.0/';
		}
		return true;
	};
}

$wgDiff3 = "/usr/bin/diff3";

$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['user']['createaccount'] = true;

$wgDeprecationReleaseLimit = '1.22';

if ( $wmgDebugMode ) {
	require_once ( "/srv/config/DebugSettings.php" );
}

require_once ( "/srv/config/ExtensionSettings.php" );
require_once ( "/srv/config/Wikibase.php" );

$wgExtensionEntryPointListFiles[] = "/srv/mediawiki-config/wmf-config/extension-list-wikidata-labs";

require_once( "/srv/config/ExtensionMessages.php" );

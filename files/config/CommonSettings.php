<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once ( __DIR__ . '/SiteSettings.php' );

$wgScriptPath       = "";                                                                           
$wgArticlePath      = "/wiki/$1";                                                                   
$wgScriptExtension  = ".php";   

$wgStylePath = "$wgScriptPath/skins";

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@localhost";
$wgPasswordSender = "apache@localhost";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBuser = "root";
$wgDBpassword = "";
$wgDBprefix = "";
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";
$wgDBmysql5 = false;

$wgMainCacheType    = CACHE_MEMCACHED;                                                              
$wgMemCachedServers = array( '127.0.0.1:11211' ); 

$wgUseGzip = true;

$wgEnableUploads = false;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";
$wgUseInstantCommons = true;
$wgShellLocale = "en_US.utf8";
#$wgHashedUploadDirectory = false;

$wgCacheDirectory = '/tmp/mw-cache/master';

$wgLanguageCode = "en";

$wgSecretKey = "8140bc4d66dee24f98d639a975280f618cf9fcebcccce781fcff8be188dcbab2";
$wgUpgradeKey = "150af8202bfee232";

$wgDefaultSkin = "vector";
$wgVectorUseIconWatch = true;

$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsIcon = "";
$wgRightsUrl = '//creativecommons.org/licenses/by-sa/3.0/';                                         
$wgRightsText = 'Creative Commons Attribution-Share Alike 3.0 Unported';  

$wgDiff3 = "/usr/bin/diff3";

$wgGroupPermissions['*']['createaccount'] = false;                                                  
$wgGroupPermissions['user']['createaccount'] = true;

$wgDeprecationReleaseLimit = '1.22';

if ( $wmgDebugMode ) {
	require_once ( "/srv/config/DebugSettings.php" );
}

require_once ( "/srv/config/ExtensionSettings.php" );

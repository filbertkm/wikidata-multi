<?php

if ( !defined( 'MEDIAWIKI' ) ) {																	   
	die( 'Invalid entry point.' );																	 
}																									  
																									   
if ( $wmgUseWikibaseRepo || $wmgUseWikibaseClient ) {												  
	if ( $wmgUseWikibaseExperimental ) {															   
		define( 'WB_EXPERIMENTAL_FEATURES', 1 );													   
	}																								  
																									   
	if ( $wmgUseWikibaseBuild ) {																	  
		require_once ( "$IP/extensions/Wikidata/Wikidata.php" );									   
	} else {																						   
		if ( !$wmgUseWikibaseComposer ) {															  
			require_once ( "$IP/extensions/DataValues/DataValues.php" );							   
			require_once ( "$IP/extensions/DataTypes/DataTypes.php" );								 
			require_once ( "$IP/extensions/Diff/Diff.php" );										   
			require_once ( "$IP/extensions/WikibaseDataModel/WikibaseDataModel.php" );				 
			require_once ( "$IP/extensions/Wikibase/lib/WikibaseLib.php" );							
		}																							  
	}																								  
}																									  
																									   
if ( $wmgUseWikibaseRepo ) {																		   
	if ( !$wmgUseWikibaseBuild ) {																	 
		require_once ( "$IP/extensions/Wikibase/repo/Wikibase.php" );								  
	}																								  
																									   
	if ( $wmgSingleInstance ) { 
		$baseNs = 120;																			  
																									
		// Define custom namespaces. Use these exact constant names.								
		define( 'WB_NS_ITEM', $baseNs );															
		define( 'WB_NS_ITEM_TALK', $baseNs + 1 );												   
		define( 'WB_NS_PROPERTY', $baseNs + 2 );													
		define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );											   
																									
		// Register extra namespaces.															   
		$wgExtraNamespaces[WB_NS_ITEM] = 'Item';													
		$wgExtraNamespaces[WB_NS_ITEM_TALK] = 'Item_talk';										  
		$wgExtraNamespaces[WB_NS_PROPERTY] = 'Property';											
		$wgExtraNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';								  
																									
		// Tell Wikibase which namespace to use for which kind of entity							
		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = WB_NS_ITEM;			
		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_PROPERTY] = WB_NS_PROPERTY;	
																									
		// Make sure we use the same keys on repo and clients, so we can share cached objects.	  
		$wgWBRepoSettings['sharedCacheKeyPrefix'] = $wgDBname . ':WBL/' . WBL_VERSION;			  
																									
		// NOTE: no need to set up $wgNamespaceContentModels, Wikibase will do that automatically based on $wgWBRepoSettings
																									
		// Tell MediaWIki to search the item namespace											  
		$wgNamespacesToBeSearchedDefault[WB_NS_ITEM] = true;										
	} else {												   
		// Define custom namespaces. Use these exact constant names.								
		$baseNs = 120;																			  
																									
		$wgNamespaceAliases['Item'] = NS_MAIN;													  
		$wgNamespaceAliases['Item_talk'] = NS_TALK;												 
																									
		// Tell Wikibase which namespace to use for which kind of entity							
		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = NS_MAIN;			   
																									
		define( 'WB_NS_PROPERTY', $baseNs + 2 );													
		define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );											   
																									
		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_PROPERTY] = WB_NS_PROPERTY;	
																									
		// Register extra namespaces.															   
		$wgWBNamespaces[WB_NS_PROPERTY] = 'Property';											   
		$wgWBNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';									 
																									
		$wgExtraNamespaces = $wgWBNamespaces + $wgExtraNamespaces;								  
	}																							   
																									
	$wgContentHandlerUseDB = true;																  
																									
	$wgWBClientDbList = array( 'testclient' );													  
																									
	$wgWBRepoSettings['localClientDatabases'] = array_combine( $wgWBClientDbList, $wgWBClientDbList );
																									
	$wgWBRepoSettings['sharedCacheDuration'] = 60 * 60 * 24;										
																									
	$wgWBRepoSettings['usePropertyInfoTable'] = true;											   
																									
	$wgWBRepoSettings['siteLinkGroups'] = array(													
		'wikipedia',																				
		'wikisource',
		'wikivoyage',																			   
		'commons'																				   
	); 

	$wgWBRepoSettings['datalicensetext'] = 'CC-0';												  
	$wgWBRepoSettings['datalicenseurl'] = 'https://creativecommons.org';							
																									
	$wgWBRepoSettings['apiInDebug'] = false;														
	$wgWBRepoSettings['apiInTest'] = false;														 
	$wgWBRepoSettings['apiWithRights'] = true;													  
	$wgWBRepoSettings['apiWithTokens'] = true;													  
																									
	$wgWBRepoSettings['sharedCacheKeyPrefix'] = 'wikidatawiki/WBL-1.23wmf5';						
																									
#   $wgGroupPermissions['wbeditor']['item-set'] = true;											 
#   $wgGroupPermissions['*']['property-create'] = true;											 
}																								   
																									
if ( $wmgUseWikibaseClient ) {																	  
	if ( !$wmgUseWikibaseBuild ) {																  
		require_once ( "$IP/extensions/Wikibase/client/WikibaseClient.php" );					   
	}																							   
	$wgWBClientSettings['repoUrl'] = $wmgSingleInstance ? $wgServer : "https://wikidata-dev-repo.wmflabs.org";
	$wgWBClientSettings['repoScriptPath'] = $wgScriptPath;										  
	$wgWBClientSettings['repoArticlePath'] = $wgArticlePath;										
																									
	// The global site ID by which this wiki is known on the repo.								  
	$wgWBClientSettings['siteGlobalID'] = $wgDBname;												 
																									
	// Database name of the repository, for use by the pollForChanges script.					   
	// This requires the given database name to be known to LBFactory, see						  
	// $wgLBFactoryConf below.																	  
	if ( $wmgSingleInstance === false ) {														   
		$wgWBClientSettings['changesDatabase'] = "wikidatawiki";										
		$wgWBClientSettings['repoDatabase'] = 'wikidatawiki';										   
	}																							   
																									
	$wgWBClientSettings['sharedCacheKeyPrefix'] = 'wikidatawiki/WBL-1.23wmf5';					  
}			

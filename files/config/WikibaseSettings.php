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
        require_once ( "$IP/extensions/DataValues/DataValues.php" );                                
        require_once ( "$IP/extensions/DataTypes/DataTypes.php" );                                  
        require_once ( "$IP/extensions/Diff/Diff.php" );                                            
        require_once ( "$IP/extensions/WikibaseDataModel/WikibaseDataModel.php" );                  
        require_once ( "$IP/extensions/Wikibase/lib/WikibaseLib.php" );                             
    }                                                                                               
}

if ( $wmgUseWikibaseRepo ) {                                                                        
    if ( !$wmgUseWikibaseBuild ) {                                                                  
        require_once ( "$IP/extensions/Wikibase/repo/Wikibase.php" );                               
    }                                                                                               
                                                                                                    
    // Define custom namespaces. Use these exact constant names.                                    
    $baseNs = 100;                                                                                  
                                                                                                    
    $wgNamespaceAliases['Item'] = NS_MAIN;                                                          
    $wgNamespaceAliases['Item_talk'] = NS_TALK;                                                     
                                                                                                    
    $wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = NS_MAIN;                   
                                                                                                    
    define( 'WB_NS_PROPERTY', $baseNs + 2 );                                                        
    define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );                                                   
                                                                                                    
    $wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_PROPERTY] = WB_NS_PROPERTY;        
                                                                                                    
    // Register extra namespaces.                                                                   
    $wgWBNamespaces[WB_NS_PROPERTY] = 'Property';                                                   
    $wgWBNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';                                         
                                                                                                    
    $wgExtraNamespaces = $wgWBNamespaces + $wgExtraNamespaces;                                      
    $wgContentHandlerUseDB = true;  

    $wgWBClientDbList = array( 'enwiki', 'enwikivoyage', 'enwikisource' );                                                      
                                                                                                    
    $wgWBRepoSettings['localClientDatabases'] = array_combine( $wgWBClientDbList, $wgWBClientDbList );
                                                                                                    
    $wgWBRepoSettings['sharedCacheDuration'] = 60 * 60 * 24;                                        
    $wgWBRepoSettings['sharedCacheKeyPrefix'] = "wikibase/WBL-master";                              
                                                                                                    
    $wgWBRepoSettings['usePropertyInfoTable'] = true;                                               
                                                                                                    
    $wgWBRepoSettings['siteLinkGroups'] = array(                                                    
        'wikipedia',                                                                                
        'wikivoyage',                                                                               
        'commons'                                                                                   
    );                                                                                              
                                                                                                    
    $wgWBRepoSettings['datalicensetext'] = 'CC-0';                                                  
    $wgWBRepoSettings['datalicenseurl'] = 'https://creativecommons.org';                            
                                                                                                    
    $wgWBRepoSettings['apiInDebug'] = false;                                                        
    $wgWBRepoSettings['apiInTest'] = false;                                                         
    $wgWBRepoSettings['apiWithRights'] = true;                                                      
    $wgWBRepoSettings['apiWithTokens'] = true;                                                      
}  

if ( $wmgUseWikibaseClient ) {                                                                      
    if ( !$wmgUseWikibaseBuild ) {                                                                  
        require_once ( "$IP/extensions/Wikibase/client/WikibaseClient.php" );                       
    }                                                                                               
                                                                                                    
    $wgWBClientSettings['repoUrl'] = "http://wikidata-dev-repo.wmflabs.org";                                        
    $wgWBClientSettings['repoScriptPath'] = $wgScriptPath;                                          
    $wgWBClientSettings['repoArticlePath'] = $wgArticlePath;                                        
    $wgWBClientSettings['siteGlobalID'] = $wgDBname;                                                 
    $wgWBClientSettings['changesDatabase'] = "wikidatawiki";                                            
    $wgWBClientSettings['repoDatabase'] = 'wikidatawiki';                                               
                                                                                                    
    $wgWBClientSettings['sharedCacheKeyPrefix'] = 'wikibase/WBL-master';                      
}  

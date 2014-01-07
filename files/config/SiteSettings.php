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
		'enwikisource' => 'http://wikidata-dev-enwikisource.wmflabs.org'
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
	'wgCapitalLinks' => array(
		'default' => true
	),
	'wgDisableCounters' => array(
		'default' => true
	),
	'wgMetaNamespace' => array(
		'wikidatawiki' => 'Wikidata',
		'enwiki' => 'Wikipedia',
		'enwikivoyage' => 'Wikivoyage',
		'enwikisource' => 'Wikisource'
	),
	'wgProofreadPageNamespaceIds' => array(
		'enwikisource' => array(                                                                             
	    		'page' => 104,                                                                                   
			'index' => 106,                                                                                  
		)
	),
	'wgExtraNamespaces' => array(
		'default' => array(),
		'enwiki' => array(                                                                              
			100 => 'Portal',                                                                            
			101 => 'Portal_talk',                                                                       
			# 106 => 'Table',                                                                           
			# 107 => 'Table_talk',                                                                      
			108 => 'Book',                                                                              
			109 => 'Book_talk',                                                                         
			118 => 'Draft', // bug 57569                                                                
			119 => 'Draft_talk',                                                                        
		),
		'enwikisource' => array(                                                                        
			100 => 'Portal',                                                                            
			101 => 'Portal_talk',                                                                       
			102 => 'Author',                                                                            
			103 => 'Author_talk',                                                                       
			104 => 'Page', // http://fr.wikisource.org/wiki/Wikisource:Scriptorium#Page:_Namespace      
			105 => 'Page_talk',                                                                         
			106 => 'Index',                                                                             
			107 => 'Index_talk',                                                                        
			114 => 'Translation', // bug 50007                                                          
			115 => 'Translation_talk', // bug 50007                                                     
		),         
	), 
    	'wgUseRCPatrol' => array(
		'default' => false,
		'wikidatawiki' => true,
		'enwikisource' => true,
		'enwikivoyage' => true
	),
	'wgUseNPPatrol' => array(
		'default' => true
	),
	'wgNoFollowLinks' => array(
		'default' => true
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
	),
	'wmgUseDoubleWiki' => array(
		'default' => false,
		'enwikisource' => true
	),
	'wmgUseFlaggedRevs' => array(
		'default' => false
	),
	'wmgUseProofreadPage' => array(
		'default' => false,
		'enwikisource' => true
	),
	'wmgUseLabeledSectionTransclusion' => array(
		'default' => true
	),
	'wmgUseSpamBlacklist' => array(
		'default' => true
	),
	'wmgUseQuiz' => array(
		'default' => false
	),
	'wmgUseGadgets' => array(
		'default' => true
	),
	'wmgUseMwEmbedSupport' => array(
		'default' => true
	),
	'wmgUseTimedMediaHandler' => array(
		'default' => true
	),
	'wgUseContactPageFundraiser' => array(
		'default' => false
	),
	'wmgPFEnableStringFunctions' => array(
		'default' => false
	),
	'wmgUseTitleKey' => array(
		'default' => true
	),
	'wmgUseCirrus' => array(
		'default' => false
	),
	'wmgUseDPL' => array(
		'default' => false,
		'enwikisource' => true
	),
	'wmgUseSpecialNuke' => array(
		'default' => true
	),
	'wmgUseRSSExtension' => array(
		'default' => false
	),
	'wmgUseDismissableSiteNotice' => array(
		'default' => true
	),
	'wmgUseWikimediaLicenseTexts' => array(
		'default' => false
	),
	'wmgUseNewUserMessage' => array(
		'default' => false
	),
	'wmgUsePdfHandler' => array(
		'default' => false
	),
	'wmgUserDailyContribs' => array(
		'default' => true
	),
	'wmgUseMassMessage' => array(
		'default' => true
	),
	'wmgUseBetaFeatures' => array(
		'default' => true
	),
	'wmgUseCommonsMetadata' => array(
		'default' => true
	),
	'wmgUseGWToolset' => array(
		'default' => false
	),
	'wmgUseMultimediaViewer' => array(
		'default' => true
	),
	'wmgUseVectorBeta' => array(
		'default' => true
	),
	'wmgUseTemplateData' => array(
		'default' => false
	),
	'wmgUseCLDR' => array(
		'default' => false
	),
	'wmgUseDisableAccount' => array(
		'default' => false
	),
	'wmgUseWikiLove' => array(
		'default' => false,
		'enwiki' => true,
		'enwikivoyage' => true
	),
	'wmgWikiLoveDefault' => array(
		'default' => true
	),
	'wmgUseGuidedTour' => array(
		'default' => false,
		'enwiki' => true
	),
	'wmgUseMarkAsHelpful' => array(
		'default' => false
	),
	'wmgUseMoodBar' => array(
		'default' => false
	),
	'wmgUseSubPageList3' => array(
		'default' => false
	),
	'wmgUseBabel' => array(
		'default' => true
	),
	'wmgUseApiSandbox' => array(
		'default' => true
	),
	'wmgEnablePageTriage' => array(
		'default' => false
	),
	'wmgEnableInterwiki' => array(
		'default' => true
	),
	'wmgEnableRandomRootPage' => array(
		'default' => true
	),
	'wmgUseThanks' => array(
		'default' => false
	),
	'wmgUseDisambiguator' => array(
		'default' => true
	),
	'wmgUseSubpageSortkey' => array(
		'default' => false
	),
	'wmgUseGeoCrumbs' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseInsider' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseRelatedArticles' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseRelatedSites' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseCalendar' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseMapSources' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseSlippyMap' => array(
		'default' => false
	),
	'wmgUseCreditsSource' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseListings' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseTocTree' => array(
		'default' => false,
		'enwikivoyage' => true
	),
	'wmgUseFloatedToc' => array(
		'default' => false
	),
	'wmgUseUserMerge' => array(
		'default' => false
	),
	'wmgUseUniversalLanguageSelector' => array(
		'default' => true
	),
	'wmgUsePageImages' => array(
		'default' => true
	),
	'wmgUseTemplateSandbox' => array(
		'default' => true
	)
);

$globals = $wgConf->getAll(                                                                         
	$wgDBname                                 
);

extract( $globals ); 

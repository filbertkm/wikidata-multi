<?php

$wmfConfigDir = '/srv/config';

/**
 * @todo
 * include( $IP . '/extensions/timeline/Timeline.php' );
 * include( $IP . '/extensions/SiteMatrix/SiteMatrix.php' );
 * pool counter
 * oai
 * tor block
 */
include( $IP . '/extensions/wikihiero/wikihiero.php' );
include( $IP . '/extensions/CharInsert/CharInsert.php' );

include( $IP . '/extensions/ParserFunctions/ParserFunctions.php' );
$wgMaxIfExistCount = 500; // obs
$wgExpensiveParserFunctionLimit = 500;

require( $IP . '/extensions/Cite/Cite.php' );
require( $IP . '/extensions/Cite/SpecialCite.php' );

include( $IP . '/extensions/InputBox/InputBox.php' );
include( $IP . '/extensions/ImageMap/ImageMap.php' );
include( $IP . '/extensions/SyntaxHighlight_GeSHi/SyntaxHighlight_GeSHi.php' );

if ( $wmgUseDoubleWiki ) {
	include( $IP . '/extensions/DoubleWiki/DoubleWiki.php' );
}

include( $IP . '/extensions/Poem/Poem.php' );

if ( $wmgUseFlaggedRevs ) {
	include( "$wmfConfigDir/flaggedrevs.php" );
}

$wgAvailableRights[] = 'stablesettings';
$wgAvailableRights[] = 'review';
$wgAvailableRights[] = 'unreviewedpages';
$wgAvailableRights[] = 'movestable';
$wgAvailableRights[] = 'validate';

$wgAvailableRights[] = 'templateeditor';

$wgUseAjax = true;
$wgCategoryTreeDynamicTag = true;
require( $IP . '/extensions/CategoryTree/CategoryTree.php' );
$wgCategoryTreeDisableCache = false;

if ( $wmgUseProofreadPage ) {
	include( $IP . '/extensions/ProofreadPage/ProofreadPage.php' );
}

if ( $wmgUseLabeledSectionTransclusion ) {
	include( $IP . '/extensions/LabeledSectionTransclusion/lst.php' );
}

if ( $wmgUseSpamBlacklist ) {
	include( $IP . '/extensions/SpamBlacklist/SpamBlacklist.php' );
	$wgBlacklistSettings = array(
		'spam' => array(
			'files' => array(
				'http://meta.wikimedia.org/w/index.php?title=Spam_blacklist&action=raw&sb_ver=1'
			),
		),
	);
	$wgLogSpamBlacklistHits = true;
}

include( $IP . '/extensions/TitleBlacklist/TitleBlacklist.php' );

$wgTitleBlacklistSources = array(
	array(
		'type' => TBLSRC_URL,
		'src'  => "//meta.wikimedia.org/w/index.php?title=Title_blacklist&action=raw&tb_ver=1",
	),
);

if ( $wmgUseQuiz ) {
	include( "$IP/extensions/Quiz/Quiz.php" );
}

if ( $wmgUseGadgets ) {
	include( "$IP/extensions/Gadgets/Gadgets.php" );
}

if ( $wmgUseMwEmbedSupport ) {
	require_once( "$IP/extensions/MwEmbedSupport/MwEmbedSupport.php" );
}

if ( $wmgUseTimedMediaHandler ) {
	require_once( "$IP/extensions/TimedMediaHandler/TimedMediaHandler.php" );
	$wgTimedTextForeignNamespaces = array( 'commonswiki' => 102 );
	if ( $wgDBname == 'commonswiki' ) {
		$wgTimedTextNS = 102;
	}
	//overwrite enabling of local TimedText namespace
	//$wgEnableLocalTimedText = $wmgEnableLocalTimedText;

	//enable transcoding on all wikis that allow uploads
	$wgEnableTranscode = $wgEnableUploads;

	$wgOggThumbLocation = false; // use ffmpeg for performance
	// $wgOggThumbLocation = '/usr/bin/oggThumb';

	//tmh1/2 have 12 cores and need lots of shared memory
	//for avconv / ffmpeg2theora
	$wgTranscodeBackgroundMemoryLimit = 4 * 1024 * 1024; // 4GB
	$wgFFmpegThreads = 2;

	// Minimum size for an embed video player
	// $wgMinimumVideoPlayerSize = $wmgMinimumVideoPlayerSize;
}

include( $IP . '/extensions/AssertEdit/AssertEdit.php' );

if ( $wgUseContactPageFundraiser ) {
	include( "$IP/extensions/ContactPageFundraiser/ContactPage.php" );
	$wgContactUser = 'Storiescontact';
}

if ( $wmgPFEnableStringFunctions ) {
	$wgPFEnableStringFunctions = true;
}

if ( $wmgUseScribunto ) {
	include( "$IP/extensions/Scribunto/Scribunto.php" );
	$wgScribuntoUseGeSHi = true;
	$wgScribuntoUseCodeEditor = true;
	$wgScribuntoDefaultEngine = 'luastandalone';
}

if ( $wmgUseTitleKey ) {
	include "$IP/extensions/TitleKey/TitleKey.php";
	if ( $wmgUseCirrus ) {
		array_pop( $wgExtensionFunctions );
		$wgHooks['SearchGetNearMatch'][] = 'TitleKey::searchGetNearMatch';
	}
}

if ( $wmgUseDPL ) {
	include( $IP . '/extensions/intersection/DynamicPageList.php' );
}

include( $IP . '/extensions/Renameuser/Renameuser.php' );

if ( $wmgUseSpecialNuke ) {
	include( $IP . '/extensions/Nuke/Nuke.php' );
}

include( "$IP/extensions/AntiBot/AntiBot.php" );
$wgAntiBotPayloads = array(
	'default' => array( 'log', 'fail' ),
);

if ( $wmgUseRSSExtension ) {
	include( "$IP/extensions/RSS/RSS.php" );
}

include $IP . '/extensions/AntiSpoof/AntiSpoof.php';

if ( $wmgUseDismissableSiteNotice ) {
	require( "$IP/extensions/DismissableSiteNotice/DismissableSiteNotice.php" );
}

include "$IP/extensions/WikimediaMessages/WikimediaMessages.php";
if ( $wmgUseWikimediaLicenseTexts ) {
	include "$IP/extensions/WikimediaMessages/WikimediaLicenseTexts.php";
}

if ( $wmgUseNewUserMessage ) {
	include "$IP/extensions/NewUserMessage/NewUserMessage.php";
}

if ( $wmgUsePdfHandler ) {
	include ( "$IP/extensions/PdfHandler/PdfHandler.php" );
}

if ( $wmgUserDailyContribs ) {
	require "$IP/extensions/UserDailyContribs/UserDailyContribs.php";
}

if ( $wmgUseMassMessage ) {
	require_once( "$IP/extensions/MassMessage/MassMessage.php" );
}

if ( $wmgUseBetaFeatures ) {
	require_once( "$IP/extensions/BetaFeatures/BetaFeatures.php" );
}

if ( $wmgUseCommonsMetadata ) {
	require_once( "$IP/extensions/CommonsMetadata/CommonsMetadata.php" );
}

if ( $wmgUseGWToolset ) {
	require_once( "$IP/extensions/GWToolset/GWToolset.php" );
	$wgGWTFileBackend = 'local-multiwrite';
	$wgGWTFBMaxAge = '1 week';
	$wgJobTypeConf['gwtoolsetUploadMetadataJob'] = array( 'checkDelay' => true ) + $wgJobTypeConf['default'];
}

if ( $wmgUseMultimediaViewer ) {
	require_once( "$IP/extensions/MultimediaViewer/MultimediaViewer.php" );
}

if ( $wmgUseVectorBeta ) {
	require_once( "$IP/extensions/VectorBeta/VectorBeta.php" );
}

if ( $wmgUseTemplateData ) {
	require_once( "$IP/extensions/TemplateData/TemplateData.php" );
}

if ( $wmgUseCLDR ) {
	require_once( "$IP/extensions/cldr/cldr.php" );
}

if ( $wmgUseDisableAccount ) {
	require_once( "$IP/extensions/DisableAccount/DisableAccount.php" );
	$wgGroupPermissions['bureaucrat']['disableaccount'] = true;
}

if ( $wmgUseWikiLove ) {
	require_once( "$IP/extensions/WikiLove/WikiLove.php" );
	$wgWikiLoveLogging = true;
	if ( $wmgWikiLoveDefault ) {
		$wgDefaultUserOptions['wikilove-enabled'] = 1;
	}
}

if ( $wmgUseGuidedTour ) {
	require_once( "$IP/extensions/GuidedTour/GuidedTour.php" );
}

if ( $wmgUseMarkAsHelpful ) {
	require_once( "$IP/extensions/MarkAsHelpful/MarkAsHelpful.php" );
	$wgMarkAsHelpfulType = array( 'mbresponse' );
}

if ( $wmgUseMoodBar ) {
	require_once( "$IP/extensions/MoodBar/MoodBar.php" );
	$wgMoodBarCutoffTime = $wmgMoodBarCutoffTime;
	$wgMoodBarBlackoutInterval = array( '20120614000000,20120629000000' );
	$wgMoodBarConfig['privacyUrl'] = "//wikimediafoundation.org/wiki/Feedback_policy";
	$wgMoodBarConfig['feedbackDashboardUrl'] = "$wgServer/wiki/Special:FeedbackDashboard";
}
$wgAvailableRights[] = 'moodbar-admin'; // To allow global groups to include this right -AG


if ( $wmgUseSubPageList3 ) {
	include( "$IP/extensions/SubPageList3/SubPageList3.php" );
}

if ( $wmgUseBabel ) {
	require_once( "$IP/extensions/Babel/Babel.php" );
	// $wgBabelCategoryNames = $wmgBabelCategoryNames;
	// $wgBabelMainCategory = $wmgBabelMainCategory;
	// $wgBabelDefaultLevel = $wmgBabelDefaultLevel;
	// $wgBabelUseUserLanguage = $wmgBabelUseUserLanguage;
}

if ( $wmgUseApiSandbox ) {
	require_once( "$IP/extensions/ApiSandbox/ApiSandbox.php" );
}

if ( $wmgEnablePageTriage ) {
	require_once( "$IP/extensions/PageTriage/PageTriage.php" );
}

if ( $wmgEnableInterwiki ) {
	require_once( "$IP/extensions/Interwiki/Interwiki.php" );
	$wgInterwikiViewOnly = true;
}

if ( $wmgEnableRandomRootPage ) {
	require_once( "$IP/extensions/RandomRootPage/Randomrootpage.php" );
}

if ( $wmgUseThanks ) {
	require_once( "$IP/extensions/Thanks/Thanks.php" );
}

if ( $wmgUseDisambiguator ) {
	require_once( "$IP/extensions/Disambiguator/Disambiguator.php" );
}

if ( $wmgUseSubpageSortkey ) {
	include( "$IP/extensions/SubpageSortkey/SubpageSortkey.php" );
}

/*
if ( $wmgUseGettingStarted ) {
	require_once( "$IP/extensions/GettingStarted/GettingStarted.php" );
	if ( !empty( $sessionRedis[$wmfDatacenter] ) ) {
		$wgGettingStartedRedis = $sessionRedis[$wmfDatacenter][0];
		$wgGettingStartedRedisOptions['password'] = $wmgRedisPassword;
	}
	$wgGettingStartedExcludedCategories = $wmgGettingStartedExcludedCategories;
	$wgGettingStartedRunTest = $wmgGettingStartedRunTest;
}
*/

if ( $wmgUseGeoCrumbs ) {
	require_once( "$IP/extensions/GeoCrumbs/GeoCrumbs.php" );
}

if ( $wmgUseGeoCrumbs || $wmgUseInsider || $wmgUseRelatedArticles || $wmgUseRelatedSites ) {
	require_once( "$IP/extensions/CustomData/CustomData.php" );
}

if ( $wmgUseCalendar ) {
	require_once( "$IP/extensions/Calendar/Calendar.php" );
}

if ( $wmgUseMapSources ) {
	require_once( "$IP/extensions/MapSources/MapSources.php" );
}

if ( $wmgUseSlippyMap ) {
	require_once( "$IP/extensions/OpenStreetMapSlippyMap/SlippyMap.php" );
}

if ( $wmgUseCreditsSource ) {
	require_once( "$IP/extensions/CreditsSource/CreditsSource.php" );
}

if ( $wmgUseListings ) {
	require_once( "$IP/extensions/Listings/Listings.php" );
}

if ( $wmgUseTocTree ) {
	require_once( "$IP/extensions/TocTree/TocTree.php" );
	$wgDefaultUserOptions['toc-floated'] = $wmgUseFloatedToc;
}

if ( $wmgUseInsider ) {
	require_once( "$IP/extensions/Insider/Insider.php" );
}

if ( $wmgUseRelatedArticles ) {
	require_once( "$IP/extensions/RelatedArticles/RelatedArticles.php" );
}

if ( $wmgUseRelatedSites ) {
	require_once( "$IP/extensions/RelatedSites/RelatedSites.php" );

	$wgRelatedSitesPrefixes = array(
		'wikipedia',
		'wikitravel',
		'dmoz',
		'citizendium',
		'gen',
		'commons',
		'tech',
		'assoc',
		'wmc',
		'wtp'
	);

	$wgExtraLanguageNames = array(
		'wikitravel' => 'Wikitravel',
		'wikipedia' => 'Wikipedia',
		'WikiPedia' => 'Wikipedia',
		'citizendium' => 'Citizendium',
		'dmoz' => 'Open Directory',
		'Radreise-Wiki' => 'Radreise-Wiki',
		'rezepte' => 'Rezepte-Wiki',
		'commons' => 'Wikimedia Commons',
		'wmc' => 'Wikimedia Commons',
		'wtp' => 'Wikitravel Press',
		'gen' => 'General',
		'tech' => 'Technical',
		'assoc' => 'Association',
		'ldbwiki' => 'Location Database Wiki',
	);
}

if ( $wmgUseUserMerge ) {
	require_once( "$IP/extensions/UserMerge/UserMerge.php" );
}

if ( $wmgUseUniversalLanguageSelector ) {
	require_once( "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php" );
	$wgULSGeoService = false;
	$wgULSAnonCanChangeLanguage = false;
	$wgDefaultUserOptions['uls-enable'] = 1;
}

if ( $wmgUsePageImages ) {
	require_once( "$IP/extensions/PageImages/PageImages.php" );
}

require_once ( "$IP/extensions/CheckUser/CheckUser.php" );
require_once ( "$IP/extensions/Vector/Vector.php" );

$wgVectorFeatures['collapsibletabs']['user'] = true;
$wgVectorFeatures['simplesearch'] = array( 'global' => true, 'user' => false );
$wgVectorFeatures['expandablesearch'] = array( 'global' => false, 'user' => false );
$wgVectorUseSimpleSearch = true;

require_once ( "$IP/extensions/WikiEditor/WikiEditor.php" );

$wgDefaultUserOptions['usebetatoolbar'] = 1;
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
$wgDefaultUserOptions['wikieditor-preview'] = 1;

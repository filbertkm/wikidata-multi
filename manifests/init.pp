class wikidata_multi() {

    if !defined(Class['webserver::php5']) {
        class {'webserver::php5':
            ssl => true;
        }
    }

    require role::labs-mysql-server, webserver::php5-mysql

    package { [ 'imagemagick', 'php-apc', 'memcached' ] :
        ensure => latest,
    }

    file {
        "/srv/config":
            owner => 'root',
            group => 'root',
            mode => 0664,
            ensure => directory;

        "/tmp/mw-cache":
            owner => 'www-data',
            group => 'www-data',
            mode => 0755,
            ensure => directory;

        "/tmp/mw-cache/master":
            owner => 'www-data',
            group => 'www-data',
            mode => 0755,
            ensure => directory;

        "/srv/static":
            owner => 'root',
            group => 'root',
            mode => 0755,
            ensure => directory;

        "/srv/static/Wikidata-logo-demorepo.png":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/static/Wikidata-logo-demorepo.png';

        "/srv/static/wikivoyage-logo.png":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/static/wikivoyage-logo.png';

        "/srv/static/wikipedia-logo.png":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/static/wikipedia-logo.png';

        "/srv/static/mainpage.xml":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/static/mainpage.xml';

        "/srv/config/all.dblist":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/config/all.dblist';

        "/srv/config/CommonSettings.php":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/config/CommonSettings.php';

        "/srv/config/DebugSettings.php":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/config/DebugSettings.php';

        "/srv/config/SiteSettings.php":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/config/SiteSettings.php';

        "/srv/config/ExtensionSettings.php":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/config/ExtensionSettings.php';

        "/usr/local/bin/dbsetup":
            ensure => present,
            owner => 'root',
            group => 'root',
            mode => 0755,
            source => 'puppet:///modules/wikidata_multi/scripts/dbsetup';

        "/usr/local/bin/git-pull-all":
            ensure => present,
            owner => 'root',
            group => 'root',
            mode => 0755,
            source => 'puppet:///modules/wikidata_multi/scripts/git-pull-all';

        "/home/root/.my.cnf":
            ensure => present,
            owner => 'root',
            group => 'root',
            mode => 0700,
            source => 'puppet:///modules/wikidata_multi/mysql/my.cnf';

        "/etc/apache2/sites-available/enwiki":
            ensure => present,
            owner => 'root',
            group => 'root',
            mode => '0644',
            source => 'puppet:///modules/wikidata_multi/apache/enwiki';

        "/etc/apache2/sites-available/enwikivoyage":
            ensure => present,
            owner => 'root',
            group => 'root',
            mode => '0644',
            source => 'puppet:///modules/wikidata_multi/apache/enwikivoyage';

        "/srv/static/pagelist.txt":
            ensure => present,
            owner => 'root',
            group => 'root',
            mode => 0755,
            source => 'puppet:///modules/wikidata_multi/config/pagelist.txt';
    }

    git::clone { 'mediawiki':
        ensure    => present,
        directory => '/srv/mediawiki/master',
        branch => 'master',
        timeout => 1800,
        origin => 'https://gerrit.wikimedia.org/r/p/mediawiki/core.git';
    }

    git::clone { 'mediawiki-config':
        ensure => present,
        directory => '/srv/mediawiki-config',
        branch => 'master',
        timeout => 1800,
        origin => 'https://gerrit.wikimedia.org/r/p/operations/mediawiki-config.git';
    }

    mw-extension { [ 'AbuseFilter', 'AccountAudit', 'ActiveAbstract', 'AntiBot', 'AntiSpoof', 'ApiSandbox', 'ArticleFeedback', 'ArticleFeedbackv5', 'Ask', 'AssertEdit', 'Babel', 'Bootstrap', 'Calendar', 'Campaigns', 'CategoryTree', 'CentralAuth', 'CentralNotice', 'CharInsert', 'CheckUser', 'Cite', 'cldr', 'ClickTracking', 'ClientSide', 'CodeEditor', 'CodeReview', 'Collection', 'CommunityApplications', 'CommunityHiring', 'CommunityVoice', 'ConfirmEdit', 'ContactPage', 'ContactPageFundraiser', 'ContributionReporting', 'ContributionTracking', 'CoreEvents', 'CreditsSource', 'CustomData', 'CustomUserSignup', 'DataTypes', 'DataValues', 'Diff', 'DisableAccount', 'Disambiguator', 'DismissableSiteNotice', 'DonationInterface', 'DoubleWiki', 'DynamicSidebar', 'Echo', 'EditPageTracking', 'EducationProgram', 'EmailCapture', 'EventLogging', 'ExpandTemplates', 'ExtensionDistributor', 'FeaturedFeeds', 'FlaggedRevs', 'FormPreloadPostCache', 'FundraiserLandingPage', 'Gadgets', 'GeoCrumbs', 'GeoData', 'GettingStarted', 'GlobalBlocking', 'GlobalUsage', 'GoogleNewsSitemap', 'GuidedTour', 'ImageMap', 'InputBox', 'Insider', 'intersection', 'Interwiki', 'LabeledSectionTransclusion', 'LandingCheck', 'LastModified', 'LdapAuthentication', 'LiquidThreads', 'Listings', 'LocalisationUpdate', 'MapSources', 'MarkAsHelpful', 'Math', 'MobileFrontend', 'MoodBar', 'MwEmbedSupport', 'MWSearch', 'Narayam', 'NavigationTiming', 'NewUserMessage', 'normal', 'Nostalgia', 'Nuke', 'OAI', 'OATHAuth', 'OggHandler', 'OpenSearchXml', 'OpenStackManager', 'Oversight', 'PagedTiffHandler', 'PageImages', 'PageTriage', 'ParserFunctions', 'Parsoid', 'PdfHandler', 'Poem', 'PoolCounter', 'PostEdit', 'ProofreadPage', 'Quiz', 'RandomRootPage', 'ReaderFeedback', 'RelatedArticles', 'RelatedSites', 'Renameuser', 'RSS', 'Score', 'Scribunto', 'SearchExtraNS', 'SecurePoll', 'SemanticForms', 'SemanticMediaWiki', 'SemanticResultFormats', 'Serialization', 'ShortUrl', 'SimpleAntiSpam', 'SiteMatrix', 'SkinPerPage', 'skins', 'Solarium', 'SpamBlacklist', 'StrategyWiki', 'SubPageList3', 'SubpageSortkey', 'SwiftCloudFiles', 'SyntaxHighlight_GeSHi', 'TemplateData', 'TemplateSandbox', 'Thanks', 'TimedMediaHandler', 'timeline', 'TitleBlacklist', 'TitleKey', 'TocTree', 'TorBlock', 'Translate', 'TranslationNotifications', 'TrustedXFF', 'UnicodeConverter', 'UniversalLanguageSelector', 'UploadBlacklist', 'UploadWizard', 'UserDailyContribs', 'UserMerge', 'UserThrottle', 'Validator', 'Vector', 'VipsScaler', 'VisualEditor', 'WebFonts', 'Wikibase', 'WikibaseDataModel', 'WikibaseQuery', 'WikibaseQueryEngine', 'WikiEditor', 'wikihiero', 'WikiLove', 'WikimediaIncubator', 'WikimediaMaintenance', 'WikimediaMessages', 'WikimediaShopLink', 'ZeroRatedMobileAccess' ]:
        ensure => $ensure,
        }

    apache_site { 'enwiki':
        name => 'enwiki',
    }

    apache_site { 'enwikivoyage':
        name => 'enwikivoyage',
    }

    apache_module { 'rewrite':
        name => 'rewrite',
    }

    exec { 'apache_restart':
        command => '/usr/sbin/service apache2 restart',
        require => [ Apache_module['rewrite'], Apache_site['enwiki'], Apache_site['enwikivoyage'] ],
    }

    service { memcached:
        require => Package[memcached],
        enable     => true,
        ensure => running;
    }

    file {
        '/srv/mediawiki/master/LocalSettings.php':
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/config/LocalSettings.php';

        '/srv/mediawiki/master/static':
            ensure => 'link',
            target => '/srv/static';
    }

    exec { 'dbsetup':
        require => [ File["/usr/local/bin/dbsetup"], File["/srv/config/all.dblist"] ],
        command => "/usr/local/bin/dbsetup /srv/config/all.dblist master"
    }

    exec { "git_pull_all":
        require => [ File["/usr/local/bin/git-pull-all"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/local/bin/git-pull-all"
    }

    exec { "git_pull_extensions":
        require => [ File["/usr/local/bin/git-pull-all"] ],
        cwd => "/srv/mediawiki/master/extensions",
        command => "/usr/local/bin/git-pull-all"
    }

    exec { "delete_sites_enwiki":
        command => "/usr/bin/mysql -u root -D enwiki -e 'DELETE FROM sites; DELETE FROM site_identifiers;'"
    }

    exec { "delete_sites_enwikivoyage":
        command => "/usr/bin/mysql -u root -D enwikivoyage -e 'DELETE FROM sites; DELETE FROM site_identifiers;'"
    }

    exec { "populate_sites_enwiki":
        require => [ Exec["delete_sites_enwiki"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php extensions/Wikibase/lib/maintenance/populateSitesTable.php --wiki enwiki"
    }

    exec { "populate_sites_enwikivoyage":
        require => [ Exec["delete_sites_enwikivoyage"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php extensions/Wikibase/lib/maintenance/populateSitesTable.php --wiki enwikivoyage"
    }

    exec { "delete_mainpage_enwiki":
        require => [ File["/srv/static/pagelist.txt"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/deleteBatch.php --wiki enwiki --listfile /srv/static/pagelist.txt",
        logoutput => "on_failure",
    }

    exec { "delete_mainpage_enwikivoyage":
        require => [ File["/srv/static/pagelist.txt"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/deleteBatch.php --wiki enwikivoyage --listfile /srv/static/pagelist.txt",
        logoutput => "on_failure",
    }

    exec { "import_mainpage_enwiki":
        require => [ File["/srv/static/mainpage.xml"], Exec["delete_mainpage_enwiki"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/importDump.php --wiki enwiki /srv/static/mainpage.xml",
        logoutput => "on_failure",
    }

    exec { "import_mainpage_enwikivoyage":
        require => [ File["/srv/static/mainpage.xml"], Exec["delete_mainpage_enwikivoyage"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/importDump.php --wiki enwikivoyage /srv/static/mainpage.xml",
        logoutput => "on_failure",
    }

}

define wikidata_multi::mw-extension(
        $ensure = present,
        $branch = 'master',
        $install_path = '/srv/mediawiki/master',
) {
        git::clone { $name:
            require => Git::Clone['mediawiki'],
            directory => "${install_path}/extensions/${name}",
            origin    => "https://gerrit.wikimedia.org/r/p/mediawiki/extensions/${name}.git",
            branch    => $branch,
            ensure    => $ensure,
        }
}

class wikidata_test::setup() {

   file {
        "/srv/mediawiki/master/cache/l10n":
            owner => 'root',
            group => 'www-data',
            mode => 0755,
            ensure => directory,
            require => git::clone["mediawiki"];

        "/tmp/mw-cache-master":
            owner => 'root',
            group => 'www-data',
            mode => 0755,
            ensure => directory;

        "/srv/static/mainpage.txt":
            ensure => present,
            source => 'puppet:///modules/wikidata_test/static/mainpage.txt';

        "/srv/scripts":
            owner => 'root',
            group => 'www-data',
            mode => 0755,
            ensure => directory;

        "/srv/scripts/mainpage.php":
            ensure => present,
            owner => 'root',
            group => 'www-data',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/scripts/mainpage.php';

        "/srv/static/simple-elements.xml":
            ensure => present,
            owner => 'root',
            group => 'www-data',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/static/simple-elements.xml';
    }

    define setupmainpage {
        exec { "create_mainpage_${title}":
            require => [ Exec["composer-update-WikidataBuild"], File["/srv/static/mainpage.txt"], File["/srv/scripts/mainpage.php"] ],
            cwd => "/srv/scripts",
            command => "/usr/bin/php mainpage.php --wiki ${title}",
            logoutput => "on_failure";
        }
    }

    setupmainpage { ['enwiki', 'enwikivoyage', 'enwikisource']: }

    exec { "merge_messages":
        require => [ Exec["composer-update-WikidataBuild"], File["/srv/config/CommonSettings.php"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/mergeMessageFileList.php --wiki enwiki --list-file /srv/mediawiki-config/wmf-config/extension-list --output /srv/config/ExtensionMessages.php",
        logoutput => "on_failure";
    }

    exec { "rebuild_localisation":
        require => [ Exec["merge_messages"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/rebuildLocalisationCache.php --wiki enwiki",
        timeout => 1800,
        logoutput => "on_failure";
    }

    define populatesitestable {
        exec { "populate_sites_${title}":
            require => [ Exec["rebuild_localisation"] ],
            cwd => "/srv/mediawiki/master",
            command => "/usr/bin/php maintenance/runScript.php extensions/WikidataBuild/extensions/Wikibase/lib/maintenance/populateSitesTable.php --wiki ${title}",
            timeout => 600,
            logoutput => "on_failure";
        }
    }

    populatesitestable { ['enwiki', 'enwikivoyage', 'enwikisource', 'wikidatawiki']: }

    exec { "import_interlang":
        require => [ Exec["rebuild_localisation"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/runScript.php extensions/WikidataBuild/extensions/Wikibase/repo/maintenance/importInterlang.php --wiki wikidatawiki --ignore-errors simple extensions/WikidataBuild/extensions/Wikibase/repo/maintenance/simple-elements.csv",
        timeout => 1800,
        logoutput => "on_failure";
    }

    exec { "import_properties":
        require => [ Exec["import_interlang"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/runScript.php extensions/WikidataBuild/extensions/Wikibase/repo/maintenance/importProperties.php --wiki wikidatawiki en extensions/WikidataBuild/extensions/Wikibase/repo/maintenance/en-elements-properties.csv",
        timeout => 1800,
        logoutput => "on_failure";
    }

    exec { "import_elements":
        require => [ File["/srv/static/simple-elements.xml"], Exec["import_properties"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/importDump.php --wiki enwiki /srv/static/simple-elements.xml",
        timeout => 1800,
        logoutput => "on_failure";
    }

}

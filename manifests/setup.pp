class wikidata_multi::setup() {

   file {
        "/srv/mediawiki/master/cache/l10n":
            owner => 'mwdeploy',
            group => 'www-data',
            mode => 0755,
            ensure => directory;

        "/tmp/mw-cache-master":
            owner => 'mwdeploy',
            group => 'www-data',
            mode => 0755,
            ensure => directory;

        "/srv/static/mainpage.xml":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/static/mainpage.xml';

        "/srv/static/pagelist.txt":
            ensure => present,
            owner => 'mwdeploy',
            group => 'www-data',
            mode => 0755,
            source => 'puppet:///modules/wikidata_multi/config/pagelist.txt';

        "/srv/static/simple-elements.xml":
            ensure => present,
            owner => 'mwdeploy',
            group => 'www-data',
            mode => 0755,
            source => 'puppet:///modules/wikidata_multi/static/simple-elements.xml';
    }

    define setupmainpage {
        exec { "delete_mainpage_${title}":
            require => [ File["/srv/static/pagelist.txt"], Git::Clone["mwextensions"] ],
            cwd => "/srv/mediawiki/master",
            command => "/usr/bin/php maintenance/deleteBatch.php --wiki ${title} --listfile /srv/static/pagelist.txt",
            logoutput => "on_failure",
        }

        exec { "import_mainpage_${title}":
            require => [ File["/srv/static/mainpage.xml"], Exec["delete_mainpage_${title}"] ],
            cwd => "/srv/mediawiki/master",
            command => "/usr/bin/php maintenance/importDump.php --wiki ${title} /srv/static/mainpage.xml",
            logoutput => "on_failure",
        }
    }

    setupmainpage { ['enwiki', 'enwikivoyage', 'enwikisource']: }

    exec { "merge_messages":
        require => [ Git::Clone["mwextensions"], File["/srv/config/CommonSettings.php"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/mergeMessageFileList.php --wiki enwiki --list-file /srv/mediawiki-config/wmf-config/extension-list --output /srv/config/ExtensionMessages.php",
        logoutput => "on_failure"
    }

    exec { "rebuild_localisation":
        require => [ Exec["merge_messages"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/rebuildLocalisationCache.php --wiki enwiki",
        timeout => 1800,
        logoutput => "on_failure"
    }

    exec { "import_interlang":
        require => [ Exec["rebuild_localisation"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/runScript.php extensions/Wikidata/Wikibase/repo/maintenance/importInterlang.php --wiki wikidatawiki --ignore-errors simple extensions/Wikidata/Wikibase/repo/maintenance/simple-elements.csv",
        timeout => 1800,
        logoutput => "on_failure"
    }

    exec { "import_properties":
        require => [ Exec["import_interlang"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/runScript.php extensions/Wikidata/Wikibase/repo/maintenance/importProperties.php --wiki wikidatawiki en extensions/Wikidata/Wikibase/repo/maintenance/en-elements-properties.csv",
        timeout => 1800,
        logoutput => "on_failure"
    }

    exec { "import_elements":
        require => [ File["/srv/static/simple-elements.xml"], Exec["import_properties"] ],
        cwd => "/srv/mediawiki/master",
        command => "/usr/bin/php maintenance/importDump.php --wiki enwiki /srv/static/simple-elements.xml",
        timeout => 1800,
        logoutput => "on_failure"
    }

}

class wikidata_test::setup() {

   file {
        "/srv/mediawiki/master/cache/l10n":
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            ensure => directory,
            require => git::clone["mediawiki"];

        "/tmp/mw-cache-master":
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            ensure => directory;

        "/srv/static/mainpage.txt":
            ensure => present,
            source => 'puppet:///modules/wikidata_test/static/mainpage.txt';

        "/srv/scripts":
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            ensure => directory;

        "/srv/scripts/mainpage.php":
            ensure => present,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/scripts/mainpage.php';

        "/srv/static/simple-elements.xml":
            ensure => present,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/static/simple-elements.xml';
    }

    file {
        "/usr/local/bin/foreachwiki":
            ensure => present,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/scripts/foreachwiki';
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

    file {
        "/usr/local/bin/wikibasesetup":
            ensure => present,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/scripts/wikibasesetup';
    }

    exec { 'wikibasesetup':
        require => [ File["/usr/local/bin/wikibasesetup"], File["/srv/config/all.dblist"] ],
        command => "/usr/local/bin/wikibasesetup /srv/config/all.dblist master"
    }

}

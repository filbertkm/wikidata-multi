class wikidata_test::setup(
  $base_dir
) {

   require wikidata_test::composer

   file {
        "${base_dir}/php-master/cache/l10n":
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

        "${base_dir}/static/mainpage.txt":
            ensure => present,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/static/mainpage.txt';

        "${base_dir}/scripts":
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            ensure => directory;

        "${base_dir}/scripts/mainpage.php":
            ensure => present,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/scripts/mainpage.php';

        "${base_dir}/static/simple-elements.xml":
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

    define setupmainpage(
        $base_dir
    ) {
        exec { "create_mainpage_${title}":
            require => [ File["${base_dir}/scripts/mainpage.php", "${base_dir}/static/mainpage.txt"] ],
            cwd => "${base_dir}/scripts",
            command => "/usr/bin/php mainpage.php --wiki ${title}",
            logoutput => "on_failure";
        }
    }

    setupmainpage { ['enwiki', 'enwikivoyage', 'enwikisource']:
        base_dir => $base_dir;
    }

    exec { "merge_messages":
        require => [ Class['wikidata_test::composer'], File["${base_dir}/config/CommonSettings.php"] ],
        cwd => "${base_dir}/php-master",
        command => "/usr/bin/php maintenance/mergeMessageFileList.php --wiki enwiki --list-file ${base_dir}/mediawiki-config/wmf-config/extension-list --output ${base_dir}/config/ExtensionMessages.php",
        logoutput => "on_failure";
    }

    exec { "rebuild_localisation":
        require => [ Exec["merge_messages"] ],
        cwd => "${base_dir}/php-master",
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
        require => [ File["/usr/local/bin/wikibasesetup"], File["${base_dir}/config/all.dblist"] ],
        command => "/usr/local/bin/wikibasesetup ${base_dir}/config/all.dblist master"
    }

}

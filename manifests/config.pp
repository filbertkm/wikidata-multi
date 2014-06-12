class wikidata_test::config(
    $base_dir
) {

    sudo_user { 'mwdeploy' :
        privileges => [
            'ALL = (apache,mwdeploy,www-data) NOPASSWD: ALL',
        ]
    }

    file {
        "${base_dir}/config":
            owner => 'mwdeploy',
            group => 'mwdeploy',
            mode => 0675,
            ensure => directory;
    }

    $configs = ['CommonSettings.php', 'DebugSettings.php', 'SiteSettings.php',
'ExtensionSettings.php', 'flaggedrevs.php', 'DBSettings.php', 'Wikibase.php']

    define configfiles(
        $base_dir
    ) {
        file { "${base_dir}/config/${title}":
            ensure => present,
            owner => 'mwdeploy',
            group => 'mwdeploy',
            source => "puppet:///modules/wikidata_test/config/${title}";
        }
    }

    configfiles { $configs:
        base_dir => $base_dir;
    }

    file {
        "${base_dir}/config/LocalSettings.php":
            ensure => present,
            source => 'puppet:///modules/wikidata_test/config/LocalSettings.php';
    }

    git::clone { 'mediawiki-config':
        ensure => latest,
        directory => "${base_dir}/mediawiki-config",
        owner => 'mwdeploy',
        group => 'mwdeploy',
        branch => 'master',
        timeout => 1800,
        origin => 'https://gerrit.wikimedia.org/r/p/operations/mediawiki-config.git';
    }

}

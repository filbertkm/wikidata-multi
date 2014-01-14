class wikidata_multi::config() {

    file {
        "/srv/config":
            owner => 'mwdeploy',
            group => 'root',
            mode => 0664,
            ensure => directory;
    }

    $configs = ['CommonSettings.php', 'DebugSettings.php', 'SiteSettings.php',
'ExtensionSettings.php', 'flaggedrevs.php', 'DBSettings.php', 'Wikibase.php']

    define configfiles {
        file { "/srv/config/${title}":
            ensure => present,
            source => "puppet:///modules/wikidata_multi/config/${title}";
        }
    }

    configfiles { $configs: }

    file {
        '/srv/config/LocalSettings.php':
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/config/LocalSettings.php';
    }

    git::clone { 'mediawiki-config':
        ensure => present,
        directory => '/srv/mediawiki-config',
        owner => 'root',
        group => 'mwdeploy',
        branch => 'master',
        timeout => 1800,
        origin => 'https://gerrit.wikimedia.org/r/p/operations/mediawiki-config.git';
    }

}

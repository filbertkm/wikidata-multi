class wikidata_test::config() {

    file {
        "/srv/config":
            owner => 'root',
            group => 'www-data',
            mode => 0675,
            ensure => directory;
    }

    $configs = ['CommonSettings.php', 'DebugSettings.php', 'SiteSettings.php',
'ExtensionSettings.php', 'flaggedrevs.php', 'DBSettings.php', 'Wikibase.php', 'extension-list-wikidata']

    define configfiles {
        file { "/srv/config/${title}":
            ensure => present,
            owner => 'root',
            group => 'www-data',
            source => "puppet:///modules/wikidata_test/config/${title}";
        }
    }

    configfiles { $configs: }

    file {
        '/srv/config/LocalSettings.php':
            ensure => present,
            source => 'puppet:///modules/wikidata_test/config/LocalSettings.php';
    }

    git::clone { 'mediawiki-config':
        ensure => present,
        directory => '/srv/mediawiki-config',
        owner => 'root',
        group => 'www-data',
        branch => 'master',
        timeout => 1800,
        origin => 'https://gerrit.wikimedia.org/r/p/operations/mediawiki-config.git';
    }

}

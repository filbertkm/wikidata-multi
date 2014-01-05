class wikidata_multi::setup() {

   file {
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

        "/srv/static/mainpage.xml":
            ensure => present,
            source => 'puppet:///modules/wikidata_multi/static/mainpage.xml';

        "/srv/static/pagelist.txt":
            ensure => present,
            owner => 'root',
            group => 'root',
            mode => 0755,
            source => 'puppet:///modules/wikidata_multi/config/pagelist.txt';
    }

    define setupmainpage {
        exec { "delete_mainpage_${title}":
            require => [ File["/srv/static/pagelist.txt"] ],
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

}

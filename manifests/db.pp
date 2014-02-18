class wikidata_test::db() {

    require wikidata_test::config

    file {
        "/srv/config/all.dblist":
            ensure => present,
            source => 'puppet:///modules/wikidata_test/config/all.dblist';

        "/usr/local/bin/dbsetup":
            ensure => present,
            owner => 'root',
            group => 'root',
            mode => 0755,
            source => 'puppet:///modules/wikidata_test/scripts/dbsetup';
    }

    exec { 'dbsetup':
        require => [ File["/usr/local/bin/dbsetup"], File["/srv/config/all.dblist"] ],
        command => "/usr/local/bin/dbsetup /srv/config/all.dblist master"
    }

}

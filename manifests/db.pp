class wikidata_test::db(
    $base_dir
) {

    require wikidata_test::config

    file {
        "${base_dir}/config/all.dblist":
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
        require => [ File["/usr/local/bin/dbsetup"], File["${base_dir}/config/all.dblist"] ],
        command => "/usr/local/bin/dbsetup ${base_dir}/config/all.dblist master"
    }

}

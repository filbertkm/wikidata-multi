class wikidata_test::mediawiki(
    $base_dir
) {

    if !defined(Class['webserver::php5']) {
        class {'webserver::php5':
            ssl => true;
        }
    }

    require role::labs-mysql-server, webserver::php5-mysql

    package { [ 'imagemagick', 'php-apc', 'memcached' ] :
        ensure => latest,
    }

    git::clone { 'mediawiki':
        ensure    => latest,
        directory => "${base_dir}/php-master",
        branch => 'master',
        owner => 'mwdeploy',
        group => 'mwdeploy',
        timeout => 1800,
        origin => 'https://gerrit.wikimedia.org/r/p/mediawiki/core.git';
    }

    file {
        "${base_dir}/php-master/static":
            ensure => 'link',
            target => "${base_dir}/static";

        "${base_dir}/php-master/LocalSettings.php":
            ensure => 'link',
            target => "${base_dir}/config/LocalSettings.php";
    }

    service { memcached:
        require => Package[memcached],
        enable     => true,
        ensure => running;
    }

}

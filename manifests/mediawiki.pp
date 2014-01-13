class wikidata_multi::mediawiki() {

    if !defined(Class['webserver::php5']) {
        class {'webserver::php5':
            ssl => true;
        }
    }

    require role::labs-mysql-server, webserver::php5-mysql

    package { [ 'imagemagick', 'php5-cli', 'php-apc', 'memcached' ] :
        ensure => latest,
    }

    git::clone { 'mediawiki':
        ensure    => latest,
        directory => '/srv/mediawiki/master',
        branch => 'master',
        owner => 'mwdeploy',
        group => 'www-data',
        timeout => 1800,
        origin => 'https://gerrit.wikimedia.org/r/p/mediawiki/core.git';
    }

    file {
        '/srv/mediawiki/master/static':
            ensure => 'link',
            target => '/srv/static';

        '/srv/mediawiki/master/LocalSettings.php':
            ensure => 'link',
            target => '/srv/config/LocalSettings.php';
    }

    service { memcached:
        require => Package[memcached],
        enable     => true,
        ensure => running;
    }

}

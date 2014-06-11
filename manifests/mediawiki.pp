class wikidata_test::mediawiki() {

    if !defined(Class['webserver::php5']) {
        class {'webserver::php5':
            ssl => true;
        }
    }

    require role::labs-mysql-server, webserver::php5-mysql, composer

    package { [ 'imagemagick', 'php-apc', 'memcached' ] :
        ensure => latest,
    }

    file {
        "/srv/common":
            owner => 'root',
            group => 'root',
            ensure => directory;
    }

    sudo_user { 'mwdeploy' :                                                                           
        privileges => [                                                                                
            'ALL = (apache,mwdeploy,www-data) NOPASSWD: ALL',                                        
        ]                                                                                              
    } 

    git::clone { 'mediawiki':
        ensure    => latest,
        directory => '/srv/common/php-master',
        branch => 'master',
        owner => 'mwdeploy',
        group => 'mwdeploy',
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

class wikidata_multi::apache() {

    define wikidata_multi::apachesite () {
        file { "/etc/apache2/sites-available/${title}":
            ensure => present,
               owner => 'root',
               group => 'root',
               mode => '0644',
               source => "puppet:///modules/wikidata_multi/apache/${title}";
        }

        apache_site { "${title}":
           name => "${title}",
        }
    }

    wikidata_multi::apachesite { ['enwiki', 'enwikivoyage', 'enwikisource', 'wikidatawiki', 'testhome']: }

    apache_module { 'rewrite':
        name => 'rewrite',
    }

    exec { 'apache_restart':
        command => '/usr/sbin/service apache2 restart',
        require => [ Apache_module['rewrite'], Apache_site['enwiki'], Apache_site['enwikivoyage'], Apache_site['wikidatawiki'], Apache_site['enwikisource'], Apache_site['testhome'] ],
    }

}

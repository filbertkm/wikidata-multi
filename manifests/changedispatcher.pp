class wikidata_test::changedispatcher() {

    file { "/var/log/wikidata":
        owner => 'root',
        group => 'www-data',
        mode => 0755,
        ensure => directory,
    }

    cron { "cron-dispatchchanges":
        command => '/usr/bin/php maintenance/runScript.php extensions/WikidataBuild/extensions/Wikibase/lib/maintenance/dispatchChanges.php --wiki wikidatawiki --max-time 900 --batch-size 200 --dispatch-interval 30 2>&1 >> /var/log/wikidata/dispatcher.log',
        user    => 'root',
        minute  => '*/4',
        ensure   => present;
    }

    define runjobs {
        cron { "runjobs_${title}":
            command => "/usr/bin/php maintenance/runJobs.php --wiki ${title} 2>&1 >> /var/log/wikidata/runjobs-${title}",
            user => 'root',
            minute => '*/5',
            ensure => present;
        }
    }

    runjobs { ['enwiki', 'enwikivoyage', 'enwikisource']: }

}

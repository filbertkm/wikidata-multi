class wikidata_test::changedispatcher(
    $base_dir
) {

    file { "/var/log/wikidata":
        owner => 'mwdeploy',
        group => 'mwdeploy',
        mode => 0755,
        ensure => directory,
    }

    cron { "cron-dispatchchanges":
        command => "/usr/bin/php ${base_dir}/maintenance/runScript.php extensions/WikidataBuild/extensions/Wikibase/lib/maintenance/dispatchChanges.php --wiki wikidatawiki --max-time 900 --batch-size 200 --dispatch-interval 30 2>&1 >> /var/log/wikidata/dispatcher.log",
        user    => 'mwdeploy',
        minute  => '*/4',
        ensure   => present;
    }

    define runjobs(
        $base_dir
    ) {
        cron { "runjobs_${title}":
            command => "/usr/bin/php ${base_dir}/maintenance/runJobs.php --wiki ${title} 2>&1 >> /var/log/wikidata/runjobs-${title}",
            user => 'mwdeploy',
            minute => '*/5',
            ensure => present;
        }
    }

    runjobs { ['enwiki', 'enwikivoyage', 'enwikisource']:
        base_dir => $base_dir;
    }

}

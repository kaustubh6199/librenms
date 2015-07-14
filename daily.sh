#!/bin/bash

cd $(dirname $0) || exit 1

if [ $(php daily.php -f update) -eq 1 ]; then 
  git pull --quiet
  php includes/sql-schema/update.php
fi

php daily.php -f syslog
php daily.php -f eventlog
php daily.php -f authlog
php daily.php -f perf_times 
php daily.php -f callback
php daily.php -f device_perf

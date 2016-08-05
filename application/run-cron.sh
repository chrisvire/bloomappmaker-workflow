#!/usr/bin/env bash

if [[ "x" == "x$LOGENTRIES_KEY" ]]; then
    echo "Missing LOGENTRIES_KEY environment variable";
else
    # Set logentries key based on environment variable
    sed -i /etc/rsyslog.conf -e "s/LOGENTRIESKEY/${LOGENTRIES_KEY}/"
    # Start syslog
    rsyslogd
fi

# fix folder permissions
chown -R www-data:www-data \
  /data/console/runtime/ \
  /data/frontend/assets/ \
  /data/frontend/runtime/ \
  /data/frontend/web/assets/

# make sure rsyslog can read logentries cert
chmod a+r /opt/ssl/logentries.all.crt

# Dump env to a file
touch /etc/cron.d/bloomappmaker
env | while read line ; do
   if [[ "${line: -1}" != "=" ]] 
   then
     echo "$line" >> /etc/cron.d/bloomappmaker
   fi
done

# Add env vars to doorman-cron to make available to scripts
cat /etc/cron.d/bloomappmaker-cron >> /etc/cron.d/bloomappmaker

# Remove original cron file without env vars
rm -f /etc/cron.d/bloomappmaker-cron

# Start cron daemon
cron -f

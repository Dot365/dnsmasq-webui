#!/bin/sh

target=/var/www/html/storage/app/dnsmasq

interval=1

while true; do
    changes=$(find ${target} -mmin -${interval})

    if [ ${#changes} -ne 0 ]; then
        date
        supervisorctl restart dnsmasq
    fi

    sleep ${interval}m
done

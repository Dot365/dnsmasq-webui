FROM maoxuner/php:7.3-customed

RUN set -ex \
    && apk add --no-cache \
        dnsmasq \
        composer \
    && curl -sL https://github.com/maoxuner/dnsmasq-configure-generator/archive/master.tar.gz | tar xzf - --strip-components=1 \
    && composer install \
    && composer run-script post-root-package-install \
    && composer run-script post-create-project-cmd \
    && sed -i '/^APP_ENV/ s/local/production/g' .env \
    && touch database/database.sqlite \
    && php artisan migrate --seed --force \
    && chown www-data:www-data * -R \
    && ln -sf /var/www/html/storage/app/dnsmasq/resolv.conf /etc/dnsmasq.d/resolv.conf \
    && ln -sf /var/www/html/storage/app/dnsmasq/resolv /etc/dnsmasq.d/resolv \
    && ln -sf /var/www/html/storage/app/dnsmasq/addn-hosts.conf /etc/dnsmasq.d/addn-hosts.conf \
    && ln -sf /var/www/html/storage/app/dnsmasq/hosts /etc/dnsmasq.d/hosts \
    && ln -sf /var/www/html/storage/app/dnsmasq/records.conf /etc/dnsmasq.d/records.conf

ENV NGINX_CONFIG=docker/nginx \
    SUPERVISOR_CONFIG=docker/supervisor

EXPOSE 53 53/udp

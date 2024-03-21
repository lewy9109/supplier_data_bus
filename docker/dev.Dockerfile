FROM bus_supplier-base:1.0
####################
##     XDEBUG     ##
####################

ARG WITH_XDEBUG="true"
RUN set -eux; \
    if [ $WITH_XDEBUG = "true" ] ; then \
        pecl install xdebug-3.2.1; \
        docker-php-ext-enable xdebug; \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.mode=debug,develop,coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi ;

####################

# Install netcat for wait-for script
RUN apt-get -q update && apt-get -qy install \
    imagemagick libfreetype6-dev libjpeg62-turbo-dev libgd-dev libjpeg-dev libpng-dev libonig-dev \
    libmagickwand-dev libxml2-dev libxslt-dev librabbitmq-dev libssh2-1-dev libssh2-1 \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && pecl install ssh2 \
    && docker-php-ext-enable ssh2 \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && rm -rf /var/lib/apt/lists/*
#
## Expose the port nginx is reachable on
#EXPOSE 80
#
## Configure nginx
#COPY docker/etc/nginx/nginx.conf /etc/nginx/nginx.conf
#COPY docker/etc/nginx/conf.d/service.conf /etc/nginx/conf.d/service.conf
#
## Configure PHP-FPM
#COPY docker/etc/php/php.ini-development /usr/local/etc/php/php.ini
#COPY docker/etc/php/conf.d/* /usr/local/etc/php/conf.d/
#COPY docker/etc/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
#
## Configure supervisord
#COPY docker/etc/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
#
## Create cache directory for named volume
#RUN mkdir -p /var/www/html/var/cache \
#  && mkdir -p /var/www/html/var/log \
#  && chown -R www-data:www-data /var/www/html/var

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
# HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:80/fpm-ping

ENV XDEBUG_CONFIG="idekey=PHPSTORM"
ENV PHP_IDE_CONFIG="serverName=php_cli"

RUN PATH=$PATH:/var/www/html/vendor/bin:bin
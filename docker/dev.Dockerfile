FROM bus_supplier:2.0
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

# Configure nginx
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/nginx.d/service.conf /etc/nginx/conf.d/service.conf

## Configure PHP-FPM
COPY docker/php/php.ini-development /usr/local/etc/php/php.ini
COPY docker/php/conf.d/* /usr/local/etc/php/conf.d/
COPY docker/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

# Create cache directory for named volume
RUN mkdir -p /var/www/html/var/cache \
  && mkdir -p /var/www/html/var/log \
  && chown -R www-data:www-data /var/www/html/var

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Expose ports
EXPOSE 80

# Configure a healthcheck to validate that everything is up&running
# HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:80/fpm-ping

ENV XDEBUG_CONFIG="idekey=PHPSTORM"
ENV PHP_IDE_CONFIG="serverName=php_cli"

RUN PATH=$PATH:/var/www/html/vendor/bin:bin
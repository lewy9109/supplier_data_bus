FROM php:8.1-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data


RUN apt-get update \
    && apt-get install -y \
        zlib1g-dev \
        vim\
        g++ \
        git \
        libssl-dev \
        libicu-dev \
        nginx \
        supervisor \
        zip \
        libzip-dev \
        libxml2-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql bcmath \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install soap \
    && docker-php-ext-enable soap

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure nginx
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/nginx.d/service.conf /etc/nginx/conf.d/service.conf

# Configure supervisord
COPY docker/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure PHP-FPM
#COPY docker/etc/php/php.ini-development /usr/local/etc/php/php.ini
#COPY docker/etc/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

# Make sure files/folders needed by the processes are accessable when they run under the www-data user
RUN chown -R www-data:www-data /var/www \
    && chown -R www-data:www-data /run \
    && chown -R www-data:www-data /var/lib/nginx \
    && chown -R www-data:www-data /etc/supervisor \
    && chown -R www-data:www-data /var/log/nginx



# Set the working directory
WORKDIR /var/www/html

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Expose ports
EXPOSE 80

RUN PATH=$PATH:/var/www/html/vendor/bin:bin
FROM php:8.2 as php

RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
    unzip \
    libpq-dev \
    libcurl4-gnutls-dev \
    curl \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libwebp-dev \
    libxpm-dev \
    libmcrypt-dev \
    libonig-dev; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    # Install the PHP pdo extention
    docker-php-ext-install pdo; \
    # Install the PHP pdo_mysql extention
    docker-php-ext-install pdo_mysql; \
    # Install the PHP pdo_pgsql extention
    docker-php-ext-install pdo_pgsql; \
    # Install the PHP bcmath
    docker-php-ext-install bcmath; \
    # Install the PHP gd library
    docker-php-ext-configure gd \
    --prefix=/usr \
    --with-jpeg \
    --with-webp \
    --with-xpm \
    --with-freetype; \
    docker-php-ext-install gd; \
    php -r 'var_dump(gd_info());'




WORKDIR /var/www
COPY . .

# Copy composer from another image and install dependencies
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
#RUN composer install --no-dev --optimize-autoloader

# Set permissions and create storage link
RUN chown -R www-data:www-data storage \
    && php artisan storage:link


#for staging
ENV PORT=8000

RUN chmod a+x ./Docker/entrypoint.sh
ENTRYPOINT [ "sh", "./Docker/entrypoint.sh" ]


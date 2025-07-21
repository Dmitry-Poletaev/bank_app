FROM php:8.3-fpm
# Добавляем строки в конец файла www.conf
RUN echo "\npm = dynamic" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "pm.max_children = 10" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "pm.start_servers = 5" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "pm.min_spare_servers = 2" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "pm.max_spare_servers = 6" >> /usr/local/etc/php-fpm.d/www.conf

COPY --from=composer:2.2.7 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y --no-install-recommends\
    libintl-perl \
    libbz2-dev \
    libxml2-dev \
    libzip-dev \
    libzstd-dev \
    libmagickwand-dev \
    libmagickcore-dev \
    git \
    unzip \
    libffi-dev \
    libwebp-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libgmp-dev \
    supervisor \
    libicu-dev \
    libftp-dev \
    libpq-dev

RUN git clone https://github.com/Imagick/imagick.git --depth 1 /tmp/imagick && \
    cd /tmp/imagick && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    apt-get remove -y git && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/* /tmp/imagick && \
    docker-php-ext-enable imagick

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-webp --with-jpeg

RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    bz2 \
    calendar \
    pdo_mysql \
    pdo_pgsql \
    soap \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    zip \
    gettext \
    mysqli \
    exif \
    opcache \
    pcntl \
    gd \
    shmop \
    intl \
    ftp

RUN pecl install -o -f \
    --configureoptions 'enable-redis-igbinary="yes" enable-redis-lzf="yes" enable-redis-zstd="yes"' \
    igbinary \
    redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable igbinary redis

RUN docker-php-ext-configure ffi --with-ffi \
    && docker-php-ext-install ffi

# Устанавливаем xdebug
RUN pecl install xdebug-3.3.2 && docker-php-ext-enable xdebug

## Устанавливаем в качестве рабочей директории '/app'.
WORKDIR /var/www

CMD ["php-fpm"]
FROM php:8.3-fpm

ARG TZ='UTC'
ARG USER_GROUP
ARG USER_ID

# Установка зависимостей и расширений
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libonig-dev \
    chromium chromium-driver \
    libpq-dev \
    curl \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql pdo_mysql bcmath zip mbstring sockets \
    && docker-php-ext-enable gd pdo_pgsql pdo_mysql bcmath zip mbstring sockets

# Установка Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

RUN mkdir -p /var/www/var/chrome-sessions && chmod -R 777 /var/www/var/chrome-sessions

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && /usr/local/bin/composer self-update

# Настройка пользователя
USER 1000:1000

# Рабочая директория
WORKDIR /var/www/

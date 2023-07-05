# Базовый образ с PHP
FROM php:8.1-fpm

# Установка MySQL
RUN apt-get update && apt-get install -y \
    default-mysql-server \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Установка необходимых расширений PHP
RUN docker-php-ext-install pdo pdo_mysql

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Установка Node.js и NPM
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get update && apt-get install -y nodejs

# Установка гита
RUN apt-get update && apt-get install -y git

# Установка глобальных зависимостей для Laravel
RUN composer global require laravel/installer

# Директория для приложения
WORKDIR /var/www/html

# Копирование файла зависимостей приложения
COPY composer.json ./composer.json
COPY composer.lock ./composer.lock

RUN composer clear-cache

# Установка зависимостей Composer
RUN composer install

# Копирование остальных файлов приложения
COPY . .

# Запуск скрипта команды контейнера
CMD php artisan serve --host=0.0.0.0 --port=8000

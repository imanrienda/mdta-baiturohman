FROM php:8.1-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Laravel setup
RUN php artisan key:generate --force || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
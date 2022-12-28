FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    nano \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs



RUN chmod -R 777 storage bootstrap/cache

RUN cp .env.example .env

RUN sed -i 's/DB_HOST=.*/DB_HOST=db/' .env

RUN sed -i 's/DB_DATABASE=.*/DB_DATABASE=app/' .env

RUN sed -i 's/DB_USERNAME=.*/DB_USERNAME=app/' .env

RUN sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=secret/' .env

RUN php artisan key:generate

RUN php artisan jwt:secret
CMD ["php-fpm"]

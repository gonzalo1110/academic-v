FROM php:8.3-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl unzip zip \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev libicu-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

RUN docker-php-ext-install \
    pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' \
    /etc/apache2/apache2.conf

WORKDIR /var/www/html
EXPOSE 80

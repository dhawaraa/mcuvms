FROM php:8.4-apache

# ติดตั้ง extensions ที่จำเป็นสำหรับ PHP 8.4
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mysqli zip bcmath opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# เปิดใช้งาน mod_rewrite ของ Apache สำหรับรองรับ Routing / Clean URL
RUN a2enmod rewrite headers

# กำหนด DocumentRoot ชี้ไปที่ Laravel public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# ติดตั้ง Composer เพื่อจัดการ dependencies ของ Laravel
COPY --from=docker.io/library/composer:2 /usr/bin/composer /usr/bin/composer

EXPOSE 80


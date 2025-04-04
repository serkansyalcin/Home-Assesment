FROM php:8.2-fpm

# Sistem bağımlılıklarını yükle
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# PHP eklentilerini yükle
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer'ı yükle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Çalışma dizinini ayarla
WORKDIR /var/www

# Kullanıcı oluştur
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Uygulama dosyalarını kopyala
COPY . /var/www
COPY --chown=www:www . /var/www

# Kullanıcıyı değiştir
USER www

# Composer bağımlılıklarını yükle
RUN composer install

# Portu aç
EXPOSE 9000

CMD ["php-fpm"] 
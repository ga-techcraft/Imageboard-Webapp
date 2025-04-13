FROM php:8.2-fpm

# PHP拡張をインストール（MySQL用など）
RUN docker-php-ext-install pdo pdo_mysql

# Composerのインストール（オプション）
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 作業ディレクトリ設定
WORKDIR /var/www/html

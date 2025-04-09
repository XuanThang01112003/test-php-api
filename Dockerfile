# Base image PHP + Apache
FROM php:8.1-apache

# Cài extension pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Copy toàn bộ mã nguồn vào thư mục web server
COPY . /var/www/html/

# Mở port 80
EXPOSE 80

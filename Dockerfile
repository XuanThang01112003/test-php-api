# Base image PHP + Apache
FROM php:8.1-apache

# Copy toàn bộ code vào thư mục gốc của Apache
COPY . /var/www/html/

# Mở port 80
EXPOSE 80

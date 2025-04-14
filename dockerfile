FROM php:8.1-apache

# Instalar extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativar o módulo rewrite do Apache (opcional, útil se for usar URLs amigáveis)
RUN a2enmod rewrite

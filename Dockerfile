FROM php:7.2-apache

# Define as váriaveis do usuário e uid
ARG user
ARG uid

# Define o diretório de trabalho do apache
WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y git unzip libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Cria o usuário no container e adiciona ele ao grupo www-data
RUN useradd -G www-data -u $uid -d /home/$user $user

# Define como usuário padrão do container
USER $user

# Copia os arquivos do projeto para a pasta de trabalho do Apache
COPY . /var/www/html
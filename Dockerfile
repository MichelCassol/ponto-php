FROM php:7.2-apache

# Define as váriaveis do usuário e uid
ARG user
ARG uid

# Habilitar o módulo mod_rewrite
RUN a2enmod rewrite

# Define o diretório de trabalho do apache
WORKDIR /var/www/html/

RUN apt-get update \
    && apt-get install -y git unzip libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Define o DocumentRoot para a pasta 'public'
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Adicionar a linha 'AllowOverride All' no diretório da aplicação
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/sites-available/000-default.conf

# Cria o usuário no container e adiciona ele ao grupo www-data
RUN useradd -G www-data -u $uid -d /home/$user $user

# Define como usuário padrão do container
USER $user

# Copia os arquivos do projeto para a pasta de trabalho do Apache
COPY . /var/www/html

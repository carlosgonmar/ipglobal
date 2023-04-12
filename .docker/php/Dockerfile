FROM php:8.0-apache

RUN a2enmod rewrite
# Arguments defined in docker-compose.yml
COPY ./ /var/www/html
ARG user=user1
ARG uid=1000
# Basic install
RUN apt update -y && apt upgrade -y
RUN apt install nano wget git unzip bash zip libzip-dev -y
# Clear cache
RUN apt clean && rm -rf /var/lib/apt/lists/*
RUN pecl install zip
RUN docker-php-ext-enable zip
RUN docker-php-source delete
# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /var/www/html
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv -v composer.phar /usr/sbin/composer
# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv ~/.symfony5/bin/symfony /usr/sbin/symfony
# Instal node&npm
RUN cd /home/$user && wget https://nodejs.org/download/release/v14.21.3/node-v14.21.3-linux-arm64.tar.gz
RUN cd /home/$user && tar -xvf node-v14.21.3-linux-arm64.tar.gz
RUN ln -s /home/$user/node-v14.21.3-linux-arm64/bin/node /usr/sbin/node
#RUN ln -ls ~/node-v14.21.3-linux-arm64/bin/npm /usr/sbin/npm
RUN ln -s /home/$user/node-v14.21.3-linux-arm64/lib/node_modules/npm/bin/npm-cli.js /usr/sbin/npm
# Set working directory
USER $user
WORKDIR /var/www/html
RUN composer install
RUN npm install
RUN npm run build

# use php apache base image
FROM php:7.4-apache
# install vim,git and unzip
RUN apt-get update &&\
apt-get install git unzip vim curl -y
# install the followin php docker extention
RUN docker-php-ext-install bcmath pdo_mysql
# configure apache document root as per the image documentation in addition rewrite header
ENV APACHE_DOCUMENT_ROOT /usr/src/myapp/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers
# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# copy project contents into the into the container and set the working directory to /usr/src/myapp
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
# install laravel dependecies
RUN composer install --no-dev --no-interaction -o --ansi
# change the group ownership of the storage and bootstrap/cache directories to www-data
RUN chgrp -R www-data storage bootstrap/cache
# recursively grant all permissions, including write and execute, to the group
RUN chmod -R ug+rwx storage bootstrap/cache
# set the container entrypoint
CMD apachectl -D FOREGROUND

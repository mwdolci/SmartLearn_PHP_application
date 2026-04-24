# DESCRIPTION
#    Petit conteneur Apache2 + PHP 8.4 avec gd
#    et support client PDO/MySQL PHP et redirections
#    pour notre framework
# NOTES
# BUGS
# TODO
FROM php:8.4-apache

# la base est Debian, mettons a jour
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get -u -y dist-upgrade; apt-get clean

# config de type developpement (montee dans le conteneur de config/php.ini)
#RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# notre config/php.ini a ete modifie pour autoriser $_ENV dans PHP

RUN sed -i 's/Options -Indexes/Options +Indexes/' /etc/apache2/conf-available/docker-php.conf

# docker-php-ext-install is unfortunately less powerful with build
# dependancies installation
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod 755 /usr/local/bin/install-php-extensions

RUN install-php-extensions gd @composer openssl pdo pdo_mysql

RUN a2enmod rewrite

# timezone
COPY files/timezone /etc/timezone
RUN ln -sf /usr/share/zoneinfo/$(cat /etc/timezone) /etc/localtime

# documentation
EXPOSE 80/tcp

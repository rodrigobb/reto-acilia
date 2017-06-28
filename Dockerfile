## Acilia Reto deSymfony
FROM php:7.0-apache

# php conf
COPY docker/config/php.ini /usr/local/etc/php/conf.d/

# apache conf
ADD docker/config/acilia-reto-participante.conf /etc/apache2/sites-available/
RUN rm /etc/apache2/sites-enabled/000-default.conf
RUN ln -s /etc/apache2/sites-available/acilia-reto-participante.conf /etc/apache2/sites-enabled/01-acilia-reto.conf

# enable app
COPY ./ /var/www/html/

RUN chown 33:33 /var/www/html/ -R

EXPOSE 80

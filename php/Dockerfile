FROM php:7.2.10-fpm-alpine3.8

RUN docker-php-ext-install pdo_mysql
#musielismy to doinstalować do obsługi mysql przy użyciu PDO (PDO to biblioteka do obsługi bazy danych)

ADD php/public /var/www/html/public

EXPOSE 9000

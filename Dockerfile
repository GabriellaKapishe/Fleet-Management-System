FROM php:7.4.3-fpm-alpine

WORKDIR /var/www/html/

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY . .

RUN mv .env.prod .env

ADD  httpd.conf /etc/httpd/conf/httpd.conf
ADD  welcome.conf /etc/httpd/conf.d/welcome.conf

RUN composer install

EXPOSE 80

ENTRYPOINT ["/usr/sbin/httpd","-D","FOREGROUND"]


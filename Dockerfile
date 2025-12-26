FROM yiisoftware/yii2-php:8.2-apache

WORKDIR /app

COPY ./composer.json ./composer.lock .

RUN composer install --prefer-dist --optimize-autoloader

COPY . .

RUN rm ./web/index-dev.php ./web/index-test.php && \
    mv ./web/index-prod.php ./web/index.php && \
    chmod -R 0755 ./web/assets ./web/uploads ./runtime && \
    chown -R www-data:www-data ./web/assets ./web/uploads ./runtime && \
    mv ./000-default.conf /etc/apache2/sites-available

EXPOSE 80

FROM composer as builder

COPY composer.json composer.lock /app/
RUN composer install  \
    --ignore-platform-reqs \
    --no-ansi \
    --no-autoloader \
    --no-interaction \
    --no-scripts

COPY . /app/
RUN composer dump-autoload --optimize --classmap-authoritative

FROM php:7.3-fpm-alpine
WORKDIR /app

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql

COPY --from=builder /app /app

CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]
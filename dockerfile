
FROM dunglas/frankenphp:1-php8.3

RUN install-php-extensions pdo_mysql

WORKDIR /app

COPY . /app

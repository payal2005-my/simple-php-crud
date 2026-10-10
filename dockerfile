```dockerfile
FROM dunglas/frankenphp:1-php8.3

RUN install-php-extensions pdo_mysql

WORKDIR /app

COPY . /app

ENV SERVER_NAME=:80
ENV SERVER_ROOT=/app

EXPOSE 80
```

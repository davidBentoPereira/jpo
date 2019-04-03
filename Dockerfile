FROM php:7.1-alpine
RUN apk add --no-cache libpng libpng-dev && docker-php-ext-install gd && apk del libpng-dev
RUN mkdir /usr/src/app
WORKDIR /usr/src/app
EXPOSE 8000
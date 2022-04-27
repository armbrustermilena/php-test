FROM php:8.0-cli-alpine

MAINTAINER tymeshiftwfm

ADD . /project

WORKDIR /project

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer &&\
    apk add make
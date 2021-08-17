# Copyright 2019 Google LLC
#
# Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in
# compliance with the License. You may obtain a copy of the License at
#
#     https://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software distributed under the License
# is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
# implied. See the License for the specific language governing permissions and limitations under the
# License.

FROM nginx:latest

COPY nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /usr/share/nginx/html
COPY site .

ARG GITHUB_SHA
ARG GITHUB_REF
ENV SHA=$GITHUB_SHA
ENV REF=$GITHUB_REF

RUN sed -i 's,SHA,'"$GITHUB_SHA"',' index.html
RUN sed -i 's,REF,'"$GITHUB_REF"',' index.html

CMD nginx -g 'daemon off;'


#FROM php:fpm
#COPY site /var/www/html/
#EXPOSE 80

# Use the official PHP 7.4 image.
# https://hub.docker.com/_/php
#FROM php:7.4-apache

# Copy local code to the container image.
#COPY site/compra.php /var/www/html/
#COPY site/transacción.php /var/www/html/

# Use port 8080 in Apache configuration files.
#RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Configure PHP for development.
# Switch to the production php.ini for production operations.
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
# https://hub.docker.com/_/php#configuration
#RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

FROM php:fpm
              
RUN apt-get update \
    && apt-get install -y iputils-ping
 #   && docker-php-ext-install mysqli && docker-php-ext-enable mysqli

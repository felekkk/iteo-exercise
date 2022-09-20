FROM ubuntu:22.04

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get -y update && apt-get install -y software-properties-common curl unzip zip acl php-xml

RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php \
    && apt-get -y update \
    && apt-get -y install php8.1\
    && apt-get install -y php8.1-xml php8.1-mbstring php8.1-pgsql php8.1-curl \
        php8.1-xdebug php8.1-amqp

COPY php.ini /usr/local/etc/php/

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN curl --silent --location https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y \
  nodejs

RUN echo "Node: " && node -v
RUN echo "NPM: " && npm -v

RUN adduser docker

ENV APACHE_RUN_USER docker
ENV APACHE_RUN_GROUP docker
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid

RUN apt-get -y update && apt-get install -y apache2 libapache2-mod-php8.1 && a2enmod rewrite

ADD apache.conf /etc/apache2/sites-enabled/000-default.conf

COPY starter /usr/local/bin/starter
RUN chmod +x /usr/local/bin/starter

VOLUME /var/www/html

RUN npm install npm -g && \
    npm install n -g && \
    n lts

ENV SYMFONY_ENV dev

ENV IS_DOCKER 1

EXPOSE 80

WORKDIR /var/www/html

RUN echo "[safe]\n directory = /var/www/html" > /var/www/.gitconfig


CMD starter
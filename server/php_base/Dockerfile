# Minimální verze laravel 9 je 8.0.2
FROM php:8.0-fpm

# custom php.ini pro nakopírování do image
ARG PHP_INI=php.dev.ini

# SET TIMEZONE FOR OS
RUN apt-get update && apt-get -y install tzdata ghostscript sendmail
ENV TZ Europe/Prague

RUN apt-get update --fix-missing && apt-get install -y git zip unzip wget
COPY composer_install.sh .
RUN chmod 775 composer_install.sh && ./composer_install.sh && mv composer.phar /usr/local/bin/composer

# nastavení neinteraktivní instalace balíčků (při buildění image nelze interagovat)
ENV DEBIAN_FRONTEND noninteractive
ENV DEBCONF_NONINTERACTIVE_SEEN true

# balicek pro automatickou instalaci PHP rozsireni
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
# laravel min dep
RUN install-php-extensions bcmath
# API dep
# !!! PHP KNIHOVNY VKLADAT ZDE !!!
RUN install-php-extensions pdo_mysql redis pcntl

# CLEAN
RUN apt-get autoremove -y
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* || true

# konfiguracni soubory
COPY $PHP_INI /usr/local/etc/php/php.ini
COPY www.conf /usr/local/etc/php-fpm.d
# script který spustíme po nastartování kontejneru
# děláme v něm nastavení prostředí apod
COPY start.sh /usr/local/bin/start
RUN chmod a+x /usr/local/bin/start

CMD ["/usr/local/bin/start"]

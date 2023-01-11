ARG TAG
FROM test.docker.og:5000/albi-hry-backend-php_base:$TAG

# jakmile bude deploy pres ci, melo by se automaticky buildit vlastni  pro tento projekt a pouzivat vlastni:
#FROM test.docker.og:5000/<nazev_projektu>-php_base:$TAG

# php.ini
ARG PHP_INI=php.prod.ini
# konfiguracni soubory
COPY $PHP_INI /usr/local/etc/php/php.ini

# prepiseme base start.sh
COPY start.sh /usr/local/bin/start
RUN chmod a+x /usr/local/bin/start

# zdrojove kody
ARG SRC_DIR
COPY $SRC_DIR .

# vygeneruje cache pro konfiguraci
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# vygenerujeme proxies
#RUN php artisan doctrine:generate:proxies

# vygenerujeme EntityTmpClasses
#RUN php artisan command:generateEntitiesExports

CMD ["/usr/local/bin/start"]

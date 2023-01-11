ARG TAG
FROM test.docker.og:5000/skoda-nglt-php_base:$TAG
# jakmile bude deploy pres ci, melo by se automaticky buildit vlastni apache pro tento projekt a pouzivat vlastni:
#FROM test.docker.og:5000/<nazev_projektu>-php_base:$TAG

RUN apt-get update --fix-missing && apt-get install -y git zip unzip wget
COPY composer_install.sh .
RUN chmod 775 composer_install.sh && ./composer_install.sh && mv composer.phar /usr/local/bin/composer

# PKG CLEANUP
RUN apt-get autoremove -y
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* || true

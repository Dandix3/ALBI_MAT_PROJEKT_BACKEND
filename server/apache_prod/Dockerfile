ARG TAG
FROM test.docker.og:5000/albi-hry-backend-apache_base:$TAG

# jakmile bude deploy pres ci, melo by se automaticky buildit vlastni apache pro tento projekt a pouzivat vlastni:
#FROM test.docker.og:5000/<nazev_projektu>-apache_base:$TAG

# COPY SRC
ARG SRC_DIR
RUN mkdir -p /var/www/html/
COPY $SRC_DIR /var/www/html/

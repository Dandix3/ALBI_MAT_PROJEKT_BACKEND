FROM httpd:2.4
# Apache neumí WINCH takze takto ho restartujem pri tomto signalu
STOPSIGNAL WINCH

ENV TZ Europe/Prague
RUN apt-get update && apt-get -y install tzdata

# enable rewrite_module
RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf

RUN { \
  echo 'IncludeOptional conf.d/*.conf'; \
} >> /usr/local/apache2/conf/httpd.conf \
  && mkdir /usr/local/apache2/conf.d

# remove predefined Listen - because it can not be duplicit on same port
RUN sed -i '/^Listen / d' /usr/local/apache2/conf/httpd.conf
# set listener
RUN echo "Listen 80" \
    >> /usr/local/apache2/conf/httpd.conf

# copy apache vhost file to proxy php requests to container
COPY apache.conf /usr/local/apache2/conf/apache.conf

RUN echo "Include /usr/local/apache2/conf/apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf

# CLEANUP
RUN apt-get autoremove -y
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* || true

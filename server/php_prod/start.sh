#!/usr/bin/env bash

# jedná se o script který se spustí ihned po spuštění containeru

set -e

role=${CONTAINER_ROLE:-app}

# zde může být více rolí, např scheduler, horizon...
if [ "$role" = "app" ]; then
    # uděláme optimalizace Laravelu (cache neměnných věcí)
    php artisan optimize:clear && php artisan route:cache && php artisan view:cache && php artisan config:cache
    # spustíme na popředí php-fpm a nyní už Apache bude přes port 9000 přeposílat požadavky ke zpracování
	exec php-fpm

elif [ "$role" = "horizon"]; then

    php /var/www/html/artisan horizon

elif [ "$role" = "scheduler" ]; then

    while [ true ]
    do
      php /var/www/html/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else

    echo "Could not match the container role \"$role\""
    exit 1

fi

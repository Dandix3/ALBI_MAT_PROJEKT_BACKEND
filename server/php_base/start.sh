#!/usr/bin/env bash

# jedná se o script který se spustí ihned po spuštění containeru

set -e

role=${CONTAINER_ROLE:-app}

# zde může být více rolí, např scheduler, horizon...
if [ "$role" = "app" ]; then
    # spustíme na popředí php-fpm a nyní už Apache bude přes port 9000 přeposílat požadavky ke zpracování
	exec php-fpm

	php /var/www/html/artisan optimize:clear

#       https://github.com/BretFisher/php-docker-good-defaults/issues/5#issuecomment-805695888
#!!!	https://laravel-news.com/laravel-scheduler-queue-docker
#       https://medium.com/@agungdarmanto/how-to-run-a-laravel-application-into-kubernetes-a6d0111dc98d
#       https://stackoverflow.com/questions/48884802/docker-laravel-queuework
#       https://stackoverflow.com/questions/61872153/getting-logs-out-of-laravel-horizon-running-in-docker-in-supervisor
#       https://stackoverflow.com/questions/60722553/run-laravel-queue-worker-in-docker


elif [ "$role" = "horizon" ]; then

    php /var/www/html/artisan horizon

#elif [ "$role" = "scheduler" ]; then
#
#    while [ true ]
#    do
#      php /var/www/html/artisan schedule:run --verbose --no-interaction &
#      sleep 60
#    done

else

    echo "Could not match the container role \"$role\""
    exit 1

fi

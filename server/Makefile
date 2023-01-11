#!make

.PHONY: composer
.DEFAULT_GOAL := default
THIS_FILE := $(lastword $(MAKEFILE_LIST))

# load env file
include .env
export $(shell sed 's/=.*//' ./.env)

DOCKER_PHP = $(PROJECT_NAME)-php_base
DOCKER_COMPOSER = $(PROJECT_NAME)-composer:master
DOCKER_APACHE = $(PROJECT_NAME)-apache_base
P = list

GIT_EXPORT_USER='gitlab-skoda-glt'
GIT_EXPORT_TOKEN_BE='f-dm3PUyL4MXF7FW_MHg'

# spuštění serveru se vším všudy
default:
	$(MAKE) -f $(THIS_FILE) docker_start

# nápověda
help:
	@cat $(MAKEFILE_LIST) | docker run --rm -i xanders/make-help

# vyčistění cache Laravelu
clear:
	$(MAKE) -f $(THIS_FILE) artisan_clear

# Cache Laravelu
cache:
	$(MAKE) -f $(THIS_FILE) artisan_optimize

# spuštění příkazu `php $(P)` - např. `php -v` by se spustilo jako P="-v"
docker_php:
	docker exec -it $(PROJECT_NAME)_app php $(P)

# spuštění serveru se vším všudy
docker_start:
	docker-compose pull
	$(MAKE) -f $(THIS_FILE) docker_offline

docker_offline:
	docker-compose -p $(PROJECT_NAME) build --build-arg PHP_INI=php.dev.ini
	docker-compose -p $(PROJECT_NAME) up --force-recreate

# alias pro `docker exec -it`
docker_exec:
	docker exec -i $(P)

# alias pro spuštění příkazu v kontaineru
# parametry:
# - NAME [nazev kontaineru, napr apache]
# - P [prikaz]
docker_exec_container:
	#echo "parametry: NAME [nazev kontaineru, napr apache] a P [prikaz]"
	$(MAKE) -f $(THIS_FILE) docker_exec P="$(PROJECT_NAME)_$(NAME) $(P)"

# alias pro připojení se do kontejneru PHP (do bash)
docker_exec_app_bash:
	$(MAKE) -f $(THIS_FILE) docker_exec_container NAME="app" P="/bin/bash"

# alias pro připojení se do kontejneru Apache (do bash)
docker_exec_apache_bash:
	$(MAKE) -f $(THIS_FILE) docker_exec_container NAME="apache" P="/bin/bash"

# spuštění artisan příkazu
# - P [příkaz]
artisan:
	$(MAKE) -f $(THIS_FILE) docker_exec_container NAME="app" P="php artisan $(P)"

# pročištění Laravel  a Composer cache
artisan_clear:
	$(MAKE) -f $(THIS_FILE) artisan P="optimize:clear"

# pročištění Laravel  a Composer cache
artisan_optimize:
	$(MAKE) -f $(THIS_FILE) artisan P="route:cache"
	$(MAKE) -f $(THIS_FILE) artisan P="config:cache"
	$(MAKE) -f $(THIS_FILE) composer P="dump-autoload"

# php artisan migrate nove tabulky
artisan_migrate:
	$(MAKE) -f $(THIS_FILE) artisan P="migrate"

# prepise stavajici migrace a naplni testovacimi daty
artisan_migrate_fresh_seed:
	$(MAKE) -f $(THIS_FILE) artisan P="migrate:fresh --seed"

# vygenerování nápovědy pro IDE
artisan_ide_helper:
	$(MAKE) -f $(THIS_FILE) artisan P="ide-helper:generate"
	$(MAKE) -f $(THIS_FILE) artisan P="ide-helper:meta"

# alias pro sluštění composer příkazu
composer:
	echo "P=prikaz - pro zmenu composer prikazu"
	docker pull test.docker.og:5000/$(DOCKER_COMPOSER)
	#(cd $(PROJECT_DIR) && docker run --tty -it --user $(id -u):$(id -g) --rm -v `pwd`:/app -w /app test.docker.og:5000/$(DOCKER_COMPOSER) composer $(P))
	(cd $(PROJECT_DIR) && docker run --tty -it --user $(id -u):$(id -g) --rm -v `pwd`:/app -w /app test.docker.og:5000/$(DOCKER_COMPOSER) composer $(P))

# composer install
composer_install:
	$(MAKE) -f $(THIS_FILE) composer P="install"

# composer update
composer_update:
	$(MAKE) -f $(THIS_FILE) composer P="update"

# obecný fix práv, ideálně nepoužívat a vyřešit práva jiným způsobem
fix_perms:
	cd $(PROJECT_DIR)log && sudo chmod 0777 . -R
	cd $(PROJECT_DIR)temp && sudo chmod 0777 . -R
	cd $(PROJECT_DIR)vendor && sudo chmod 0777 . -R
	cd $(PROJECT_DIR)migrations && sudo chmod 0777 . -R

api_generate:
	$(MAKE) -f $(THIS_FILE) artisan P="openapi:generate"

api_generate_file:
	PRINT_HELP=false
	make -s artisan P="openapi:generate" 1> $(PROJECT_DIR)storage/app/api/api-v1.json

api_create_request_body:
	$(MAKE) -f $(THIS_FILE) artisan P="openapi:make-requestbody $(P)"

api_create_response:
	$(MAKE) -f $(THIS_FILE) artisan P="openapi:make-response $(P)"

api_create_parameters:
	$(MAKE) -f $(THIS_FILE) artisan P="openapi:make-parameters $(P)"

api_create_req_and_res:
	$(MAKE) -f $(THIS_FILE) api_create_request_body P=$(P)
	$(MAKE) -f $(THIS_FILE) api_create_response P=$(P)

api_create_all:
	$(MAKE) -f $(THIS_FILE) api_create_request_body P=$(P)
	$(MAKE) -f $(THIS_FILE) api_create_response P=$(P)
	$(MAKE) -f $(THIS_FILE) api_create_parameters P=$(P)

DOCKER_COMPOSE=docker compose
DOCKER_COMPOSE_EXEC=$(DOCKER_COMPOSE) exec
PHP_EXEC=$(DOCKER_COMPOSE_EXEC) -e XDEBUG_MODE=off -e PHP_CS_FIXER_IGNORE_ENV=1 -e SYMFONY_DEPRECATIONS_HELPER=disabled php
PHP_EXEC_DEV=$(DOCKER_COMPOSE_EXEC) -e XDEBUG_MODE=off -e PHP_CS_FIXER_IGNORE_ENV=1 -e SYMFONY_DEPRECATIONS_HELPER=disabled -e APP_ENV=dev php

default: help

help: # Show help for each of the Makefile recipes.
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | sort | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done

stop: # Stop all containers
	$(DOCKER_COMPOSE) stop

start: # Start all containers
	$(DOCKER_COMPOSE) up -d --remove-orphans

restart: stop start # Restart all containers

destroy: # Stop and remove all containers and volumes
	$(DOCKER_COMPOSE) down --remove-orphans -v

logs: # Show containers logs in real time
	$(DOCKER_COMPOSE) logs -f --tail 100 --timestamps

fix: # Fix code style
	@$(PHP_EXEC) ./vendor/bin/php-cs-fixer fix --allow-risky yes

test: # Run tests
	@$(PHP_EXEC) ./vendor/bin/phpunit --testdox

phpstan: # Run phpstan checks
	@$(PHP_EXEC) ./vendor/bin/phpstan

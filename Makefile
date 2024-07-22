default: help
-include .env.local

COMPOSE = docker compose --env-file .env.local
PHP		:= $(COMPOSE) exec -T php

.PHONY: help
help: # Show help for each of the Makefile recipes.
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | sort | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done

.PHONY: run-server
run-server: # Run server
	$(PHP) symfony server:start

.PHONY: run-external-api
run-external-api: # A the symfony command to simulate the operation of an external api
	$(PHP) bin/console app:call-api

.PHONY: run-consumer-validate
run-consumer-validate: # Run the symfony command that validates the data
	$(PHP) bin/console rabbitMQ:consumer-validate-data

.PHONY: run-consumer-db
run-consumer-db: # Runs the symfony command that saves information to a database
	$(PHP) bin/console rabbitMQ:consumer-db

.PHONY: create-db
create-db: # Create database
	$(PHP) bin/console doctrine:database:create

.PHONY: drop-db
drop-db: # Drop database. Dangerous command
	@echo "\033[92mAre you sure that you want to reload the database?\033[0m [y/N] " && read ans && [ $${ans:-N} = y ]
	$(PHP) bin/console doctrine:database:drop --force

.PHONY: migrate
migrate: # Migrate to latest migration
	$(PHP) bin/console doctrine:migrations:migrate latest

.PHONY: create-migrate
create-migrate: # Creating a migration
	$(PHP) bin/console make:migration
.PHONY: router
router: # Show urls and routers
	$(PHP) bin/console debug:router

.PHONY: create
create: # Create containers
	$(COMPOSE) build

.PHONY: destroy
destroy: # Destroy containers
	$(COMPOSE) down --rmi all --volumes --remove-orphans

.PHONY: start
start: # Start containers
	$(COMPOSE) up --detach --remove-orphans

.PHONY: stop
stop: # Stop containers
	$(COMPOSE) stop

.PHONY: restart
restart: stop start # Restart containers

.PHONY: install-composer
install-composer: # Install composer
	$(PHP) composer install
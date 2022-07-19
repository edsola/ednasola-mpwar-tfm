#!/bin/bash

APP = service-php-pfm
WEB = service-web
DB = service-db

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start: ## Start the containers
	docker network create network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n .env.dist .env || true
	docker-compose up -d

stop: ## Stop the containers
	docker-compose stop

kill: ## Stop the containers
	docker-compose kill

remove: ## Stop the containers
	docker-compose rm

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

build: ## Rebuilds all the containers
	docker network create network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n .env.dist .env || true
	docker-compose build

ssh-app: ## bash into the be container
	docker exec -it ${APP} bash

ssh-db: ## bash into the be container
	docker exec -it ${DB} mysql -u root -proot database -h localhost

ssh-web: ## bash into the be container
	docker exec -it ${WEB} /bin/bash

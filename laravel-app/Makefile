ARGS = $(filter-out $@,$(MAKECMDGOALS))
MAKEFLAGS += --silent

list:
	sh -c "echo; $(MAKE) -p no_targets__ | awk -F':' '/^[a-zA-Z0-9][^\$$#\/\\t=]*:([^=]|$$)/ {split(\$$1,A,/ /);for(i in A)print A[i]}' | grep -v '__\$$' | grep -v 'Makefile'| sort"

#############################
# Docker machine states
#############################

up:
	docker compose up -d

build:
	docker compose up --build

start:
	docker compose start

stop:
	docker compose stop

state:
	docker compose ps

rebuild: stop
	docker compose pull
	docker compose rm --force php
	docker compose build --no-cache --pull
	docker compose up -d --force-recreate

#############################
# Composer
#############################

composer:
	docker compose exec php composer $(ARGS)

composer-install:
	docker compose exec php composer install

composer-update:
	docker compose exec php composer update

#############################
# Xdebug
#############################

xdebug-enable:
	bin/xdebug.sh enable

xdebug-disable:
	bin/xdebug.sh disable

#############################
# General
#############################

exec:
	docker compose exec php $(ARGS)

console:
	docker compose exec php /bin/bash

#############################
# Argument fix workaround
#############################
%:
	@:

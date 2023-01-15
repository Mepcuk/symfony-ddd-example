##################
# Variables
##################

DOCKER_COMPOSE = docker-compose -f ./docker-symfony6-php8.2-nginx-postgresql-chrome-webdriver/docker-compose.yml --env-file ./docker-symfony6-php8.2-nginx-postgresql-chrome-webdriver/.env
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

##################
# Docker compose
##################

docker_build:
	${DOCKER_COMPOSE} build

docker_start:
	${DOCKER_COMPOSE} start

docker_stop:
	${DOCKER_COMPOSE} stop

docker_up:
	${DOCKER_COMPOSE} up -d --remove-orphans

docker_ps:
	${DOCKER_COMPOSE} ps

docker_logs:
	${DOCKER_COMPOSE} logs -f

docker_down:
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

docker_restart:
	make docker_stop docker_start

docker_rebuild:
	make docker_down docker_up docker_up
##################
# App
##################

app_bash:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash
php:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash
test:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/phpunit
jwt:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console lexik:jwt:generate-keypair
cache:
	docker-compose -f ./docker-symfony6-php8.2-nginx-postgresql-chrome-webdriver/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear
	docker-compose -f ./docker-symfony6-php8.2-nginx-postgresql-chrome-webdriver/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear --env=test

##################
# Database
##################

db_migrate:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console doctrine:migrations:migrate --no-interaction
db_diff:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console doctrine:migrations:diff --no-interaction
db_drop:
	docker-compose -f ./docker-symfony6-php8.2-nginx-postgresql-chrome-webdriver/docker-compose.yml exec -u www-data php-fpm bin/console doctrine:schema:drop --force


##################
# Static code analysis
##################

phpstan:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/phpstan analyse src tests -c phpstan.neon

deptrac:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/deptrac analyze deptrac-layers.yaml
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/deptrac analyze deptrac-modules.yaml

cs_fix:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix

cs_fix_diff:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix --dry-run --diff
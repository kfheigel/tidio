run: build up cache-clear composer-install seed
test: phpcs lint phpspec unit-tests integration-tests phpstan-run

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

bash:
	docker exec -it tidio /bin/bash

nginx:
	docker exec -it nginx /bin/bash

composer-install:
	docker exec -it tidio composer install

sleep:
	sleep 5

seed:
	docker exec -it tidio bin/console doctrine:database:create
	docker exec -it tidio bin/console doctrine:migrations:migrate --no-interaction
	docker exec -it tidio bin/console support:fixture:salary
	docker exec -it tidio bin/console support:fixture:department
	docker exec -it tidio bin/console support:fixture:employee
	docker exec -it tidio bin/console doctrine:database:create --env=test --no-interaction
	docker exec -it tidio bin/console doctrine:migrations:migrate --env=test --no-interaction

cache-clear:
	docker exec -it tidio bin/console cache:clear

consume-async:
	docker exec -it tidio bin/console messenger:consume async -vv

phpcs:
	docker exec -it tidio vendor/bin/phpcs

lint:
	docker exec -it tidio bin/console lint:yaml config --parse-tags

phpspec:
	docker exec -it tidio vendor/bin/phpspec run --format=pretty

unit-tests:
	docker exec -it tidio ./bin/phpunit -c phpunit.xml --testdox --testsuite unit

integration-tests:
	docker exec -it tidio ./bin/phpunit -c phpunit.xml --testdox --testsuite integration

phpstan-run:
	docker exec -it tidio vendor/bin/phpstan analyse -c phpstan.neon

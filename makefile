run: build up cache-clear composer-install seed

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

cache-clear:
	docker exec -it tidio bin/console cache:clear

consume-async:
	docker exec -it tidio bin/console messenger:consume async -vv

unit-tests:
	docker exec -it tidio ./bin/phpunit -c phpunit.xml --testdox --testsuite unit

integration-tests:
	docker exec -it tidio ./bin/phpunit -c phpunit.xml --testdox --testsuite integration

test: unit-tests integration-tests
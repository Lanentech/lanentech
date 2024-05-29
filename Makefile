PREFIX=docker exec -it app

# -----------------------------------
# Code Quality Commands
# -----------------------------------
add-void-to-tests:
	$(PREFIX) php scripts/UpdateTestsWithVoidReturn.php;

analyze-code:
	$(PREFIX) vendor/bin/phpcs --standard=phpcs.xml;
	$(PREFIX) vendor/bin/phpcbf src tests;
	$(PREFIX) vendor/bin/phpstan

# -----------------------------------
# Developer Helper Commands
# -----------------------------------
bash:
	$(PREFIX) bash;

# [USAGE]: make clear-cache || make clear-cache env=test
clear-cache:
ifdef env
	$(PREFIX) bin/console cache:clear --env=${env};
else
	$(PREFIX) bin/console cache:clear;
endif

diff:
	$(PREFIX) bin/console doctrine:migrations:diff;

manage-data:
	$(PREFIX) bin/console app:data-management:run

# [USAGE]: make migrate || make migrate env=test
migrate:
ifdef env
	$(PREFIX) bin/console doctrine:migrations:migrate -n --env=${env};
else
	$(PREFIX) bin/console doctrine:migrations:migrate -n;
endif

# [USAGE]: make seed || make seed env=test
seed:
ifdef env
	$(PREFIX) bin/console doctrine:fixtures:load -n --group=test-fixture --env=${env};
else
	$(PREFIX) bin/console doctrine:fixtures:load -n --group=application-fixture;
endif

run-tests:
	$(PREFIX) bin/phpunit -c phpunit.xml.dist --testsuite=Integration,Unit

run-integration-tests:
	$(PREFIX) bin/phpunit -c phpunit.xml.dist --testsuite=Integration

run-unit-tests:
	$(PREFIX) bin/phpunit -c phpunit.xml.dist --testsuite=Unit

# -----------------------------------
# Setup Commands
# -----------------------------------
composer-install:
	$(PREFIX) composer install;

composer-update:
	$(PREFIX) composer update;

# [USAGE]: make create-databases || make create-databases env=test
create-databases:
ifdef env
	$(PREFIX) bin/console doctrine:database:create --if-not-exists --env=${env};
else
	$(PREFIX) bin/console doctrine:database:create --if-not-exists;
endif

docker-build:
	docker compose up -d --build --remove-orphans;

docker-down:
	docker compose down;

docker-restart:
	make docker-down;
	make docker-up;

docker-up:
	make docker-build;

rebuild:
	@{ \
  	read -p "Are you sure you want to rebuild your dev and test databases? This cannot be undone! [y/n] " answer \
  	&& if [ "$$answer" = "y" ]; then \
        echo "Rebuilding databases..."; \
        $(PREFIX) bin/console doctrine:database:drop --force --if-exists; \
        $(PREFIX) bin/console doctrine:database:drop --force --if-exists --env=test; \
        make create-databases; \
        make create-databases env=test; \
        make migrate; \
        make migrate env=test; \
        make seed; \
        make seed env=test; \
        make manage-data; \
    else \
        echo "Rebuild of databases cancelled."; \
    fi; \
    }

reload:
	make composer-install;
	make migrate;
	make migrate env=test;
	make seed;
	make seed env=test;
	make manage-data;
	make clear-cache;
	make clear-cache env=test;

setup:
	make docker-up;
	make composer-install;
	make create-databases;
	make create-databases env=test;
	make migrate;
	make migrate env=test;
	make seed;
	make seed env=test;
	make manage-data;

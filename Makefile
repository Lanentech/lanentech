PREFIX=docker exec -it app

# -----------------------------------
# Code Quality Commands
# -----------------------------------
add-void-to-tests:
	$(PREFIX) php scripts/UpdateTestsWithVoidReturn.php;

analyze-code:
	$(PREFIX) vendor/bin/phpcs --standard=phpcs.xml;
	$(PREFIX) vendor/bin/phpcbf src tests;
	$(PREFIX) vendor/bin/phpstan analyse --level max src;

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
	$(PREFIX) bin/console doctrine:fixtures:load -n --env=${env};
else
	$(PREFIX) bin/console doctrine:fixtures:load -n;
endif

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
    else \
        echo "Rebuild of databases cancelled."; \
    fi; \
    }

reload:
	make composer-install;
	make migrate;
	make migrate env=test;
	make clear-cache;
	make clear-cache env=test;

setup:
	make composer-install;
	make create-databases;
	make migrate;
	make seed;

setup-test:
	make create-databases env=test;
	make migrate env=test;
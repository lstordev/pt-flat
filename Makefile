.PHONY: help install update start stop db-create db-migrate db-fixtures cache-clear cache-warmup test lint cs-fix

# Colors
COLOR_RESET   = \033[0m
COLOR_INFO    = \033[32m
COLOR_COMMENT = \033[33m

## Help
help:
	@echo "${COLOR_COMMENT}Usage:${COLOR_RESET}"
	@echo " make [target]"
	@echo ""
	@echo "${COLOR_COMMENT}Available targets:${COLOR_RESET}"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf " ${COLOR_INFO}%-15s${COLOR_RESET} %s\n", $$1, $$2}'

## Installation
install: ## Install dependencies
	@echo "${COLOR_INFO}Installing dependencies...${COLOR_RESET}"
	composer install

update: ## Update dependencies
	@echo "${COLOR_INFO}Updating dependencies...${COLOR_RESET}"
	composer update

## Server
start: ## Start the Symfony server
	@echo "${COLOR_INFO}Starting Symfony server...${COLOR_RESET}"
	symfony server:start -d

stop: ## Stop the Symfony server
	@echo "${COLOR_INFO}Stopping Symfony server...${COLOR_RESET}"
	symfony server:stop

## Database
db-create: ## Create database
	@echo "${COLOR_INFO}Creating database...${COLOR_RESET}"
	php bin/console doctrine:database:create --if-not-exists

db-drop: ## Drop database
	@echo "${COLOR_INFO}Dropping database...${COLOR_RESET}"
	php bin/console doctrine:database:drop --force --if-exists

db-migrate: ## Run database migrations
	@echo "${COLOR_INFO}Running migrations...${COLOR_RESET}"
	php bin/console doctrine:migrations:migrate --no-interaction

db-schema-create: ## Create database schema
	@echo "${COLOR_INFO}Creating database schema...${COLOR_RESET}"
	php bin/console doctrine:schema:create

db-schema-update: ## Update database schema
	@echo "${COLOR_INFO}Updating database schema...${COLOR_RESET}"
	php bin/console doctrine:schema:update --force

db-fixtures: ## Load fixtures
	@echo "${COLOR_INFO}Loading fixtures...${COLOR_RESET}"
	php bin/console doctrine:fixtures:load --no-interaction

## Cache
cache-clear: ## Clear cache
	@echo "${COLOR_INFO}Clearing cache...${COLOR_RESET}"
	php bin/console cache:clear

cache-warmup: ## Warmup cache
	@echo "${COLOR_INFO}Warming up cache...${COLOR_RESET}"
	php bin/console cache:warmup

## Tests
test: ## Run tests
	@echo "${COLOR_INFO}Running tests...${COLOR_RESET}"
	php vendor/bin/phpunit

## Code Quality
lint: ## Lint PHP files
	@echo "${COLOR_INFO}Linting PHP files...${COLOR_RESET}"
	find src -name "*.php" -exec php -l {} \;

cs-check: ## Check coding standards
	@echo "${COLOR_INFO}Checking coding standards...${COLOR_RESET}"
	vendor/bin/phpcs --standard=PSR12 src

cs-fix: ## Fix coding standards
	@echo "${COLOR_INFO}Fixing coding standards...${COLOR_RESET}"
	vendor/bin/phpcbf --standard=PSR12 src

## Project
setup: install db-create db-migrate cache-clear ## Setup the project (install, create DB, run migrations, clear cache)
	@echo "${COLOR_INFO}Project setup completed!${COLOR_RESET}"

reset: cache-clear db-drop db-create db-migrate ## Reset the project (clear cache, drop DB, create DB, run migrations)
	@echo "${COLOR_INFO}Project reset completed!${COLOR_RESET}"
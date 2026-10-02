.DEFAULT_GOAL := help

.PHONY: help install up down migrate test console shell logs

help: ## Show available commands
	@grep -E '^[a-zA-Z_-]+:.*?## ' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-10s %s\n", $$1, $$2}'

install: ## Create .env, start containers, install PHP dependencies, and migrate
	@test -f .env || cp .env.example .env
	$(MAKE) up
	docker compose exec php composer install
	$(MAKE) migrate

up: ## Build images and start containers
	docker compose up --build -d

down: ## Stop and remove containers
	docker compose down

migrate: ## Apply database migrations
	docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction

test: ## Run PHPUnit
	docker compose exec php ./vendor/bin/phpunit

console: ## Run a Symfony command, for example make console CMD="cache:clear"
	docker compose exec php php bin/console $(CMD)

shell: ## Open a shell in the PHP container
	docker compose exec php sh

logs: ## Follow container logs
	docker compose logs -f

# Makefile

# Variables
SYMFONY_VERSION = 5.4
PROJECT_NAME = app

# Commandes Docker
DOCKER_COMPOSE = docker-compose -f infra/docker-compose.yml

# Tâches
.PHONY: help install symfony-install docker-build docker-up docker-down migrations migrations-migrate migrations-diff database-drop initialize-accounts composer-install composer-update

help: ## Affiche cette aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: composer-install docker-build docker-up

start: migrations-migrate initialize-accounts ## Installe et configure tout le projet

symfony-install: ## Télécharge et installe Symfony
	@echo "Installation de Symfony..."
	@if [ ! -f composer.phar ]; then curl -sS https://getcomposer.org/installer | php; fi
	@php composer.phar create-project symfony/skeleton $(PROJECT_NAME)

composer-install: ## Installe les dépendances Composer
	@echo "Téléchargement de l'image Composer..."
	@docker pull composer:latest
	@echo "Installation des dépendances Composer..."
	@docker run --rm -v $(PWD)/app:/app -w /app composer install

composer-update: ## Met à jour les dépendances Composer
	@echo "Téléchargement de l'image Composer..."
	@docker pull composer:latest
	@echo "Mise à jour des dépendances Composer..."
	@docker run --rm -v $(PWD)/app:/app -w /app composer update

docker-build: ## Construit les conteneurs Docker
	@echo "Construction des conteneurs Docker..."
	@$(DOCKER_COMPOSE) build

docker-up: ## Démarre les conteneurs Docker
	@echo "Démarrage des conteneurs Docker..."
	@$(DOCKER_COMPOSE) up -d

docker-down: ## Arrête les conteneurs Docker
	@echo "Arrêt des conteneurs Docker..."
	@$(DOCKER_COMPOSE) down

migrations: ## Crée une migration Doctrine
	@echo "Création d'une migration Doctrine..."
	@$(DOCKER_COMPOSE) exec php php bin/console make:migration

migrations-migrate: ## Exécute les migrations Doctrine
	@echo "Exécution des migrations Doctrine..."
	@$(DOCKER_COMPOSE) exec php php bin/console doctrine:migrations:migrate --no-interaction

migrations-diff: ## Génère une migration diff Doctrine
	@echo "Génération d'une migration diff Doctrine..."
	@$(DOCKER_COMPOSE) exec php php bin/console doctrine:migrations:diff

database-drop: ## Supprime la base de données
	@echo "Suppression de la base de données..."
	@$(DOCKER_COMPOSE) exec php php bin/console doctrine:database:drop --force

initialize-accounts: ## Initialise les comptes avec des soldes prédéfinis
	@echo "Initialisation des comptes..."
	@$(DOCKER_COMPOSE) exec php php bin/console c:c
	@$(DOCKER_COMPOSE) exec php php bin/console app:initialize-accounts --reset

logs: ## Affiche les logs des conteneurs
	@$(DOCKER_COMPOSE) logs -f

balances:
	curl -X GET http://localhost:8000/balances

gatling-test: ## Exécute les tests de charge Gatling
	@echo "Exécution des tests de charge Gatling..."
	@$(DOCKER_COMPOSE) run gatling

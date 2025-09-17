#!/usr/bin/env bash
set -e
echo "Starting setup for FigurineVie (modified project) ..."
if ! command -v composer >/dev/null 2>&1; then
  echo "Erreur: composer n'est pas installé. Installez-le et relancez."
  exit 1
fi
composer install --no-interaction
php bin/console doctrine:database:create || true
php bin/console doctrine:migrations:migrate --no-interaction || true
php bin/console doctrine:fixtures:load --no-interaction || true
echo "Setup terminé."

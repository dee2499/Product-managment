#!/bin/bash
set -e

echo "=== Laravel Product Management System Deployment ==="

# 1. Ensure .env exists on host
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

# 2. Composer install inside container
echo "Running composer install..."
docker compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader

# 3. Generate App Key inside container
echo "Generating app key..."
docker compose exec -T app php artisan key:generate --force

# 4. Storage Link inside container
echo "Creating storage link..."
docker compose exec -T app php artisan storage:link --force

# 5. Run Migrations and Seeders inside container
echo "Running migrations and seeding database..."
docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan db:seed --force

# 6. Laravel Cache & Optimization
echo "Caching configuration, routes, and views..."
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app php artisan optimize

# 7. Frontend Assets compilation
echo "Installing NPM dependencies and building assets..."
docker compose exec -T app npm install
docker compose exec -T app npm run build

echo "=== Deployment Finished Successfully! ==="
echo "Access the application at http://localhost:8000"

.PHONY: up down build deploy test pint shell status

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up --build -d

deploy:
	chmod +x deploy.sh
	./deploy.sh

test:
	docker compose exec -T app php artisan test

pint:
	docker compose exec -T app vendor/bin/pint

shell:
	docker compose exec app bash

status:
	docker compose ps

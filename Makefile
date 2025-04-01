.PHONY: insider up down build logs update-hosts all

all: update-hosts build up

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

logs:
	docker-compose logs -f

update-hosts:
	@if ! grep -q "dev.insider.com" /etc/hosts; then \
		echo "Adding dev.insider.com to /etc/hosts..."; \
		echo "127.0.0.1 dev.insider.com" | sudo tee -a /etc/hosts; \
	else \
		echo "dev.insider.com already exists in /etc/hosts."; \
	fi

insider: all

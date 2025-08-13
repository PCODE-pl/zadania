PROJECT_NAME:=zadania

.DEFAULT_GOAL := build

install-homebrew:
	if ! [ -x "$$(command -v brew)" ]; then \
		/bin/bash -c "$$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"; \
	fi

install-warden:
	if ! [ -x "$$(command -v warden)" ]; then \
		brew install wardenenv/warden/warden; \
	fi

fix-dns:
	sudo mkdir -p /etc/systemd/resolved.conf.d; \
	echo -e "[Resolve]\nDNS=127.0.0.1\nDomains=~test\n" | sudo tee /etc/systemd/resolved.conf.d/warden.conf > /dev/null; \
	sudo systemctl restart systemd-resolved;

run-warden:
	warden svc up

sign-cert:
	warden sign-certificate $(PROJECT_NAME).test

start-env:
	if [ ! -f ".env" ]; then \
		cp .env.dist .env; \
	fi
	warden env up

install-magento:
	warden env exec -T php-fpm composer install; \
	warden env exec -T php-fpm ./install_magento.sh

install-modules:
	warden env exec -T php-fpm ./install_modules.sh;

reindex:
	warden env exec -T php-fpm bin/magento indexer:reindex

build:
	make fix-dns
	make run-warden
	make sign-cert
	make start-env
	make install-magento
	make install-modules

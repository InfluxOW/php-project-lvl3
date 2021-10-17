start:
	heroku local -f Procfile.dev

setup:
	composer install
	php artisan key:generate
	touch database/database.sqlite || true
	php artisan migrate
	npm install

serve:
	php artisan serve

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test

deploy:
	git push heroku

lint:
	composer exec --verbose phpcs

lint-fix:
	composer exec --verbose phpcbf

meta:
	php artisan ide-helper:generate
	php artisan ide-helper:models -n -W
	php artisan ide-helper:meta

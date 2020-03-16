start:
	heroku local -f Procfile.dev

setup:
	composer install
	php artisan key:gen --ansi
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
	composer run-script phpcs -- --standard=PSR12 routes tests app

lint-fix:
	composer phpcbf

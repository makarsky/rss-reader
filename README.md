# rss-reader
Simple RSS reader

## Requirements:
Docker, npm 10.2.4, node v20.11.0.

## Installation:
1. Clone the project
2. Run `cp .env.example .env`
3. ```composer install```
4. ```npm i```
5. ```php bin/console doctrine:database:create```
6. ```php bin/console doctrine:migrations:migrate```
7. Run `npm run dev-server`
8. Open http://127.0.0.1:84

## Running tests:
```./bin/phpunit```

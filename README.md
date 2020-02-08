# rss-reader
Simple RSS reader

Requirements: PHP >= 7.2.5, MySQL 5.7, composer, yarn, Symfony CLI.

Installation:
1. Clone the project
2. Create .env.local with the line ```DATABASE_URL=mysql://user:password@127.0.0.1:3306/rss_reader?serverVersion=5.7``` with your credentials
3. ```composer install```
4. ```yarn```
5. ```php bin/console doctrine:database:create```
6. ```php bin/console doctrine:migrations:migrate```

Launch:
1. symfony server:start
2. yarn encore dev-server

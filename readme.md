# Handwerker

[![CircleCI](https://circleci.com/gh/EresDev/HandwerkerFullstack.svg?style=shield)](https://app.circleci.com/pipelines/github/EresDev/HandwerkerFullstack)

A web application to find craftsmen online. It is a fullstack application based on Symfony and its components.

It includes authentication, authorization, internationalization, and CRUD for Jobs with Categories. 

It included unit tests and end to end tests with Symfony panther based on php-webdriver (Selenium).

## Prerequisites
- PHP 7.4+
- MySQL 

## How to deploy

- Clone the repository.
```
git clone https://github.com/EresDev/Handwerker
```
- Install it.
```
composer install
yarn install
yarn encore dev
```
- Create MySQL database if you have not already created.
```
php bin/console doctrine:database:create  --if-not-exists
```
It will give you errors if there is a problem in connecting to MySQL. Fix them accordingly. 
You can update the database details in .env file.

- Create database schema
```
php bin/console doctrine:schema:create 
```
- Generate SSH keys
```
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:879329hr8uhgf7834rhgiuw834hr
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -passin pass:879329hr8uhgf7834rhgiuw834hr -pubout 
```
Here `879329hr8uhgf7834rhgiuw834hr` is the passphrase that you have to replace with one of your choice. If you are just performing a quick test, keep the value, it will help you get it working quickly but it must be taken care of before going to production.

- Update the JWT_PASSPHRASE in .env or .env.local

- Run the tests
```
composer test
```
Happy coding! 

# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## Portal Group Job Application Task

- Welcome to Portal Group job application task. This project written in Codeigniter 4 so first of all you need to install apache and php (8 and upper versions are better) to your computer.
- Composer is required.
- This project is only written RESTful and you need to install "Postman" or another rest api testing program or service.

## Portal Group RESTful Api and Codeigniter 4 Usage

- Clone this project to your desktop or localhost.
- Open this project with your code editor and open in terminal run `composer require`
- Create a Mysql database on your phpMyAdmin or something database management tool.
- Copy `env` file and rename it to `.env` 
- Open `.env` file and change database configurations with your configurations

Add this lines for jwt token:

- Line 1 : `JWT_SECRET_KEY=kzUf4sxss4AeG5uHkNZAqT1Nyi1zVfpz`
- Line 2 : `JWT_TIME_TO_LIVE=3600`

- Open terminal and run the migration: `php spark migrate`
- After then run the company seeder: `php spark db:seed`
- Run : `CompanySeeder.php`
- After then run the client seeder: `php spark db:seed`
- Run : `ClientSeeder.php`

You can find company login informations in CompanySeeder.php or you can create new company.

## Routes

# Company

- `http://localhost:8080/auth/login` for company login
- `http://localhost:8080/auth/register` for company register

# Client

You must login to company and you need to bearer token for requests.

- [GET] `http://localhost:8080/client/` for get all clients
- [POST] `http://localhost:8080/client/` for client register
- [GET] `http://localhost:8080/client/show/{id}` for get one client
- [POST] `http://localhost:8080/client/{id}` for client update
- [DELETE] `http://localhost:8080/client/{id}` for client update


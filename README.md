# TRANSFERS API

RESTFul money transfer API built with laravel, mysql and docker.

## Dependencies

The installation process depends on docker and docker-compose. We are going to assume you have it installed for the following guide.

- [docker](https://www.docker.com)
- [docker-compose](https://docs.docker.com/compose/install)

## Installation

### Docker containers with Sail

First we need to download and build the laravel sail images:

    docker-compose up -d

This will take a couple of minutes when you run it for the first time. In the future it gets a lot faster.

### Environment Variables

Next we need to copy the env.example file:

    cp .env.example .env

### Composer dependencies

Run the following command to install the composer.json dependencies.

    ./composer.sh install

### Setting up the database

Run the following command to set up your database migrations and seed it with dummy data.

    ./artisan.sh migrate --seed

If you get a warning, followed by the question `Do you really wish to run this command?` simply type `yes`  and hit enter.

## About

**This API was built by [Rodrigo Santorato](https://www.linkedin.com/in/rodrigo-santorato-dev/)**

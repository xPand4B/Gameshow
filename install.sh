#!/bin/bash

# Project dependencies
composer install --prefer-dist --optimize-autoloader --no-suggest

# Install application
php artisan install

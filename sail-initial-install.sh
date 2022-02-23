#!/bin/bash

# Styles
#=================================
red=`tput setaf 1`
green=`tput setaf 2`
reset=`tput sgr0`

# Check if .env and auth.json exists
#=====================================
shouldExit=false

echo ""

if [ ! -f ".env" ]; then
    cp .env.example .env
    echo -e "${green}File '.env' did not exist and has been created.${reset}"
    shouldExit=true
fi

if [ -f "auth.json.dist" ] && [ ! -f "auth.json" ]; then
    cp auth.json.dist auth.json
    echo -e "${green}File 'auth.json' did not exist and has been created.${reset}"
    shouldExit=true
fi

if [ "$shouldExit" = true ]; then
    echo ""
    echo -e "${red}Please enter your credentials inside the newly created files before continuing!${reset}"
    exit;
fi


# Run composer install
# https://laravel.com/docs/8.x/sail#installing-composer-dependencies-for-existing-projects
#=====================================
#docker run --rm \
#    -u "$(id -u):$(id -g)" \
#    -v $(pwd):/var/www/html \
#    -w /var/www/html \
#    laravelsail/php80-composer:latest \
#    composer install --ignore-platform-reqs --prefer-dist --optimize-autoloader --no-progress

# Start sail
#=====================================
./vendor/bin/sail up -d

# Wait until container is started
#=====================================
until [ "`docker inspect -f {{.State.Health.Status}} gameshow-mysql`"=="healthy" ]; do
    echo "Waiting for MySQL container..."
    sleep 0.5;
done;

# Install application
#=====================================
./vendor/bin/sail artisan migrate:fresh --seed --force
#./vendor/bin/sail artisan down
#./vendor/bin/sail artisan app:install
#./vendor/bin/sail artisan up

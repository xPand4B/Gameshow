## Gameshow
![Build Status](https://github.com/xPand4B/Gameshow/workflows/CI/badge.svg)

This should be an interactive website to manage a live online Game-Show with twitch chat-integration.

## Table of content
* [How to setup](#how-to-set-up)
    * [Local Setup](#local-setup)
    * [Docker Setup](#docker-setup)
* [Ideas](#ideas)
    * [Functions](#functions)
    * [Game Settings](#game-settings)
    * [Twitch-Chat](#twitch-chat)
    * [Screens](#screens)
    * [Workflow](#workflow)

## How to Set up
In order to set up this project you have to copy the file `.env.example` to `.env`
and fill in your database and [pusher](https://pusher.com/) credentials.

### Local Setup
```bash
# Project dependencies
composer install --prefer-dist --optimize-autoloader --no-suggest {--no-dev}

# Install application
php artisan install {--dev}

# Optional: Open dev server on 'http://127.0.0.1:8000'
php artisan serve
```

### Docker Setup
This project ships with a [Laravel Sail](https://laravel.com/docs/8.x/sail) setup. 
In order to use it properly follow these steps.

Sail will use your database credentials from the `.env` to create the MySQL container.

Check out the [official documentation](https://laravel.com/docs/8.x/sail) to learn more!
```bash
# Optional but recommended: Add sail as an bash alias
echo 'alias sail="bash vendor/bin/sail"' >> ~/.zshrc
# or
echo 'alias sail="bash vendor/bin/sail"' >> ~/.bash_profile

# Reload for changes to take effect
source ~/.zshrc
# or
source ~/.bash_profile

# Starting/stopping container (-d to start containers "detached" in the background)
# https://laravel.com/docs/8.x/sail#starting-and-stopping-sail
sail up {-d}
sail down

# Migrate database for the first time
sail artisan migrate
```
If you completed these steps the project should be accessible at [http://localhost](http://localhost).


### Useful Sail commands
```bash
# Run php artisan commands
sail artisan {SomeCommand}

# Install npm dependencies
sail npm install

# Run npm commands
sail npm run {dev|prod|watch}

# Running test suite
sail test
```

**Enjoy!**

## Ideas

### Functions
* Multiple sessions
* Based on communication, so only the game-master can log-in answers, grant joker etc. (he manages everything)
* Players can use joker (telephone, ...) which are granted by the game-master
* Fancy-animation to mark which player is currently playing
* Optional:
    * Integrated voice-chat + player-webcam-stream?

### Game Settings
* Set how many points per correct answer
    * Should other players get points if another player picks a wrong answer?
        * Players could guess if the current player knows the answer. If guess is correct, they get points.
* Set player max.
* Which jokers should be available? (telephone, chat, 50/50,...)

### Twitch-Chat
* Viewers can type in their guess for the current question. After the player's answer is logged in he gets points depending on how many viewers did know the answer
    * Possible points:
        * 30%  = 5p
        * 50%  = 4p
        * 75%  = 3p
        * 90%  = 2p
        * 90%+ = 1p

### Screens
* Player
    * Current question + possible answers
    * Points from other players
    * Optional: Note-field, Webcam-streaming 
* GameMaster
    * Current question + possible answers + correct answer
    * Can click on an answer to select it (changeable?)
    * Button to show if the answer is correct or not
    * Player overview (Names, Points, Webcam(?))
    * Can manually add/subtract points from players in case something went wrong
    * Can grant joker to a player
    * Can mark a player to indicate it's his turn
* Management
    * Add question + possible/correct answer (multiple choice?)


## Workflow
1. Create new Game
    - [x] Enter user-name.
    - [x] Click "Create new Game" button.
    - [x] Check if a game exists with the user-name as GameMaster. Create new one if not.
    - [x] Login user with the entered username.
    - [x] Return GameResource as response.
    - [x] Redirect to game-menu.
2. Game-Menu
    - [ ] ~~Logout user the there is still something in the cache.~~ Obsulet
    - [x] Ask for username if accessing via invite-link.
    - [x] Login user with the entered username.
    - [x] Check if lobby is full.
    - [x] Send an event that a user has joined.
    - [x] Subscribe to lobby updates.

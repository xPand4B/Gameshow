## Gameshow
This should be an interactive website to manage a live-online Game-Show with twitch-chat-integration.

## Ideas

### Functions
* Multiple sessions vs. Single-Game-Only with pre-defined login
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
* Viewers can type in their guess for the current question. After the player's answer is logged in he get's points depending on how many viewers did know the answer
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
    - Enter username and PIN
    - Click "Create new Game" button
    - Check if gamemaster already exists. Create new one if not.
    - Check if gamemaster has a running game. Crate new one if not.
    - Return GameResource as response.
    - Set game store.
    - Redirect to game menu
2. Game-Menu
    - Ask for username
    - Check if lobby is full 
    - Send event that a user has joined
    - Subscribe to lobby updates

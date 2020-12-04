<?php

namespace App\Events\Lobby;

use App\Models\Game;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LobbyLeftEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Game
     */
    public $game;

    /**
     * @var string
     */
    private $playerName;

    /**
     * Create a new event instance.
     *
     * @param Game $game
     * @param string $playerName
     */
    public function __construct(Game $game, string $playerName)
    {
        $this->game = $game;
        $this->playerName = $playerName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PresenceChannel|array
     */
    public function broadcastOn(): PresenceChannel
    {
        return new PresenceChannel('Game.'.$this->game->id.'.Lobby');
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'lobby.left';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'type' => 'lobby.left',
            'id' => $this->game->id,
            'attributes' => [
                'player' => $this->playerName,
            ],
        ];
    }
}

<?php

namespace App\Http\Resources\Joker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JokerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'joker',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
            ],
        ];
    }
}

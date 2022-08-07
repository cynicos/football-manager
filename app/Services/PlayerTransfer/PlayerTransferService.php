<?php

namespace App\Services\PlayerTransfer;

use App\Models\Player;

class PlayerTransferService
{
    public function transfer($data)
    {
        $player = Player::find($data['player_id']);

        $player->transfers()->create([
            'team_from' => $player->team_id,
            'team_to' => $data['team_to']
        ]);

        $player->update([
            'team_id' => $data['team_to']
        ]);
    }
}

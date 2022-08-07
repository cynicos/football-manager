<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerTransfer extends Model
{
    use HasFactory;

    protected $fillable = ['player_id', 'team_from', 'team_to'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function fromTeam()
    {
        return $this->belongsTo(Team::class, 'team_from');
    }

    public function toTeam()
    {
        return $this->belongsTo(Team::class, 'team_to');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'championship_id'];

    public function championship()
    {
        return $this->belongsTo(Championship::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}

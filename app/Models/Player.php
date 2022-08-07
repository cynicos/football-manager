<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'personal_number', 'team_id'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function transfers()
    {
        return $this->hasMany(PlayerTransfer::class);
    }
}

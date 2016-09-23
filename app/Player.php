<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $elo_rating
 */
class Player extends Model
{
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'elo_rating'
    ];

    /**
     * Get a list of matches played by the player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function matches()
    {
        return $this->belongsToMany(Match::class, 'match_players', 'player_id', 'match_id');
    }

    /**
     * Get player elo rating
     *
     * @return integer
     */
    public function getEloRatingAttribute()
    {
        return $this->attributes['elo_rating'];
    }
}
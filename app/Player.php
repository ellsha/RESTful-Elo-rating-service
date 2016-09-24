<?php

namespace App;

use App\Elo\PlayerInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Player
 *
 * @property integer $id
 * @property integer $elo_rating
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Match[] $matches
 * @mixin \Eloquent
 */
class Player extends Model implements PlayerInterface
{
    /**
     * Disabling timestamps.
     *
     * @var bool
     */
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
        'elo_rating',
    ];

    /**
     * Get a list of matches played by the player.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function matches()
    {
        return $this->belongsToMany(Match::class, 'match_players', 'player_id', 'match_id');
    }

    /**
     * Elo rating of the player.
     *
     * @return integer
     */
    public function getEloRating()
    {
        return $this->attributes['elo_rating'];
    }

    /**
     * Number of matches in which the player took part.
     *
     * @return integer
     */
    public function getMatchesCount()
    {
        return $this->matches()->count();
    }
}

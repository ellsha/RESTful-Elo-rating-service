<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $log
 * @property Carbon $started_at
 * @property Carbon $finished_at
 * @property integer $winner_id
 */
class Match extends Model
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
    protected $table = 'matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'started_at', 'finished_at', 'winner_id', 'log'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['started_at', 'finished_at'];

    /**
     * Return the players who took part in this match.
     */
    public function players()
    {
        return $this->belongsToMany(Player::class, 'match_players');
    }
}
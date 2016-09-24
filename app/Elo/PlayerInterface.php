<?php

namespace App\Elo;

interface PlayerInterface
{
    /**
     * Elo rating of the player.
     *
     * @return integer
     */
    public function getEloRating();

    /**
     * Number of matches in which the player took part.
     *
     * @return integer
     */
    public function getMatchesCount();
}
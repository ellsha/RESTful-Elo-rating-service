<?php

namespace App\Elo;

use App\Elo\PlayerInterface as Player;

class Elo
{
    /**
     * Calculate the elo rating.
     *
     * @param Player $player1 first player
     * @param Player $player2 second player
     *
     * @param float $win
     * 1.0 if the first player wins,
     * 0.0 if the first player loses,
     * 0.5 in the case of a draw
     *
     * @return array
     * [0] - a new rating of the first player
     * [1] - a new rating of the second player
     */
    private function calculate(Player $player1, Player $player2, $win)
    {
        $rating1 = $player1->getEloRating();
        $rating2 = $player2->getEloRating();

        $expectedScore = $this->expectedScore($rating1, $rating2);

        $eloUpdate1 = $win - $expectedScore;
        $eloUpdate2 = -$eloUpdate1;

        $eloUpdate1 *= $this->kFactor($player1);
        $eloUpdate2 *= $this->kFactor($player2);

        return [round($rating1 + $eloUpdate1, 0), round($rating2 + $eloUpdate2, 0)];
    }

    /**
     * Calculate the Elo rating if the first player won.
     *
     * @see Elo::calculate()
     * @param Player $winner
     * @param Player $loser
     *
     * @return array
     */
    public function win(Player $winner, Player $loser)
    {
        return $this->calculate($winner, $loser, 1);
    }

    /**
     * Calculate the Elo rating if the first player lose.
     *
     * @see Elo::calculate()
     * @param PlayerInterface $winner
     * @param PlayerInterface $loser
     *
     * @return array
     */
    public function lose(Player $winner, Player $loser)
    {
        return $this->calculate($winner, $loser, 0);
    }

    /**
     * Calculate the Elo rating if the match ended in a draw.
     *
     * @see Elo::calculate()
     * @param Player $player1
     * @param Player $player2
     *
     * @return array
     */
    public function draw(Player $player1, Player $player2)
    {
        return $this->calculate($player1, $player2, 0.5);
    }

    /**
     * Calculate the player's coefficient.
     *
     * @param Player $player
     *
     * @return int
     */
    public function kFactor(Player $player)
    {
        if ($player->getMatchesCount() <= 30) {
            return 40;
        }

        if ($player->getEloRating() < 2400) {
            return 20;
        }

        return 10;
    }

    /**
     * Calculate the player's expected score.
     *
     * @param $rating1
     * @param $rating2
     *
     * @return float|int
     */
    private function expectedScore($rating1, $rating2)
    {
        return 1 / (1 + pow(10, ($rating2 - $rating1) / 400));
    }
}
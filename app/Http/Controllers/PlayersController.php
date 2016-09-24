<?php

namespace App\Http\Controllers;

use App\Player;

class PlayersController extends Controller
{
    /**
     * Get a list of matches played by a given player.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function matches($id)
    {
        /** @var Player $player */
        $player  = Player::findOrFail($id);
        $matches = $player->matches()->with('players')->get();

        return response()->json($matches);
    }

    /**
     * Get player rating.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function rating($id)
    {
        /** @var Player $player */
        $player = Player::findOrFail($id);

        return response()->json($player->elo_rating);
    }
}
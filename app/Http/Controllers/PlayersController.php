<?php

namespace App\Http\Controllers;

use App\Player;

class PlayersController extends Controller
{
    /**
     * Get a list of matches played by a given player
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function matches($id)
    {
        return response()->json(Player::find($id)->matches()->with('players')->get());
    }

    /**
     * Get player rating
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function rating($id)
    {
        return response()->json(Player::find($id)->elo_rating);
    }
}
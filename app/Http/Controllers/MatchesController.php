<?php

namespace App\Http\Controllers;

use App\Elo\Elo;
use App\Exceptions\Exception;
use App\Http\Requests\CreateMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Http\Requests\IndexMatchRequest;
use App\Match;
use App\Player;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MatchesController extends Controller
{
    /**
     * Get a list of matches.
     *
     * @param IndexMatchRequest $request
     * @return JsonResponse
     */
    public function index(IndexMatchRequest $request)
    {
        if ($request->has('start') && $request->has('end')) {
            $matches = Match::with('players')
                ->where('started_at', '>', $request->start)
                ->where('started_at', '<', $request->end)
                ->get();

            return response()->json($matches);
        }

        $matches = Match::with('players')->get();

        return response()->json($matches);
    }

    /**
     * Save the match result.
     *
     * @param CreateMatchRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(CreateMatchRequest $request)
    {
        $players = Player::whereIn('id', $request->players_id)->get();

        if (count($players) != 2) {
            throw new Exception('A player or players with such ids does not exist.');
        }

        $this->updatePlayersRating($players, $request->winner_id);

        $match = new Match();
        $match->started_at = $request->started_at;
        $match->finished_at = $request->finished_at;
        $match->winner_id = $request->winner_id;
        $match->log = $request->log ?: null;
        $match->save();
        $match->players()->attach($players);

        return response()->json($match->fresh('players'), Response::HTTP_CREATED);
    }

    /**
     * Set new values for player's rating after the match.
     *
     * @param $players
     * @param $winner_id
     * @throws Exception
     */
    private function updatePlayersRating($players, $winner_id)
    {
        if ($players[0]->id != $winner_id &&
            $players[1]->id != $winner_id) {
            throw new Exception('Winner id is not correct.');
        }

        $elo = new Elo();

        if ($players[0]->id == $winner_id) {
            $ratings = $elo->win($players[0], $players[1]);
        } else {
            $ratings = $elo->lose($players[0], $players[1]);
        }

        $players[0]->elo_rating = $ratings[0];
        $players[1]->elo_rating = $ratings[1];

        $players[0]->save();
        $players[1]->save();
    }

    /**
     * Get information about the match.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $match = Match::with('players')->findOrFail($id);

        return response()->json($match);
    }

    /**
     * Edit match data.
     *
     * @param UpdateMatchRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(UpdateMatchRequest $request, $id)
    {
        $match = Match::findOrFail($id);

        if ($request->has('started_at')) {
            $match->started_at = $request->started_at;
        }

        if ($request->has('finished_at')) {
            $match->finished_at = $request->finished_at;
        }

        if ($request->has('log')) {
            $match->log = $request->log;
        }

        $match->save();

        return response()->json($match->fresh('players'));
    }

    /**
     * Delete the information about the match.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Match::destroy($id);

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Elo\Elo;
use App\Exceptions\Exception;
use App\Http\Requests\CreateMatchRequest;
use App\Http\Requests\IndexMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Match;
use App\Player;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $matches = Match::with('players');

        if ($request->has('start') && $request->has('end')) {
            $matches->where('started_at', '>', $request->start)
                ->where('started_at', '<', $request->end);
        }

        return response()->json($matches->get());
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
            throw new ModelNotFoundException('A player or players with such ids does not exist.');
        }

        $match = new Match();

        $match->started_at  = $request->started_at;
        $match->finished_at = $request->finished_at;
        $match->winner_id   = $request->winner_id;
        $match->log         = $request->log ?: null;

        if (!$match->save()) {
            throw new Exception('The model has not been saved.');
        }

        $this->updatePlayersRating($players[0], $players[1], $request->winner_id);
        $match->players()->attach($players);

        return response()->json($match->fresh('players'), Response::HTTP_CREATED);
    }

    /**
     * Set new values for player's rating after the match.
     *
     * @param Player $winner
     * @param Player $loser
     * @param $winner_id
     * @throws Exception
     */
    private function updatePlayersRating(Player $winner, Player $loser, $winner_id)
    {
        $elo = new Elo();

        if ($winner->id == $winner_id) {
            $ratings = $elo->win($winner, $loser);
        } else {
            $ratings = $elo->lose($winner, $loser);
        }

        $winner->elo_rating = $ratings[0];
        $loser->elo_rating  = $ratings[1];

        $winner->save();
        $loser->save();
    }

    /**
     * Get information about the match.
     *
     * @param  int $id
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

        $match->started_at  = $request->get('started_at', $match->started_at);
        $match->finished_at = $request->get('finished_at', $match->finished_at);
        $match->log         = $request->get('log', $match->log);

        $match->save();

        return response()->json($match->fresh('players'));
    }

    /**
     * Delete the information about the match.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Match::destroy($id);

        return response()->json(null, 204);
    }
}

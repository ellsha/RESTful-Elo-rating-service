<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Match;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MatchesController extends Controller
{
    /**
     * Get a list of matches
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
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
     * Save the match result
     *
     * @param CreateMatchRequest $request
     * @return JsonResponse
     */
    public function store(CreateMatchRequest $request)
    {
        $players_id = ($request->players_id);

        $match = new Match();
        $match->started_at = $request->started_at;
        $match->finished_at = $request->finished_at;
        $match->winner_id = $request->winner_id;
        $match->log = $request->log ?: null;
        $match->save();
        $match->players()->attach($players_id);

        return response()->json($match->fresh('players'), Response::HTTP_CREATED);
    }

    /**
     * Get information about the match
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
     * Edit match data
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
        if ($request->has('winner_id')) {
            $match->winner_id = $request->winner_id;
        }
        if ($request->has('log')) {
            $match->log = $request->log;
        }
        if ($request->has('players_id')) {
            $players = $request->players_id;
            $match->players()->detach();
            $match->players()->attach($players);
        }

        $match->save();

        return response()->json($match->fresh('players'));
    }

    /**
     * Delete the information about the match
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Match::destroy($id);

        response()->json()->setStatusCode(200, 'OK');
    }
}

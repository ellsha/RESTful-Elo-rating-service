<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Get a list of matches
 */
Route::match(
    ['GET', 'HEAD'],
    'matches',
    'MatchesController@index'
)->name('matches.index');

/**
 * Get information about the match
 */
Route::match(
    ['GET', 'HEAD'],
    'matches/{match}',
    'MatchesController@show'
)->name('matches.show');

/**
 * Save the match result
 */
Route::post(
    'matches/',
    'MatchesController@store'
)->name('matches.store');

/**
 * Edit match data
 */
Route::match(
    ['PUT', 'PATCH'],
    'matches/{match}',
    'MatchesController@update'
)->name('matches.update');

/**
 * Delete information about the match
 */
Route::delete(
    'matches/{match}',
    'MatchesController@destroy'
)->name('matches.destroy');

/**
 * Get a list of matches played by a given player
 */
Route::match(
    ['GET', 'HEAD'],
    'players/{player}/matches',
    'PlayersController@matches'
)->name('players.matches');

/**
 * Get player rating
 */
Route::match(
    ['GET', 'HEAD'],
    'players/{player}',
    'PlayersController@rating'
)->name('players.rating');


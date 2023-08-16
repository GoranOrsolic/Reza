<?php

use App\Http\Controllers\SeasonStandingsController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\SportsController::class, 'index'])->name('index');

Route::get('/{id}', [App\Http\Controllers\SportsController::class, 'show'])->name('index');

Route::get('/standings/{tournamentId}', [SeasonStandingsController::class, 'show'])->name('standings');



//Route::get('/football', [App\Http\Controllers\SportsController::class, 'show'])->name('football.index');

Route::get('/{id}', [App\Http\Controllers\SportsController::class, 'show'])->name('sport');


Route::get('/football/tournaments/{id}', [App\Http\Controllers\FootballController::class, 'index'])->name('football.tournaments');

Route::get('/seasons/{id}', [App\Http\Controllers\FootballController::class, 'show'])->name('seasons');

/*Route::get('/standings/{ide}/{url}', [App\Http\Controllers\FootballController::class, 'standings'])->name('standings');*/

Route::get('/team/football/{id}', [App\Http\Controllers\FootballController::class, 'footballTeam'])->name('team.football');

Route::get('/team/football/page/{page?}', [App\Http\Controllers\FootballController::class, 'footballTeam'])->name('team.football');





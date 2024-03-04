<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Rutas de autenticación
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

// Rutas protegidas que requieren autenticación con Passport y middleware de roles
Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::post('/players', 'PlayerController@store'); // Crear jugador
    Route::put('/players/{id}', 'PlayerController@update'); // Modificar el nombre del jugador
    Route::delete('/players/{id}/games', 'PlayerController@destroyGames'); // Eliminar las tiradas del jugador
    Route::get('/players', 'PlayerController@index'); // Listado de todos los jugadores con su porcentaje medio de éxitos
    Route::get('/players/{id}/games', 'GameController@index'); // Listado de jugadas por un jugador
    Route::post('/players/{id}/games', 'GameController@store'); // Ruta para tirar dados de un jugador
    Route::get('/players/ranking', 'PlayerController@ranking'); // Ranking medio de todos los jugadores
    Route::get('/players/ranking/loser', 'PlayerController@getLoser'); // Jugador con peor porcentaje de éxito
    Route::get('/players/ranking/winner', 'PlayerController@getWinner'); // Jugador con mejor porcentaje de éxito
});

// Rutas protegidas que requieren autenticación con Passport y middleware de usuario
Route::middleware(['auth:api', 'user'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


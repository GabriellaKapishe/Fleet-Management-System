<?php
use App\Http\Controllers\FleetServiceStationController;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*************************************Third Party Transactions ***********************************/
Route::post("/post/transaction", "TransactionController@createTransaction");
Route::post("/check/balance", "TransactionController@checkBalance");
Route::get("/batch-cut-off/{imei}", "TransactionController@batchCutOff");

Route::post('/save/fleet-service-station','FleetServiceStationController@create');
Route::get('/get/fleet-service-station','FleetServiceStationController@read');
Route::put('/update/fleet-service-station/{id}','FleetServiceStationController@update');
Route::delete('/delete/fleet-service-station/{id}','FleetServiceStationController@destroy');

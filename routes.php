<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/test', function()
{
	$city = City::all();
	showDebug($city, false);
	exit();
});

Route::get('/ffxiv', function()
{
	try{
		$api = new Viion\Lodestone\API;
		showDebug($api);
	}
	catch (Exception $e){
		showDebug($e);
	}

});

function showDebug($item, $exit = true)
{
	echo '<pre>';
	print_r($item);
	echo '</pre>';
	if ($exit)
	{
		exit();
	}
}
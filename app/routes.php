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


Route::get('/dump/{server}/{name}', function($server, $name)
{
	$api = new FFAPI;
	$char = $api->loadBasicCharacter(urldecode($name), urldecode($server));
	showDebug($char);
});

Route::get('/view/{server}/{name}', function($server, $name)
{
	$api = new FFAPI;
	$char = $api->loadBasicCharacter(urldecode($name), urldecode($server));
	return View::make('content.character')->withCharacter($char);
});
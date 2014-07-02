<?php

function showDebug($item, $exit = true)
{
	echo '<pre>';
	print_r($item);
	echo '</pre>';
	if ($exit){
		exit();
	}
}

function distanceMeters($lat1, $lon1, $lat2, $lon2)
{
	$x = deg2rad( $lon1 - $lon2 ) * cos( deg2rad( $lat1 ) );
	$y = deg2rad( $lat1 - $lat2 );
	$dist = 6371000.0 * sqrt( $x*$x + $y*$y );
	$dist = $dist * 0.00062137; // turn it to miles
	return $dist;
}

function mapTerm($term)
{
	switch(strtolower($term)){
		case 'strength':
			$match = 'STR';
			break;
		case 'dexterity':
			$match = 'DEX';
			break;
		case 'vitality':
			$match = 'VIT';
			break;
		case 'intelligence':
			$match = 'INT';
			break;
		case 'mind':
			$match = 'MND';
			break;
		case 'piety':
			$match = 'PIE';
			break;
		default:
			$match = $term;
			break;
	}
	return $match;
}

?>
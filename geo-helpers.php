<?php

/**
 * Useful geographic helper functions.
 *
 * @author Marco Del Tongo <info@marcodeltongo.com>
 * @copyright Copyright (c) 2011, Marco Del Tongo
 *
 * @license http://opensource.org/licenses/mit-license Licensed under the MIT license.
 * @version 1.0
 */

// _____________________________________________________________________________

/**
 * Calculate distance using the haversine equation
 *
 * @param float $latitude_a
 * @param float $longitude_a
 * @param float $latitude_b
 * @param float $longitude_b
 *
 * @return float
 */
function geo_distance($latitude_a, $longitude_a, $latitude_b, $longitude_b)
{
	return round(6371 * acos(cos(deg2rad($latitude_a)) * cos(deg2rad($latitude_b)) * cos(deg2rad($longitude_b) - deg2rad($longitude_a)) + sin(deg2rad($latitude_a)) * sin(deg2rad($latitude_b))), 6);
}
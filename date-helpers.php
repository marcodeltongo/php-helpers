<?php

/**
 * Useful date helper functions.
 *
 * @author Marco Del Tongo <info@marcodeltongo.com>
 * @copyright Copyright (c) 2011, Marco Del Tongo
 *
 * @license http://opensource.org/licenses/mit-license Licensed under the MIT license.
 * @version 1.0
 */

// _____________________________________________________________________________

/**
 * Formats an Italian date and time with ISO8601 standard.
 *
 * @param string $date
 * @param string $time
 * @param boolean $fullDay
 * @return string
 */
function dateIT2ISO8601($date, $time = null, $fullDay = false)
{
	$ret = null;
	if (!empty($date)) {
		$date = explode('/', $date);
		$ret = $date[2] . '-' . $date[1] . '-' . $date[0] . 'T';
		if (!empty($time)) {
			$ret .= $time;
			if (strlen($time) == 5) {
				$ret .= ($fullDay) ? ':59' : ':00';
			}
		} else {
			$ret .= ($fullDay) ? '23:59:59' : '00:00:00';
		}
		$ret .= 'Z';
	}

	return $ret;
}
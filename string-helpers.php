<?php

/**
 * Useful string helper functions.
 *
 * @author Marco Del Tongo <info@marcodeltongo.com>
 * @copyright Copyright (c) 2011, Marco Del Tongo
 *
 * @license http://opensource.org/licenses/mit-license Licensed under the MIT license.
 * @version 1.0
 */

// _____________________________________________________________________________

/**
 * Find first occurrence of a string (case-sensitive).
 *
 * Returns part of haystack string:
 * - from start to the first occurrence of needle
 * - from first occurrence of needle to the end
 *
 * @param   string  $source    String to filter
 * @param   mixed   $needle    Break point
 * @param   boolean $fromStart Return from start or to end
 *
 * @return  string  Returns a part of passed string or all if needle not found
 */
function str_part($source, $needle, $fromStart = true)
{
    # Get needle position.
    if (is_string($needle)) {
        $needle = strpos($source, $needle);
        if ($needle === false) {
            return $source;
        }
    }
    return ($fromStart) ? substr($source, 0, $needle) : substr($source, $needle + 1);
}

// _____________________________________________________________________________

/**
 * Find last occurrence of a string (case-sensitive).
 *
 * Returns part of haystack string:
 * - from start to the last occurrence of needle
 * - from last occurrence of needle to the end
 *
 * @param   string  $source    String to filter
 * @param   mixed   $needle    Break point
 * @param   boolean $fromStart Return from start or to end
 *
 * @return  string  Returns a part of passed string or all if needle not found
 */
function str_rpart($source, $needle, $fromStart = true)
{
    # Get needle position.
    if (is_string($needle)) {
        $needle = strrpos($source, $needle);
        if ($needle === false) {
            return $source;
        }
    }
    return ($fromStart) ? substr($source, 0, $needle) : substr($source, $needle + 1);
}

// _____________________________________________________________________________

/**
 * Find first occurrence of a string (case-insensitive).
 *
 * Returns part of haystack string:
 * - from start to the first occurrence of needle
 * - from first occurrence of needle to the end
 *
 * @param   string  $source    String to filter
 * @param   mixed   $needle    Break point
 * @param   boolean $fromStart Return from start or to end
 *
 * @return  string  Returns a part of passed string or all if needle not found
 */
function str_ipart($source, $needle, $fromStart = true)
{
    # Get needle position.
    if (is_string($needle)) {
        $needle = stripos($source, $needle);
        if ($needle === false) {
            return $source;
        }
    }
    return ($fromStart) ? substr($source, 0, $needle) : substr($source, $needle);
}

// _____________________________________________________________________________

/**
 * Reverse of nl2br.
 *
 * @param   string  $source    String to filter
 *
 * @return  string  Returns a string with <br>'s converted to newlines
 */
function br2nl($source)
{
    return preg_replace("=<br */?>=i", "\n", preg_replace("/(\r\n|\n|\r)/", "", $source));
}

// _____________________________________________________________________________

/**
 * Crops text at length, preserve the last word, and adds "&hellip;".
 *
 * @param   string  $source    String to filter
 * @param   int     $length    String length limit
 * @param   boolean $lastWord  Should last word be preserved ?
 *
 * @return  string  Returns a cropped string
 */
function add_dots($source, $length, $lastWord = true)
{
    if (strlen($source) > $length) {
        if ($lastWord) {
            $source = substr($source, 0, $length);
            $lastSpace = strrpos($source, " ");
            $source = substr($source, 0, $lastSpace);
        } else {
            $source = substr($source, 0, $length);
        }
        $source .= '&hellip;';
    }
    return $source;
}

// _____________________________________________________________________________

/**
 * Trim slashes.
 *
 * @param   string  $source    String to filter
 *
 * @return  string  Returns slash-trimmed string
 */
function trim_slashes($source)
{
    return preg_replace('|^/*(.+?)/*$|', '$1', $source);
}

// _____________________________________________________________________________

/**
 * Converts double slashes to single except for those after ":" like in http://
 *
 * @param   string  $source    String to filter
 *
 * @return  string  Returns filtered string
 */
function reduce_double_slashes($source)
{
    return preg_replace("|([^:])//+|", "$1/", $source);
}

// _____________________________________________________________________________

/**
 * Alternates strings.
 *
 * @param   mixed   $parameter  Strings to alternate
 *
 * @return  string  Returns one string from the passed ones
 */
function str_alternate($params)
{
    static $counters = array();

    # What has been passed ?
    if (func_num_args() > 1) {
        # Get all the parameters as an array.
        $args = func_get_args();
    } else {
        # Remove keys reindexing as 0, 1, 2, ...
        $args = array_values($params);
    }

    # Build static key.
    $key = crc32(implode($args));
    $counters[$key] = isset($counters[$key]) ? ++$counters[$key] : 0;
    return $args[($counters[$key] % count($args))];
}

// _____________________________________________________________________________

/**
 * Returns a random string
 *
 * @param   string  $pool      Set of chars to use
 * @param   integer $length    Length of the string
 *
 * @return  string  Generated string
 */
function random_string($pool, $length)
{
    $generated = '';
    for ($i = 0; $i < $length; ++$i) {
        $generated .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
    }
    return $generated;
}

// _____________________________________________________________________________

/**
 * Returns a random non-numeric string
 *
 * @param   integer $length    Length of the string
 *
 * @return  string  Generated string
 */
function random_alpha_string($length)
{
    return random_string('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length);
}

// _____________________________________________________________________________

/**
 * Returns a random alphanumeric string
 *
 * @param   integer $length    Length of the string
 *
 * @return  string  Generated string
 */
function random_alnum_string($length)
{
    return random_string('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length);
}

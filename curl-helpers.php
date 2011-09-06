<?php

/**
 * Useful cURL helper functions.
 *
 * @author Marco Del Tongo <info@marcodeltongo.com>
 * @copyright Copyright (c) 2011, Marco Del Tongo
 *
 * @license http://opensource.org/licenses/mit-license Licensed under the MIT license.
 * @version 1.0
 */

// _____________________________________________________________________________

/**
 * Send a POST request using cURL
 *
 * @param string $url to request
 * @param array $post values to send
 * @param array $options for cURL
 *
 * @return mixed
 */
function curl_http_post($url, array $post = array(), array $options = array())
{
	/*
	 * Prepare options
	 */
	$defaults = array(
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_URL => $url,
		CURLOPT_FRESH_CONNECT => 1,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_FORBID_REUSE => 1,
		CURLOPT_TIMEOUT => 4,
		CURLOPT_POSTFIELDS => http_build_query($post)
	);

	/*
	 * Make request
	 */
	$ch = curl_init();
	curl_setopt_array($ch, ($options + $defaults));
	$result = curl_exec($ch);
	if (false === $result) {
		/*
		 * Return error
		 */
		return array('errno' => curl_errno($ch), 'error' => curl_error($ch));
	}
	curl_close($ch);

	/*
	 * Return response
	 */
	return $result;
}

// _____________________________________________________________________________

/**
 * Send a GET request using cURL
 *
 * @param string $url to request
 * @param array $get values to send
 * @param array $options for cURL
 *
 * @return string
 */
function curl_http_get($url, array $get = array(), array $options = array())
{
	/*
	 * Prepare options
	 */
	$defaults = array(
		CURLOPT_URL => $url . (strpos($url, '?') === FALSE ? '?' : '') . http_build_query($get),
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_TIMEOUT => 4
	);

	/*
	 * Make request
	 */
	$ch = curl_init();
	curl_setopt_array($ch, ($options + $defaults));
	$result = curl_exec($ch);
	if (false === $result) {
		/*
		 * Return error
		 */
		return array('errno' => curl_errno($ch), 'error' => curl_error($ch));
	}
	curl_close($ch);

	/*
	 * Return response
	 */
	return $result;
}
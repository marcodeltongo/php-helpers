<?php

/**
 * Useful array helper functions.
 *
 * @author Marco Del Tongo <info@marcodeltongo.com>
 * @copyright Copyright (c) 2011, Marco Del Tongo
 *
 * @license http://opensource.org/licenses/mit-license Licensed under the MIT license.
 * @version 1.1
 */

// _____________________________________________________________________________

/**
 * Returns array elements or default value if not set / empty.
 *
 * @param   string  $needle    Element key
 * @param   array   $haystack  Array stack
 * @param   mixed   $default   Optional default value
 *
 * @return	mixed	Returns array elements or default value if not set / empty
 */
function array_element($needle, array $haystack, $default = null)
{
	if (isset($haystack[$needle]) and $haystack[$needle] !== '') {
		return $haystack[$needle];
	}
	return $default;
}

// _____________________________________________________________________________

/**
 * Returns a random element of the passed array.
 *
 * @param   array   $haystack  Array stack
 *
 * @return	boolean	Returns a random element of the passed array.
 */
function array_random(array $haystack)
{
	if (is_array($haystack)) {
		return $haystack[array_rand($haystack)];
	}
	return $haystack;
}

// _____________________________________________________________________________

/**
 * Returns true if an array is an associative array.
 *
 * @param   array   $array     Array to check
 *
 * @return	boolean	Returns true if an array is an associative array
 */
function is_assoc(array $array)
{
	return (bool) array_diff_assoc(array_keys($array), range(0, count($array)));
}

// _____________________________________________________________________________

/**
 * Returns an array with the object variables.
 *
 * @param   object  $source       Object to get vars from
 *
 * @return	array	Returns an array with the object variables
 */
function object_to_array($source)
{
	if (!is_object($source)) {
		return $source;
	}
	/*
	  If object has toArray method, use it.
	 */
	if (method_exists($source, 'toArray')) {
		return $source->toArray();
	}
	/*
	  Loop through object vars.
	 */
	$ret = array();
	foreach (get_object_vars($source) as $k => $v) {
		if (is_object($v)) {
			if ($source !== $v) {
				$ret[$k] = object_to_array($source);
			}
		} else {
			$ret[$k] = $v;
		}
	}
	return $ret;
}

// _____________________________________________________________________________

/**
 * Returns true if array is an array contains other arrays.
 *
 * @param   array   $array     Array to check
 *
 * @return	boolean	Returns true if array is an array contains other arrays
 */
function is_array_array(array $array)
{
	foreach ($array as $element) {
		if (is_array($element)) {
			return true;
		}
	}
	return false;
}

// _____________________________________________________________________________

/**
 * Returns how many levels an array has.
 *
 * @param   array   $array     Array to check
 * @param   integer $level     Current level deepness
 *
 * @return	integer	Returns how many levels an array has
 */
function array_levels(array $array, $level = 0)
{
	if (empty($array)) {
		return 0;
	}
	$levels = array(++$level);
	foreach ($array as $element) {
		if (is_array($element)) {
			$levels[] = array_levels($element, $level);
		}
	}
	return max($levels);
}

// _____________________________________________________________________________

/**
 * Adds string as prefix and postfix to each array element.
 *
 * @param   array   $array     Array to untrim
 * @param   string  $chars     Characters to add
 *
 * @return	array	Untrimmed array
 */
function array_untrim(array $array, $chars = null)
{
	foreach ($array as &$value) {
		$value = $chars . $value . $chars;
	}
	return $array;
}

// _____________________________________________________________________________

/**
 * @ignore
 */
function __array_trim_callback(&$v, $k, $params)
{
	if (is_null($params[1])) {
		$v = $params[0]($v);
	} else {
		$v = $params[0]($v, $params[1]);
	}
}

// _____________________________________________________________________________

/**
 * Trims each array element.
 *
 * @param   array   $array     Array to trim
 * @param   string  $chars     Characters to trim
 *
 * @return	array	Trimmed array
 */
function array_trim(array $array, $chars = null)
{
	array_walk($array, '__array_trim_callback', array('trim', $chars));
	return $array;
}

// _____________________________________________________________________________

/**
 * Right-trims each array element.
 *
 * @param   array   $array     Array to trim
 * @param   string  $chars     Characters to trim
 *
 * @return	array	Trimmed array
 */
function array_rtrim(array $array, $chars = null)
{
	array_walk($array, '__array_trim_callback', array('rtrim', $chars));
	return $array;
}

// _____________________________________________________________________________

/**
 * Left-trims each array element.
 *
 * @param   array   $array     Array to trim
 * @param   string  $chars     Characters to trim
 *
 * @return	array	Trimmed array
 */
function array_ltrim(array $array, $chars = null)
{
	array_walk($array, '__array_trim_callback', array('ltrim', $chars));
	return $array;
}

// _____________________________________________________________________________

/**
 * Rebuild an array of arrays using an inner value as key.
 *
 * @param   array           Source array
 * @param   string|integer  New key
 * @param   boolean         Remove from array
 * @param   string|integer  Optional element name for old key
 *
 * @return  array
 */
function array_key_from_value(array $source, $key, $remove = false, $oldTo = null)
{
	if (null === $source or empty($source))
		return array();
	$data = array();
	foreach ($source as $old => $src) {
		# Prepare new key.
		$val = $src[$key];
		# Remove new key from array.
		if ($remove)
			unset($src[$key]);
		# Save old key.
		if (null !== $oldTo) {
			$src[$oldTo] = $old;
		}
		# Save with new key.
		$data[$val] = $src;
	}
	return $data;
}

// _____________________________________________________________________________

/**
 * Remove keys with empty values
 *
 * @param   array           Source array
 *
 * @return  array
 */
function array_remove_empty(array $source)
{
	if (null === $source or empty($source)) {
		return $source;
	}
	$data = array();
	foreach ($source as $key => $val) {
		if (null !== $val and !empty($val)) {
			if (is_array($val)) {
				$val = array_remove_empty($val);
			}
			$data[$key] = $val;
		}
	}
	return $data;
}

// _____________________________________________________________________________

/**
 * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
 *
 * @param array $source
 * @param string $rootNodeName
 * @param SimpleXMLElement $xml
 * @return string
 */
function array_to_xml(array $source, $rootNodeName = 'root', &$xml = null)
{
	if (is_null($xml)) {
		$xml = new SimpleXMLElement('<' . $rootNodeName . '/>');
	}

	# loop through the data passed in.
	foreach ($source as $key => $value) {
		# if numeric key, assume array of rootNodeName elements
		if (is_numeric($key)) {
			$key = $rootNodeName;
		}
		# Check if is attribute
		if ($key == '_attributes') {
			# Add attributes to node
			foreach ($value as $attr_name => $attr_value) {
				$xml->addAttribute($attr_name, $attr_value);
			}
		} else {
			# delete any char not allowed in XML element names
			$key = preg_replace('/[^a-z0-9\-\_\.\:]/i', '', $key);

			# if there is another array found recrusively call this function
			if (is_array($value)) {
				# create a new node unless this is an array of elements
				$node = is_assoc($value) ? $xml->addChild($key) : $xml;
				# recursive call - pass $key as the new rootNodeName
				array_to_xml($value, $key, $node);
			} else {
				# add single node
				$value = htmlentities($value);
				$xml->addChild($key, $value);
			}
		}
	}

	return $xml->asXML();
}

// _____________________________________________________________________________

/**
 * Pass in a XML document and this recrusively loops through and builds up an array.
 *
 * @param SimpleXMLElement $obj
 * @param array $arr
 * @return array
 */
function xml_to_array($obj, &$arr = null)
{
	if (is_null($arr)) {
		$arr = array();
	}
	if (is_string($obj)) {
		$obj = new SimpleXMLElement($obj);
	}

	# Get attributes for current node and add to current array element
	$attributes = $obj->attributes();
	foreach ($attributes as $attrib => $value) {
		$arr['_attributes'][$attrib] = (string) $value;
	}

	$children = $obj->children();
	$executed = false;
	# Check all children of node
	foreach ($children as $elementName => $node) {
		# Check if there are multiple node with the same key and generate a multiarray
		if (isset($arr[$elementName])) {
			if (!empty($arr[$elementName][0])) {
				$i = count($arr[$elementName]);
				xml_to_array($node, $arr[$elementName][$i]);
			} else {
				$tmp = $arr[$elementName];
				$arr[$elementName] = array();
				$arr[$elementName][0] = $tmp;
				$i = count($arr[$elementName]);
				xml_to_array($node, $arr[$elementName][$i]);
			}
		} else {
			$arr[$elementName] = array();
			xml_to_array($node, $arr[$elementName]);
		}
		$executed = true;
	}

	# Check if is already processed and if already contains attributes
	if (!$executed && $children->getName() == "" && !isset($arr['_attributes'])) {
		$arr = (string) $obj;
	}

	return $arr;
}
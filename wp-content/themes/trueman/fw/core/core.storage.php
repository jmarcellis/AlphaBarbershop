<?php
/**
 * Trueman Framework: theme variables storage
 *
 * @package	trueman
 * @since	trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('trueman_storage_get')) {
	function trueman_storage_get($var_name, $default='') {
		global $TRUEMAN_STORAGE;
		return isset($TRUEMAN_STORAGE[$var_name]) ? $TRUEMAN_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('trueman_storage_set')) {
	function trueman_storage_set($var_name, $value) {
		global $TRUEMAN_STORAGE;
		$TRUEMAN_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('trueman_storage_empty')) {
	function trueman_storage_empty($var_name, $key='', $key2='') {
		global $TRUEMAN_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($TRUEMAN_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($TRUEMAN_STORAGE[$var_name][$key]);
		else
			return empty($TRUEMAN_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('trueman_storage_isset')) {
	function trueman_storage_isset($var_name, $key='', $key2='') {
		global $TRUEMAN_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($TRUEMAN_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($TRUEMAN_STORAGE[$var_name][$key]);
		else
			return isset($TRUEMAN_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('trueman_storage_inc')) {
	function trueman_storage_inc($var_name, $value=1) {
		global $TRUEMAN_STORAGE;
		if (empty($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = 0;
		$TRUEMAN_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('trueman_storage_concat')) {
	function trueman_storage_concat($var_name, $value) {
		global $TRUEMAN_STORAGE;
		if (empty($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = '';
		$TRUEMAN_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('trueman_storage_get_array')) {
	function trueman_storage_get_array($var_name, $key, $key2='', $default='') {
		global $TRUEMAN_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($TRUEMAN_STORAGE[$var_name][$key]) ? $TRUEMAN_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($TRUEMAN_STORAGE[$var_name][$key][$key2]) ? $TRUEMAN_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('trueman_storage_set_array')) {
	function trueman_storage_set_array($var_name, $key, $value) {
		global $TRUEMAN_STORAGE;
		if (!isset($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = array();
		if ($key==='')
			$TRUEMAN_STORAGE[$var_name][] = $value;
		else
			$TRUEMAN_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('trueman_storage_set_array2')) {
	function trueman_storage_set_array2($var_name, $key, $key2, $value) {
		global $TRUEMAN_STORAGE;
		if (!isset($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = array();
		if (!isset($TRUEMAN_STORAGE[$var_name][$key])) $TRUEMAN_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$TRUEMAN_STORAGE[$var_name][$key][] = $value;
		else
			$TRUEMAN_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('trueman_storage_set_array_after')) {
	function trueman_storage_set_array_after($var_name, $after, $key, $value='') {
		global $TRUEMAN_STORAGE;
		if (!isset($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = array();
		if (is_array($key))
			trueman_array_insert_after($TRUEMAN_STORAGE[$var_name], $after, $key);
		else
			trueman_array_insert_after($TRUEMAN_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('trueman_storage_set_array_before')) {
	function trueman_storage_set_array_before($var_name, $before, $key, $value='') {
		global $TRUEMAN_STORAGE;
		if (!isset($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = array();
		if (is_array($key))
			trueman_array_insert_before($TRUEMAN_STORAGE[$var_name], $before, $key);
		else
			trueman_array_insert_before($TRUEMAN_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('trueman_storage_push_array')) {
	function trueman_storage_push_array($var_name, $key, $value) {
		global $TRUEMAN_STORAGE;
		if (!isset($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($TRUEMAN_STORAGE[$var_name], $value);
		else {
			if (!isset($TRUEMAN_STORAGE[$var_name][$key])) $TRUEMAN_STORAGE[$var_name][$key] = array();
			array_push($TRUEMAN_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('trueman_storage_pop_array')) {
	function trueman_storage_pop_array($var_name, $key='', $defa='') {
		global $TRUEMAN_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($TRUEMAN_STORAGE[$var_name]) && is_array($TRUEMAN_STORAGE[$var_name]) && count($TRUEMAN_STORAGE[$var_name]) > 0) 
				$rez = array_pop($TRUEMAN_STORAGE[$var_name]);
		} else {
			if (isset($TRUEMAN_STORAGE[$var_name][$key]) && is_array($TRUEMAN_STORAGE[$var_name][$key]) && count($TRUEMAN_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($TRUEMAN_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('trueman_storage_inc_array')) {
	function trueman_storage_inc_array($var_name, $key, $value=1) {
		global $TRUEMAN_STORAGE;
		if (!isset($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = array();
		if (empty($TRUEMAN_STORAGE[$var_name][$key])) $TRUEMAN_STORAGE[$var_name][$key] = 0;
		$TRUEMAN_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('trueman_storage_concat_array')) {
	function trueman_storage_concat_array($var_name, $key, $value) {
		global $TRUEMAN_STORAGE;
		if (!isset($TRUEMAN_STORAGE[$var_name])) $TRUEMAN_STORAGE[$var_name] = array();
		if (empty($TRUEMAN_STORAGE[$var_name][$key])) $TRUEMAN_STORAGE[$var_name][$key] = '';
		$TRUEMAN_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('trueman_storage_call_obj_method')) {
	function trueman_storage_call_obj_method($var_name, $method, $param=null) {
		global $TRUEMAN_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($TRUEMAN_STORAGE[$var_name]) ? $TRUEMAN_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($TRUEMAN_STORAGE[$var_name]) ? $TRUEMAN_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('trueman_storage_get_obj_property')) {
	function trueman_storage_get_obj_property($var_name, $prop, $default='') {
		global $TRUEMAN_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($TRUEMAN_STORAGE[$var_name]->$prop) ? $TRUEMAN_STORAGE[$var_name]->$prop : $default;
	}
}
?>
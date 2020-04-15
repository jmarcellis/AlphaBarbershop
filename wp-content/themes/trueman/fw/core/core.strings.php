<?php
/**
 * Trueman Framework: strings manipulations
 *
 * @package	trueman
 * @since	trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'TRUEMAN_MULTIBYTE' ) ) define( 'TRUEMAN_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('trueman_strlen')) {
	function trueman_strlen($text) {
		return TRUEMAN_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('trueman_strpos')) {
	function trueman_strpos($text, $char, $from=0) {
		return TRUEMAN_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('trueman_strrpos')) {
	function trueman_strrpos($text, $char, $from=0) {
		return TRUEMAN_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('trueman_substr')) {
	function trueman_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = trueman_strlen($text)-$from;
		}
		return TRUEMAN_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('trueman_strtolower')) {
	function trueman_strtolower($text) {
		return TRUEMAN_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('trueman_strtoupper')) {
	function trueman_strtoupper($text) {
		return TRUEMAN_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('trueman_strtoproper')) {
	function trueman_strtoproper($text) { 
		$rez = ''; $last = ' ';
		for ($i=0; $i<trueman_strlen($text); $i++) {
			$ch = trueman_substr($text, $i, 1);
			$rez .= trueman_strpos(' .,:;?!()[]{}+=', $last)!==false ? trueman_strtoupper($ch) : trueman_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('trueman_strrepeat')) {
	function trueman_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('trueman_strshort')) {
	function trueman_strshort($str, $maxlength, $add='...') {
		if ($maxlength < 0) 
			return $str;
		if ($maxlength == 0) 
			return '';
		if ($maxlength >= trueman_strlen($str)) 
			return strip_tags($str);
		$str = trueman_substr(strip_tags($str), 0, $maxlength - trueman_strlen($add));
		$ch = trueman_substr($str, $maxlength - trueman_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = trueman_strlen($str) - 1; $i > 0; $i--)
				if (trueman_substr($str, $i, 1) == ' ') break;
			$str = trim(trueman_substr($str, 0, $i));
		}
		if (!empty($str) && trueman_strpos(',.:;-', trueman_substr($str, -1))!==false) $str = trueman_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('trueman_strclear')) {
	function trueman_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (trueman_substr($text, 0, trueman_strlen($open))==$open) {
					$pos = trueman_strpos($text, '>');
					if ($pos!==false) $text = trueman_substr($text, $pos+1);
				}
				if (trueman_substr($text, -trueman_strlen($close))==$close) $text = trueman_substr($text, 0, trueman_strlen($text) - trueman_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('trueman_get_slug')) {
	function trueman_get_slug($title) {
		return trueman_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('trueman_strmacros')) {
	function trueman_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('trueman_unserialize')) {
	function trueman_unserialize($str) {
		if ( is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = @unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			return $data;
		} else
			return $str;
	}
}
?>
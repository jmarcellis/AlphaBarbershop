<?php
/**
 * Trueman Framework: html manipulations
 *
 * @package	trueman
 * @since	trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('trueman_html_theme_setup')) {
	add_action( 'trueman_action_before_init_theme', 'trueman_html_theme_setup' );
	function trueman_html_theme_setup() {

	}
}


/* Wrappers
-------------------------------------------------------------------------------- */

// Open wrapper tags and add it to stack
if (!function_exists('trueman_open_wrapper')) {
	function trueman_open_wrapper($tags, $echo=true) {
		if (!is_array($tags) && !empty($tags)) $tags = array($tags);
		$output = '';
		if (is_array($tags) && count($tags) > 0) {
			$cnt = 0;
			foreach ($tags as $tag) {
				trueman_storage_set_array('wrappers', '', $tag);
				$output .= "\n".str_repeat("\t", $cnt++).($tag);
			}
		}
		if ($echo) trueman_show_layout($output);
		return $output;
	}
}

// Close wrapper and delete it from stack
if (!function_exists('trueman_close_wrapper')) {
	function trueman_close_wrapper($cnt=1, $echo=true) {
		$output = '';
		$wrappers = trueman_storage_get('wrappers');
		$level = count($wrappers);
		$i = 0;
		while ($i < $cnt) {
			if (count($wrappers) == 0) break;
			$open_tag = array_pop($wrappers);
			$tag = explode(' ', $open_tag, 2);
			$close_tag = str_replace('<', '</', $tag[0]).'>';
			$output .= "\n".str_repeat("\t", $level-$i).($close_tag).' <!-- '.($close_tag).' '.($tag[1]).' -->';
			$i++;
		}
		trueman_storage_set('wrappers', $wrappers);
		if ($echo) trueman_show_layout($output);
		return $output;
	}
}

// Open all wrappers
if (!function_exists('trueman_open_all_wrappers')) {
	function trueman_open_all_wrappers($echo=true) {
		$output = '';
		$wrappers = trueman_storage_get('wrappers');
		for ($i=0; $i<count($wrappers); $i++) {
			$output .= "\n".str_repeat("\t", $i).($wrappers[$i]);
		}
		if ($echo) trueman_show_layout($output);
		return $output;
	}
}

// Close all wrappers without stack clear
if (!function_exists('trueman_close_all_wrappers')) {
	function trueman_close_all_wrappers($echo=true) {
		$output = '';
		$wrappers = trueman_storage_get('wrappers');
		for ($i=count($wrappers)-1; $i>=0; $i--) {
			$tag = explode(' ', $wrappers[$i]);
			$output .= "\n".str_repeat("\t", $i).str_replace('<', '</', $tag[0]).'>';
		}
		if ($echo) trueman_show_layout($output);
		return $output;
	}
}


/* Tags
-------------------------------------------------------------------------------- */

// Return attrib from tag
if (!function_exists('trueman_get_tag_attrib')) {
	function trueman_get_tag_attrib($text, $tag, $attr) {
		$val = '';
		if (($pos_start = trueman_strpos($text, trueman_substr($tag, 0, trueman_strlen($tag)-1)))!==false) {
			$pos_end = trueman_strpos($text, trueman_substr($tag, -1, 1), $pos_start);
			$pos_attr = trueman_strpos($text, ' '.($attr).'=', $pos_start);
			if ($pos_attr!==false && $pos_attr<$pos_end) {
				$pos_attr += trueman_strlen($attr)+3;
				$pos_quote = trueman_strpos($text, trueman_substr($text, $pos_attr-1, 1), $pos_attr);
				$val = trueman_substr($text, $pos_attr, $pos_quote-$pos_attr);
			}
		}
		return $val;
	}
}

// Set (change) attrib from tag
if (!function_exists('trueman_set_tag_attrib')) {
	function trueman_set_tag_attrib($text, $tag, $attr, $val) {
		if (($pos_start = trueman_strpos($text, trueman_substr($tag, 0, trueman_strlen($tag)-1)))!==false) {
			$pos_end = trueman_strpos($text, trueman_substr($tag, -1, 1), $pos_start);
			$pos_attr = trueman_strpos($text, $attr.'=', $pos_start);
			if ($pos_attr!==false && $pos_attr<$pos_end) {
				$pos_attr += trueman_strlen($attr)+2;
				$pos_quote = trueman_strpos($text, trueman_substr($text, $pos_attr-1, 1), $pos_attr);
				$text = trueman_substr($text, 0, $pos_attr) . trim($val) . trueman_substr($text, $pos_quote);
			} else {
				$text = trueman_substr($text, 0, $pos_end) . ' ' . esc_attr($attr) . '="' . esc_attr($val) . '"' . trueman_substr($text, $pos_end);
			}
		}
		return $text;
	}
}




/* CSS values
-------------------------------------------------------------------------------- */

// Return string with margins as classes
if (!function_exists('trueman_get_css_position_as_classes')) {
	function trueman_get_css_position_as_classes($top='',$right='',$bottom='',$left='') {
		if (!is_array($top)) {
			$top = compact('top','right','bottom','left');
		}
		$output = '';
		if (is_array($top) && count($top) > 0) {
			foreach ($top as $k=>$v) {
				if (!empty($v) && !trueman_param_is_inherit($v)) $output .= ($output ? ' ' : '') . 'margin_'.esc_attr($k) . '_' . esc_attr($v);
			}
		}
		return $output;
	}
}

// Return string with position rules for the style attr
if (!function_exists('trueman_get_css_position_from_values')) {
	function trueman_get_css_position_from_values($top='',$right='',$bottom='',$left='',$width='',$height='') {
		if (!is_array($top)) {
			$top = compact('top','right','bottom','left','width','height');
		}
		$output = '';
		if (is_array($top) && count($top) > 0) {
			foreach ($top as $k=>$v) {
				$imp = trueman_substr($v, 0, 1);
				if ($imp == '!') $v = trueman_substr($v, 1);
				if ($v != '') $output .= ($k=='width' 
											? 'width' 
											: ($k=='height' 
												? 'height' 
												: 'margin-'.esc_attr($k)
												)
											) . ':' . esc_attr(trueman_prepare_css_value($v)) . ($imp=='!' ? ' !important' : '') . ';';
			}
		}
		return $output;
	}
}

// Return string with dimensions rules for the style attr
if (!function_exists('trueman_get_css_dimensions_from_values')) {
	function trueman_get_css_dimensions_from_values($width='',$height='') {
		if (!is_array($width)) {
			$width = compact('width','height');
		}
		$output = '';
		if (is_array($width) && count($width) > 0) {
			foreach ($width as $k=>$v) {
				$imp = trueman_substr($v, 0, 1);
				if ($imp == '!') $v = trueman_substr($v, 1);
				if ($v != '') $output .= esc_attr($k) . ':' . esc_attr(trueman_prepare_css_value($v)) . ($imp=='!' ? ' !important' : '') . ';';
			}
		}
		return $output;
	}
}

// Return string with paddings for the style attr
if (!function_exists('trueman_get_css_paddings_from_values')) {
	function trueman_get_css_paddings_from_values($padding_top='',$padding_right='',$padding_bottom='',$padding_left='') {
		if (!is_array($padding_top)) {
			$padding_top = compact('padding_top','padding_right','padding_bottom','padding_left');
		}
		$output = '';
		if (is_array($padding_top) && count($padding_top) > 0) {
			foreach ($padding_top as $k=>$v) {
				if ($v=='') continue;
				$imp = trueman_substr($v, 0, 1);
				if ($imp == '!') $v = trueman_substr($v, 1);
				$output .= str_replace('_', '-', $k) . ':' . trim(trueman_prepare_css_value($v)) . ($imp=='!' ? ' !important' : '') . ';';
			}
		}
		return $output;
	}
}

// Return value for the style attr
if (!function_exists('trueman_prepare_css_value')) {
	function trueman_prepare_css_value($val) {
		if ($val != '' && !trueman_param_is_inherit($val)) {
			$ed = trueman_substr($val, -1);
			if ('0'<=$ed && $ed<='9') $val .= 'px';
		}
		return $val;
	}
}

// Multiply css value
if (!function_exists('trueman_multiply_css_value')) {
	function trueman_multiply_css_value($val, $mult) {
		if ($val != '' && !trueman_param_is_inherit($val)) {
			if (preg_match('/([\d\.]+)([a-zA-Z%]*)/', $val, $matches) && !empty($matches[1])) {
				$val = ($matches[1]*$mult) . (!empty($matches[2]) ? $matches[2] : 'px');
			}
		}
		return $val;
	}
}

// Summ css value
if (!function_exists('trueman_summ_css_value')) {
	function trueman_summ_css_value($val1, $val2) {
		if ( !trueman_param_is_inherit($val1) && !trueman_param_is_inherit($val2) && ($val1 != '' || $val2 != '') ) {
			if (empty($val1)) $val1 = "0";
			if (empty($val2)) $val2 = "0";
			if (preg_match('/([\d\.]+)([a-zA-Z%]*)/', $val1, $matches1) && !empty($matches1[1]) && preg_match('/([\d\.]+)([a-zA-Z%]*)/', $val2, $matches2) && !empty($matches2[1])) {
				$val1 = ($matches1[1]+$matches2[1]) . (!empty($matches1[2]) ? $matches1[2] : (!empty($matches2[2]) ? $matches2[2] : 'px'));
			}
		}
		return $val1;
	}
}

// Return array with classes from css-file
if (!function_exists('trueman_parse_icons_classes')) {
	function trueman_parse_icons_classes($css) {
		$rez = array();
		if (!file_exists($css)) return $rez;
		$file = trueman_fga($css);
		if (!is_array($file) || count($file) == 0) return $rez;
		foreach ($file as $row) {
			if (trueman_substr($row, 0, 1)!='.') continue;
			$name = '';
			for ($i=1; $i<trueman_strlen($row); $i++) {
				$ch = trueman_substr($row, $i, 1);
				if (in_array($ch, array(':', '{', '.', ' '))) break;
				$name .= $ch;
			}
			if ($name!='') $rez[] = $name;
		}
		return $rez;
	}
}
	
// Return property value for specified selector from css-file
if (!function_exists('trueman_get_css_selector_property')) {
	function trueman_get_css_selector_property($css, $selector, $prop) {
		$rez = '';
		if (!file_exists($css)) return $rez;
		$file = trueman_fga($css);
		if (is_array($file) && count($file) > 0) {
			foreach ($file as $row) {
				if (($pos = trueman_strpos($row, $selector))===false) continue;
				if (($pos2 = trueman_strpos($row, $prop.':', $pos))!==false && ($pos3 = trueman_strpos($row, ';', $pos2))!==false && $pos2 < $pos3) {
					$rez = trim(chop(trueman_substr($row, $pos2+trueman_strlen($prop)+1, $pos3-$pos2-trueman_strlen($prop)-1)));
					break;
				}
			}
		}
		return $rez;
	}
}

// Return minified inline styles to insert it into <head>
if (!function_exists('trueman_get_inline_css')) {
	function trueman_get_inline_css($minify=true) {
		// Add theme specific custom css
		$css = apply_filters('trueman_filter_add_styles_inline', '');
		// Minify css string
		if ($minify) $css = trueman_minify_css($css);
		return $css;
	}
}

// Minify CSS string
if (!function_exists('trueman_minify_css')) {
	function trueman_minify_css($css) {
		$css = preg_replace("/\r*\n*/", "", $css);
		$css = preg_replace("/\s{2,}/", " ", $css);
		$css = preg_replace("/\s*>\s*/", ">", $css);
		$css = preg_replace("/\s*:\s*/", ":", $css);
		$css = preg_replace("/\s*{\s*/", "{", $css);
		$css = preg_replace("/\s*;*\s*}\s*/", "}", $css);
        $css = str_replace(', ', ',', $css);
        $css = preg_replace("/(\/\*[\w\'\s\r\n\*\+\,\"\-\.]*\*\/)/", "", $css);
        return $css;
	}
}

// Minify JS string
if (!function_exists('trueman_minify_js')) {
	function trueman_minify_js($js) {
		// Remove multi-row comments
		// Used instead $js = preg_replace('/(\/\*)[^(\*\/)]*(\*\/)/', '', $js);
		$pos = 0;
		while (($pos = trueman_strpos($js, '/*', $pos))!==false) {
			if (($pos2 = trueman_strpos($js, '*/', $pos))!==false)
				$js = trueman_substr($js, 0, $pos) . trueman_substr($js, $pos2+2);
			else
				break;
		}
		// Remove single-line comments
		// Used instead $js = preg_replace('/\s*\/\/[^\n]*\n/', '', $js);
		$pos = -1;
		while (($pos = trueman_strpos($js, '//', $pos+1))!==false) {
			if ($js[$pos-1]!='\\') {
				$pos2 = trueman_strpos($js, "\n", $pos);
				if ($pos2==false) $pos2 = trueman_strlen($js);
				$js = trueman_substr($js, 0, $pos) . trueman_substr($js, $pos2);
			}
		}
		// Remove spaces before/after {}()
		$js = preg_replace('/\s+/', ' ', $js);
		$js = preg_replace('/([;}{\)\(])\s+/', '$1 ', $js);
		$js = preg_replace('/\s+([;}{\)\(])/', ' $1', $js);
		$js = preg_replace('/(else)\s+/', '$1 ', $js);
		return $js;
	}
}

// Add parameters to URL
if (!function_exists('trueman_add_to_url')) {
	function trueman_add_to_url($url, $prm) {
		if (is_array($prm) && count($prm) > 0) {
			$separator = trueman_strpos($url, '?')===false ? '?' : '&';
			foreach ($prm as $k=>$v) {
				$url .= $separator . urlencode($k) . '=' . urlencode($v);
				$separator = '&';
			}
		}
		return $url;
	}
}



/* Colors manipulations
-------------------------------------------------------------------------------- */

if (!function_exists('trueman_hex2rgb')) {
	function trueman_hex2rgb($hex) {
		$dec = hexdec(trueman_substr($hex, 0, 1)== '#' ? trueman_substr($hex, 1) : $hex);
		return array('r'=> $dec >> 16, 'g'=> ($dec & 0x00FF00) >> 8, 'b'=> $dec & 0x0000FF);
	}
}

if (!function_exists('trueman_hex2rgba')) {
	function trueman_hex2rgba($hex, $alpha) {
		$rgb = trueman_hex2rgb($hex);
		return 'rgba('.intval($rgb['r']).','.intval($rgb['g']).','.intval($rgb['b']).','.floatval($alpha).')';
	}
}

if (!function_exists('trueman_hex2hsb')) {
	function trueman_hex2hsb ($hex) {
		return trueman_rgb2hsb(trueman_hex2rgb($hex));
	}
}

if (!function_exists('trueman_rgb2hsb')) {
	function trueman_rgb2hsb ($rgb) {
		$hsb = array();
		$hsb['b'] = max(max($rgb['r'], $rgb['g']), $rgb['b']);
		$hsb['s'] = ($hsb['b'] <= 0) ? 0 : round(100*($hsb['b'] - min(min($rgb['r'], $rgb['g']), $rgb['b'])) / $hsb['b']);
		$hsb['b'] = round(($hsb['b'] /255)*100);
		if (($rgb['r']==$rgb['g']) && ($rgb['g']==$rgb['b'])) $hsb['h'] = 0;
		else if($rgb['r']>=$rgb['g'] && $rgb['g']>=$rgb['b']) $hsb['h'] = 60*($rgb['g']-$rgb['b'])/($rgb['r']-$rgb['b']);
		else if($rgb['g']>=$rgb['r'] && $rgb['r']>=$rgb['b']) $hsb['h'] = 60  + 60*($rgb['g']-$rgb['r'])/($rgb['g']-$rgb['b']);
		else if($rgb['g']>=$rgb['b'] && $rgb['b']>=$rgb['r']) $hsb['h'] = 120 + 60*($rgb['b']-$rgb['r'])/($rgb['g']-$rgb['r']);
		else if($rgb['b']>=$rgb['g'] && $rgb['g']>=$rgb['r']) $hsb['h'] = 180 + 60*($rgb['b']-$rgb['g'])/($rgb['b']-$rgb['r']);
		else if($rgb['b']>=$rgb['r'] && $rgb['r']>=$rgb['g']) $hsb['h'] = 240 + 60*($rgb['r']-$rgb['g'])/($rgb['b']-$rgb['g']);
		else if($rgb['r']>=$rgb['b'] && $rgb['b']>=$rgb['g']) $hsb['h'] = 300 + 60*($rgb['r']-$rgb['b'])/($rgb['r']-$rgb['g']);
		else $hsb['h'] = 0;
		$hsb['h'] = round($hsb['h']);
		return $hsb;
	}
}

if (!function_exists('trueman_hsb2rgb')) {
	function trueman_hsb2rgb($hsb) {
		$rgb = array();
		$h = round($hsb['h']);
		$s = round($hsb['s']*255/100);
		$v = round($hsb['b']*255/100);
		if ($s == 0) {
			$rgb['r'] = $rgb['g'] = $rgb['b'] = $v;
		} else {
			$t1 = $v;
			$t2 = (255-$s)*$v/255;
			$t3 = ($t1-$t2)*($h%60)/60;
			if ($h==360) $h = 0;
			if ($h<60) { 		$rgb['r']=$t1; $rgb['b']=$t2; $rgb['g']=$t2+$t3; }
			else if ($h<120) {	$rgb['g']=$t1; $rgb['b']=$t2; $rgb['r']=$t1-$t3; }
			else if ($h<180) {	$rgb['g']=$t1; $rgb['r']=$t2; $rgb['b']=$t2+$t3; }
			else if ($h<240) {	$rgb['b']=$t1; $rgb['r']=$t2; $rgb['g']=$t1-$t3; }
			else if ($h<300) {	$rgb['b']=$t1; $rgb['g']=$t2; $rgb['r']=$t2+$t3; }
			else if ($h<360) {	$rgb['r']=$t1; $rgb['g']=$t2; $rgb['b']=$t1-$t3; }
			else {				$rgb['r']=0;   $rgb['g']=0;   $rgb['b']=0; }
		}
		return array('r'=>round($rgb['r']), 'g'=>round($rgb['g']), 'b'=>round($rgb['b']));
	}
}

if (!function_exists('trueman_rgb2hex')) {
	function trueman_rgb2hex($rgb) {
		$hex = array(
			dechex($rgb['r']),
			dechex($rgb['g']),
			dechex($rgb['b'])
		);
		return '#'.(trueman_strlen($hex[0])==1 ? '0' : '').($hex[0]).(trueman_strlen($hex[1])==1 ? '0' : '').($hex[1]).(trueman_strlen($hex[2])==1 ? '0' : '').($hex[2]);
	}
}

if (!function_exists('trueman_hsb2hex')) {
	function trueman_hsb2hex($hsb) {
		return trueman_rgb2hex(trueman_hsb2rgb($hsb));
	}
}


/* Other utils
-------------------------------------------------------------------------------- */

// Decode html-entities in the shortcode parameters
if (!function_exists('trueman_html_decode')) {
	function trueman_html_decode($prm) {
		if (is_array($prm) && count($prm) > 0) {
			foreach ($prm as $k=>$v) {
				if (is_string($v))
					$prm[$k] = wp_specialchars_decode($v, ENT_QUOTES);
			}
		}
		return $prm;
	}
}
?>
<?php
/**
 * Trueman Framework: file system manipulations, styles and scripts usage, etc.
 *
 * @package	trueman
 * @since	trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* File system utils
------------------------------------------------------------------------------------- */

// Return list folders inside specified folder in the child theme dir (if exists) or main theme dir
if (!function_exists('trueman_get_list_folders')) {	
	function trueman_get_list_folders($folder, $only_names=true) {
		$dir = trueman_get_folder_dir($folder);
		$url = trueman_get_folder_url($folder);
		$list = array();
		if ( is_dir($dir) ) {
			$hdir = @opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					if ( substr($file, 0, 1) == '.' || !is_dir( ($dir) . '/' . ($file) ) )
						continue;
					$key = $file;
					$list[$key] = $only_names ? trueman_strtoproper($key) : ($url) . '/' . ($file);
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}

// Return list files in folder
if (!function_exists('trueman_get_list_files')) {	
	function trueman_get_list_files($folder, $ext='', $only_names=false) {
		$dir = trueman_get_folder_dir($folder);
		$url = trueman_get_folder_url($folder);
		$list = array();
		if ( is_dir($dir) ) {
			$hdir = @opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( ($dir) . '/' . ($file) );
					if ( substr($file, 0, 1) == '.' || is_dir( ($dir) . '/' . ($file) ) || (!empty($ext) && $pi['extension'] != $ext) )
						continue;
					$key = trueman_substr($file, 0, trueman_strrpos($file, '.'));
					if (trueman_substr($key, -4)=='.min') $key = trueman_substr($file, 0, trueman_strrpos($key, '.'));
					$list[$key] = $only_names ? trueman_strtoproper(str_replace('_', ' ', $key)) : ($url) . '/' . ($file);
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}

// Return list files in subfolders
if (!function_exists('trueman_collect_files')) {	
	function trueman_collect_files($dir, $ext=array()) {
		if (!is_array($ext)) $ext = array($ext);
		if (trueman_substr($dir, -1)=='/') $dir = trueman_substr($dir, 0, trueman_strlen($dir)-1);
		$list = array();
		if ( is_dir($dir) ) {
			$hdir = @opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( $dir . '/' . $file );
					if ( substr($file, 0, 1) == '.' )
						continue;
					if ( is_dir( $dir . '/' . $file ))
						$list = array_merge($list, trueman_collect_files($dir . '/' . $file, $ext));
					else if (empty($ext) || in_array($pi['extension'], $ext))
						$list[] = $dir . '/' . $file;
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}

// Return path to directory with uploaded images
if (!function_exists('trueman_get_uploads_dir_from_url')) {	
	function trueman_get_uploads_dir_from_url($url) {
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		
		$http_prefix = "http://";
		$https_prefix = "https://";
		
		if (!strncmp($url, $https_prefix, trueman_strlen($https_prefix)))			//if url begins with https:// make $upload_url begin with https:// as well
			$upload_url = str_replace($http_prefix, $https_prefix, $upload_url);
		else if (!strncmp($url, $http_prefix, trueman_strlen($http_prefix)))		//if url begins with http:// make $upload_url begin with http:// as well
			$upload_url = str_replace($https_prefix, $http_prefix, $upload_url);		
	
		// Check if $img_url is local.
		if ( false === trueman_strpos( $url, $upload_url ) ) return false;
	
		// Define path of image.
		$rel_path = str_replace( $upload_url, '', $url );
		$img_path = ($upload_dir) . ($rel_path);
		
		return $img_path;
	}
}

// Get domain part from URL
if (!function_exists('trueman_get_domain_from_url')) {
    function trueman_get_domain_from_url($url) {
        if (($pos=strpos($url, '://'))!==false) $url = substr($url, $pos+3);
        if (($pos=strpos($url, '/'))!==false) $url = substr($url, 0, $pos);
        return $url;
    }
}

// Return file extension from full name/path
if (!function_exists('trueman_get_file_ext')) {
    function trueman_get_file_ext($file) {
        $parts = pathinfo($file);
        return $parts['extension'];
    }
}


// Replace uploads url to current site uploads url
if (!function_exists('trueman_replace_uploads_url')) {	
	function trueman_replace_uploads_url($str, $uploads_folder='uploads') {
		static $uploads_url = '', $uploads_len = 0;
		if (is_array($str) && count($str) > 0) {
			foreach ($str as $k=>$v) {
				$str[$k] = trueman_replace_uploads_url($v, $uploads_folder);
			}
		} else if (is_string($str)) {
			if (empty($uploads_url)) {
				$uploads_info = wp_upload_dir();
				$uploads_url = $uploads_info['baseurl'];
				$uploads_len = trueman_strlen($uploads_url);
			}
			$break = '\'" ';
			$pos = 0;
			while (($pos = trueman_strpos($str, "/{$uploads_folder}/", $pos))!==false) {
				$pos0 = $pos;
				$chg = true;
				while ($pos0) {
					if (trueman_strpos($break, trueman_substr($str, $pos0, 1))!==false) {
						$chg = false;
						break;
					}
					if (trueman_substr($str, $pos0, 5)=='http:' || trueman_substr($str, $pos0, 6)=='https:')
						break;
					$pos0--;
				}
				if ($chg) {
					$str = ($pos0 > 0 ? trueman_substr($str, 0, $pos0) : '') . ($uploads_url) . trueman_substr($str, $pos+trueman_strlen($uploads_folder)+1);
					$pos = $pos0 + $uploads_len;
				} else 
					$pos++;
			}
		}
		return $str;
	}
}

// Replace site url to current site url
if (!function_exists('trueman_replace_site_url')) {	
	function trueman_replace_site_url($str, $old_url) {
		static $site_url = '', $site_len = 0;
		if (is_array($str) && count($str) > 0) {
			foreach ($str as $k=>$v) {
				$str[$k] = trueman_replace_site_url($v, $old_url);
			}
		} else if (is_string($str)) {
			if (empty($site_url)) {
				$site_url = get_site_url();
				$site_len = trueman_strlen($site_url);
				if (trueman_substr($site_url, -1)=='/') {
					$site_len--;
					$site_url = trueman_substr($site_url, 0, $site_len);
				}
			}
			if (trueman_substr($old_url, -1)=='/') $old_url = trueman_substr($old_url, 0, trueman_strlen($old_url)-1);
			$break = '\'" ';
			$pos = 0;
			while (($pos = trueman_strpos($str, $old_url, $pos))!==false) {
				$str = trueman_unserialize($str);
				if (is_array($str) && count($str) > 0) {
					foreach ($str as $k=>$v) {
						$str[$k] = trueman_replace_site_url($v, $old_url);
					}
					$str = serialize($str);
					break;
				} else {
					$pos0 = $pos;
					$chg = true;
					while ($pos0 >= 0) {
						if (trueman_strpos($break, trueman_substr($str, $pos0, 1))!==false) {
							$chg = false;
							break;
						}
						if (trueman_substr($str, $pos0, 5)=='http:' || trueman_substr($str, $pos0, 6)=='https:')
							break;
						$pos0--;
					}
					if ($chg && $pos0>=0) {
						$str = ($pos0 > 0 ? trueman_substr($str, 0, $pos0) : '') . ($site_url) . trueman_substr($str, $pos+trueman_strlen($old_url));
						$pos = $pos0 + $site_len;
					} else 
						$pos++;
				}
			}
		}
		return $str;
	}
}


// Autoload templates, widgets, etc.
// Scan subfolders and require file with same name in each folder
if (!function_exists('trueman_autoload_folder')) {	
	function trueman_autoload_folder($folder, $from_subfolders=true) {
		if ($folder[0]=='/') $folder = trueman_substr($file, 1);
		$theme_dir = get_template_directory();
		$child_dir = get_stylesheet_directory();
		$dirs = array(
			($child_dir).'/'.($folder),
			($theme_dir).'/'.($folder),
			($child_dir).'/'.(TRUEMAN_FW_DIR).'/'.($folder),
			($theme_dir).'/'.(TRUEMAN_FW_DIR).'/'.($folder)
		);
		$loaded = array();
		foreach ($dirs as $dir) {
			if ( is_dir($dir) ) {
				$hdir = @opendir( $dir );
				if ( $hdir ) {
					$files = array();
					$folders = array();
					while ( ($file = readdir($hdir)) !== false ) {
						if (substr($file, 0, 1) == '.' || in_array($file, $loaded))
							continue;
						if ( is_dir( ($dir) . '/' . ($file) ) ) {
							if ($from_subfolders && file_exists( ($dir) . '/' . ($file) . '/' . ($file) . '.php' ) ) {
								$folders[] = $file;
							}
						} else {
							$files[] = $file;
						}
					}
					@closedir( $hdir );
					// Load sorted files
					if ( count($files) > 0) {
						sort($files);
						foreach ($files as $file) {
							$loaded[] = $file;
							require_once ($dir) . '/' . ($file);
						}
					}
					// Load sorted subfolders
					if ( count($folders) > 0) {
						sort($folders);
						foreach ($folders as $file) {
							$loaded[] = $file;
							require_once ($dir) . '/' . ($file) . '/' . ($file) . '.php';
						}
					}
				}
			}
		}
	}
}



/* File system utils
------------------------------------------------------------------------------------- */

// Init WP Filesystem
if (!function_exists('trueman_init_filesystem')) {
    add_action( 'after_setup_theme', 'trueman_init_filesystem', 0);
    function trueman_init_filesystem() {
        if( !function_exists('WP_Filesystem') ) {
            require_once( ABSPATH .'/wp-admin/includes/file.php' );
        }
        if (is_admin()) {
            $url = admin_url();
            $creds = false;
            // First attempt to get credentials.
            if ( function_exists('request_filesystem_credentials') && false === ( $creds = request_filesystem_credentials( $url, '', false, false, array() ) ) ) {
                // If we comes here - we don't have credentials
                // so the request for them is displaying no need for further processing
                return false;
            }

            // Now we got some credentials - try to use them.
            if ( !WP_Filesystem( $creds ) ) {
                // Incorrect connection data - ask for credentials again, now with error message.
                if ( function_exists('request_filesystem_credentials') ) request_filesystem_credentials( $url, '', true, false );
                return false;
            }

            return true; // Filesystem object successfully initiated.
        } else {
            WP_Filesystem();
        }
        return true;
    }
}

// Put text into specified file
if (!function_exists('trueman_fpc')) {
    function trueman_fpc($file, $data, $flag=0) {
        global $wp_filesystem;
        if (!empty($file)) {
            if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                $file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
                // Attention! WP_Filesystem can't append the content to the file!
                // That's why we have to read the contents of the file into a string,
                // add new content to this string and re-write it to the file if parameter $flag == FILE_APPEND!
                return $wp_filesystem->put_contents($file, ($flag==FILE_APPEND ? $wp_filesystem->get_contents($file) : '') . $data, false);
            } else {
                if (trueman_param_is_on(trueman_get_theme_option('debug_mode')))
                    throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Put contents to the file "%s" failed', 'trueman'), $file));
            }
        }
        return false;
    }
}

// Get text from specified file
if (!function_exists('trueman_fgc')) {	
	function trueman_fgc($file) {
        static $allow_url_fopen = -1;
        if ($allow_url_fopen==-1) $allow_url_fopen = (int) ini_get('allow_url_fopen');
        global $wp_filesystem;
        if (!empty($file)) {
            if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                $file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
                return $allow_url_fopen && strpos($file, '//')!==false
                    ? trueman_remote_get($file)
                    : $wp_filesystem->get_contents($file);
            } else {
                if (trueman_param_is_on(trueman_get_theme_option('debug_mode')))
                    throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get contents from the file "%s" failed', 'trueman'), $file));
            }
        }
        return '';
	}
}

// Get text from specified file via HTTP
if (!function_exists('trueman_remote_get')) {
    function trueman_remote_get($file, $timeout=-1) {
        // Set timeout as half of the PHP execution time
        if ($timeout < 1) $timeout = round( 0.5 * max(30, ini_get('max_execution_time')));
        $response = wp_remote_get($file, array(
                'timeout'     => $timeout
            )
        );
        //return wp_remote_retrieve_response_code( $response ) == 200 ? wp_remote_retrieve_body( $response ) : '';
        return isset($response['response']['code']) && $response['response']['code']==200 ? $response['body'] : '';
    }
}

// Get array with rows from specified file
if (!function_exists('trueman_fga')) {	
	function trueman_fga($file) {
        global $wp_filesystem;
        if (!empty($file)) {
            if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                $file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
                return $wp_filesystem->get_contents_array($file);
            } else {
                if (trueman_param_is_on(trueman_get_theme_option('debug_mode')))
                    throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get rows from the file "%s" failed', 'trueman'), $file));
            }
        }
        return array();
	}
}

// Get text from specified file (local or remote)
if (!function_exists('trueman_get_local_or_remote_file')) {	
	function trueman_get_local_or_remote_file($file) {
		$rez = '';
		if (substr($file, 0, 5)=='http:' || substr($file, 0, 6)=='https:') {
			$tm = round( 0.9 * max(30, ini_get('max_execution_time')));
			$response = wp_remote_get($file, array(
									'timeout'     => $tm,
									'redirection' => $tm
									)
								);
			if (is_array($response) && isset($response['response']['code']) && $response['response']['code']==200)
				$rez = $response['body'];
		} else {
			if (($file = trueman_get_file_dir($file)) != '')
				$rez = trueman_fgc($file);
		}
		return $rez;
	}
}

// Remove unsafe characters from file/folder path
if (!function_exists('trueman_esc')) {	
	function trueman_esc($file) {
        return sanitize_file_name($file);
	}
}

// Create folder
if (!function_exists('trueman_mkdir')) {	
	function trueman_mkdir($folder, $addindex = true) {
		if (is_dir($folder) && $addindex == false) return true;
		$created = wp_mkdir_p(trailingslashit($folder));
		@chmod($folder, 0777);
		if ($addindex == false) return $created;
		$index_file = trailingslashit($folder) . 'index.php';
		if (file_exists($index_file)) return $created;
		trueman_fpc($index_file, "<?php\n// Silence is golden.\n");
		return $created;
	}
}


/* Check if file/folder present in the child theme and return path (url) to it. 
   Else - path (url) to file in the main theme dir
------------------------------------------------------------------------------------- */

// Detect file location with next algorithm:
// 1) check in the child theme folder
// 2) check in the framework folder in the child theme folder
// 3) check in the main theme folder
// 4) check in the framework folder in the main theme folder
if (!function_exists('trueman_get_file_dir')) {	
	function trueman_get_file_dir($file, $return_url=false) {
		if ($file[0]=='/') $file = trueman_substr($file, 1);
		$theme_dir = get_template_directory();
		$theme_url = get_template_directory_uri();
		$child_dir = get_stylesheet_directory();
		$child_url = get_stylesheet_directory_uri();
		$dir = '';
		if (file_exists(($child_dir).'/'.($file)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.($file);
		else if (file_exists(($child_dir).'/'.(TRUEMAN_FW_DIR).'/'.($file)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.(TRUEMAN_FW_DIR).'/'.($file);
		else if (file_exists(($theme_dir).'/'.($file)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.($file);
		else if (file_exists(($theme_dir).'/'.(TRUEMAN_FW_DIR).'/'.($file)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.(TRUEMAN_FW_DIR).'/'.($file);
		return $dir;
	}
}

// Detect file location with next algorithm:
// 1) check in the main theme folder
// 2) check in the framework folder in the main theme folder
// and return file slug (relative path to the file without extension)
// to use it in the get_template_part()
if (!function_exists('trueman_get_file_slug')) {	
	function trueman_get_file_slug($file) {
		if ($file[0]=='/') $file = trueman_substr($file, 1);
		$theme_dir = get_template_directory();
		$dir = '';
		if (file_exists(($theme_dir).'/'.($file)))
			$dir = $file;
		else if (file_exists(($theme_dir).'/'.TRUEMAN_FW_DIR.'/'.($file)))
			$dir = TRUEMAN_FW_DIR.'/'.($file);
		if (trueman_substr($dir, -4)=='.php') $dir = trueman_substr($dir, 0, trueman_strlen($dir)-4);
		return $dir;
	}
}

if (!function_exists('trueman_get_file_url')) {	
	function trueman_get_file_url($file) {
		return trueman_get_file_dir($file, true);
	}
}

// Detect folder location with same algorithm as file (see above)
if (!function_exists('trueman_get_folder_dir')) {	
	function trueman_get_folder_dir($folder, $return_url=false) {
		if ($folder[0]=='/') $folder = trueman_substr($folder, 1);
		$theme_dir = get_template_directory();
		$theme_url = get_template_directory_uri();
		$child_dir = get_stylesheet_directory();
		$child_url = get_stylesheet_directory_uri();
		$dir = '';
		if (is_dir(($child_dir).'/'.($folder)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.($folder);
		else if (is_dir(($child_dir).'/'.(TRUEMAN_FW_DIR).'/'.($folder)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.(TRUEMAN_FW_DIR).'/'.($folder);
		else if (file_exists(($theme_dir).'/'.($folder)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.($folder);
		else if (file_exists(($theme_dir).'/'.(TRUEMAN_FW_DIR).'/'.($folder)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.(TRUEMAN_FW_DIR).'/'.($folder);
		return $dir;
	}
}

if (!function_exists('trueman_get_folder_url')) {	
	function trueman_get_folder_url($folder) {
		return trueman_get_folder_dir($folder, true);
	}
}

// Return path to social icon (if exists)
if (!function_exists('trueman_get_socials_dir')) {	
	function trueman_get_socials_dir($soc, $return_url=false) {
		return trueman_get_file_dir('images/socials/' . trueman_esc($soc) . (trueman_strpos($soc, '.')===false ? '.png' : ''), $return_url, true);
	}
}

if (!function_exists('trueman_get_socials_url')) {	
	function trueman_get_socials_url($soc) {
		return trueman_get_socials_dir($soc, true);
	}
}

// Detect theme version of the template (if exists), else return it from fw templates directory
if (!function_exists('trueman_get_template_dir')) {	
	function trueman_get_template_dir($tpl) {
		return trueman_get_file_dir('templates/' . trueman_esc($tpl) . (trueman_strpos($tpl, '.php')===false ? '.php' : ''));
	}
}
?>
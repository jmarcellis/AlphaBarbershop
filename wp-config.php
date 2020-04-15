<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'i6383550_wp3' );

/** MySQL database username */
define( 'DB_USER', 'i6383550_wp3' );

/** MySQL database password */
define( 'DB_PASSWORD', 'H.2HO7NXwLu6zkaBKmf38' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'kMiYI80go7xwglYqFlhTZovTTuS6g2jVMXfmc1ZxHe5UaQ3Fmk1GASexHHaigGBb');
define('SECURE_AUTH_KEY',  'ye0aiwP1Cb61d9dYIhs4i09CHiwIY7M8af2sHhuyRD1Y6bhAWVFKJL09P4TEpQHb');
define('LOGGED_IN_KEY',    'WCjDU49rhfAIbnbDMWKJdqFSzFoEp0PY9DV1QVI296Be0QRj0Iw0QpEQFkzqD9hg');
define('NONCE_KEY',        'hc81TMg07hkiGjoFNGGzhqKYuS1IueJHMmyYJwOx28BhIAzjWjH1mnX5VPsVuvdS');
define('AUTH_SALT',        '345GRvW6OMbhIC7ZgLEb3nE9tZiDmyWjLiN8igSMXtrQLUeU0LcgDcpgkfEZRk4M');
define('SECURE_AUTH_SALT', 'tHt78CxsXxEFWnx62rWqNRSDMmTmdOYwuNtAz4YzJ24G0B46RzGoYoXDVfzKfJvk');
define('LOGGED_IN_SALT',   'NuCopjvMyYMjhLUX2x2ZErpZzQ7IyoNGqYgkE1SZGjBSI7KBsOoUmJP00Bq1dDS4');
define('NONCE_SALT',       '6Zh5ziq8LTxalNtLhoiBiUmekBd2omxsEB2uNN29hQGlV6tuaMKQMbwwn9xxtNjH');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');
define('WP_HOME','https://alphaoshkosh.com');
define('WP_SITEURL','https://alphaoshkosh.com');

@ini_set( 'upload_max_filesize' , '500M' );
@ini_set( 'post_max_size', '500M');
@ini_set( 'memory_limit', '500M' );
@ini_set( 'max_execution_time', '3000' );
@ini_set( 'max_input_time', '3000' );

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

define('WP_CACHE', true); // Added by WP Hummingbird
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

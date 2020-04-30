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

/*
 *
 * Pull in the environment configuration
 *
 */
require_once __DIR__ . '/../conf.php';



if ( ( $_SERVER[ 'HTTP_HOST' ] ?: $_SERVER[ 'SERVER_NAME' ] ) !== 'indis.wip.lazaro.in' )
	if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/content/cms/' ) !== false )
		return header( 'Location: https://indis.wip.lazaro.in' . $_SERVER[ 'REQUEST_URI' ], true, 302 );

/**
 * (Permalink) URLs in WordPress
 *
 * Allow the host/domain name to be contextual to the environment
 */
if ( $_SERVER[ 'HTTP_HOST' ] ?: $_SERVER[ 'SERVER_NAME' ] === 'localhost' ) {
	define( 'WP_HOME', 'http://localhost' );
	define( 'WP_SITEURL', 'http://localhost/cms' );
}
else {
	define( 'WP_HOME', 'https://' . ( $_SERVER[ 'HTTP_HOST' ] ?: $_SERVER[ 'SERVER_NAME' ] ) );
	define( 'WP_SITEURL', 'https://' . ( $_SERVER[ 'HTTP_HOST' ] ?: $_SERVER[ 'SERVER_NAME' ] ) . '/cms' );
}

// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'indis');

/** MySQL database username */
define('DB_USER', 'remotelazaro');

/** MySQL database password */
define('DB_PASSWORD', 't34m,l4z4r0,2');

/** MySQL hostname */
define('DB_HOST', '139.59.39.166');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'pP/9+t5&#H?=jDa@-O(+Fjy9-<l*<5&++Ly]@A-a[3bP66f|X.i+80&O2@bo8$Iq');
define('SECURE_AUTH_KEY',  'tToFltG,v|sR(OCyj3@ZRI *<M8T]Vy}47zk7]Nd([<QttHi%8:2.|=B([cVmIh]');
define('LOGGED_IN_KEY',    '|Q9sJ;}qg_|~h-wGcw`79uj/m#)B~s<,-ywJs<+(72I2[#CvIlj/3[B]+/K7CWhR');
define('NONCE_KEY',        'J cuW]:ePj+GS=S85Zwd`#itxNwF6RRr #ss|y4yH]-^#]NBHR *}(sfk.zk!O1/');
define('AUTH_SALT',        'UF.yy/Q_rbX8o42b^V|WCR>kVz-L;~B6D(Yo@9x]Ij*{.1U!0kp|CZk0xX)m=T@}');
define('SECURE_AUTH_SALT', 'QX}dWI`R}=_-}XfrpYR%je3h^,hmXO+p-`3MJ[(vW+@jJ+/|2]|YTCf%-9>X>L,E');
define('LOGGED_IN_SALT',   '>rWyXPc!UB{1#Hl8XkJkX(Ja-y ZZOvvuhjo7(RX6-k;+3GUKhvw2)do1^>uX6jL');
define('NONCE_SALT',       '!?-}hGn>;trU2vgHPFNJW|!iiiw/o1PAP[|.F#qG2EW;A%8=z<+TEip|Jm~+wT++');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/**
 * Debug Logging
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
/**
 * Disable auto-updates
 */
define( 'WP_AUTO_UPDATE_CORE', false );
/**
 * Database
 */
// SQLite
define( 'USE_MYSQL', true );
define( 'DB_DIR', '/Users/lazaro/Dropbox (Lazaro)/Indis/04 Development/01 Build/indis-website-v1/adi/data/' );
define( 'DB_FILE', 'cms.db.sqlite' );



/**
 * Media and Uploads
 *
 */
define( 'UPLOADS', '../content/cms' );	# this one is relative to `ABSPATH`


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

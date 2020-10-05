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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

/**
 * Project configuration
 *
 * Pull the configuration file from the project root
 */
require_once __DIR__ . '/../conf.php';



/**
 * WordPress Locations (Frontend and Backend)
 *
 * Set it such that it is contextual to the domain that the site is hosted behind
 */
if ( HTTPS_SUPPORT )
	$httpProtocol = 'https';
else
	$httpProtocol = 'http';

$hostName = $_SERVER[ 'HTTP_HOST' ] ?: $_SERVER[ 'SERVER_NAME' ];
define( 'WP_HOME', $httpProtocol . '://' . $hostName );
if ( ! defined( 'WP_SITEURL' ) )
	define( 'WP_SITEURL', $httpProtocol . '://' . $hostName . '/cms' );



/**
 * Routing
 *
 */
// Fetch media files from the WIP server
if ( CMS_FETCH_MEDIA_REMOTELY )
	if ( $hostName !== CMS_REMOTE_ADDRESS )
		if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/content/cms/' ) !== false )
			return header( 'Location: ' . $httpProtocol . '://' . CMS_REMOTE_ADDRESS . $_SERVER[ 'REQUEST_URI' ], true, 302 );



/**
 * Caching
 *
 */
define( 'WP_CACHE', true );



/**
 * Content, Media and Uploads
 *
 */
// Prevent posts from auto-saving
define( 'AUTOSAVE_INTERVAL', 60 * 60 * 24 );
define( 'WP_POST_REVISIONS', false );
if ( ! defined( 'UPLOADS' ) )
	define( 'UPLOADS', '../content/cms' );	# this one is relative to `ABSPATH`



/**
 * File System
 *
 */
define( 'FS_METHOD', 'direct' );



/**
 * Database
 *
 */
// SQLite
define( 'USE_MYSQL', ! CMS_USE_SQLITE );
define( 'DB_DIR', $_SERVER[ 'DOCUMENT_ROOT' ] . '/data/' );
define( 'DB_FILE', 'cms.db.sqlite' );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', CMS_DB_NAME );

/** MySQL database username */
define( 'DB_USER', CMS_DB_USER );

/** MySQL database password */
define( 'DB_PASSWORD', CMS_DB_PASSWORD );

/** MySQL hostname */
define( 'DB_HOST', CMS_DB_HOST );

/** Use an SSL connection when connecting to the database */
// define( 'MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY', 'ghpoKCRNYC%TDxM:ZW;Fu%q028xW(`sN$=h}G^>OGPP+TNB@*6.ld:1XqUdh82C?' );
define( 'SECURE_AUTH_KEY', 'iNa[P5tC*`:/F~9XN/CS>@f[pC]?3.LbE.[vX]%=}&C0% p4*Yg5M%B)/n)9Q.A,' );
define( 'LOGGED_IN_KEY', 'Roq)<89qr2u7;k:l?d&]MXl0/&0H3EqYbNjlZ=6TlCq%v$/s}uP?~3Ii{(qCOto]' );
define( 'NONCE_KEY', 'x$D+^}[.f&YP{#dt^3Wm1~r&,M<PXE<ze&7(,$d?v5Z[42C+zaq/{4{O*-bR%vl4' );
define( 'AUTH_SALT', 'bs3UR;<eRT@,4> jmph4UUGFe(i(L7z,D_]i?<!ip[@r-62R|>HCx 4E5}}sb2g)' );
define( 'SECURE_AUTH_SALT', 'QD;1:);Bd];^SXDT]P]/-#9yh%%%L+Ax2(9!2b[NeB.>MO4CTF9E3!*$T{F`q{Gx' );
define( 'LOGGED_IN_SALT', '?K-*8~*CT6OR2[iv?uR6ddT^f%%m/[7 ZVuN-VtxLB?73n0V<y#Aky[f?ok&up4&' );
define( 'NONCE_SALT', 'Qu0UkPL1$-6p$d#KsxtS-Rzo4,N!b$DNKE@U[*fKLH7^.Eg-~??:!K2Jc}AKd1=Z' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', CMS_DEBUG_MODE );
define( 'WP_DEBUG_LOG', CMS_DEBUG_LOG_TO_FILE );
define( 'WP_DEBUG_DISPLAY', CMS_DEBUG_LOG_TO_FRONTEND );
ini_set( 'display_errors', CMS_DEBUG_LOG_TO_FRONTEND ? '1' : '0' );



/**
 * Cron
 *
 */
// define( 'DISABLE_WP_CRON', true );



/**
 * WordPress Updates
 *
 */
define( 'WP_AUTO_UPDATE_CORE', CMS_AUTO_UPDATE );



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

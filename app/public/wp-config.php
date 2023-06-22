<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9LLCP9jR2UEJTKVsXi6HI4W9RllPZZRszCGlJoxbGIxwFLRAfGW1aEequMu+h9Nt4F+gHdW2F73rV3EPW1Anzw==');
define('SECURE_AUTH_KEY',  'aCG4w/pXiZYo/JNw8XLquusImTRSqb4K+/LGTGZv6VU2L8mPketLra28YVs6hO2Tx3y+N2aUemvYOcRRH64lCA==');
define('LOGGED_IN_KEY',    'aOgGrTrUICg5F33k0q2Ysj6t4h9+1rbEPt76PUPuE2zEoxVuL2MKO0Vfx00W3PuRlQAbBC1EtzTKUpYHDEsBgA==');
define('NONCE_KEY',        'zftDSczr37G02MY/jF4AxQBfzoKcxPa9hLJ7ge29XsVSCoC9L5AZxQtJtx1bkExKIpwG1tPzTfnefw2A+IWcUA==');
define('AUTH_SALT',        '+IMrDcPuCsKsx0OBXXmAIx71+lBPWVV+n0CsNKpw04Q9cUDizTVIfENhOHO4uDvDbVDqTeWSoR2mByUdA1+fHA==');
define('SECURE_AUTH_SALT', 'V4y9ROCkUy3dQ/7P322sUpXzVP3AuHmtxCeJVVuGqxX+sHxrqR+beuUVvRyxND0/M9alhpugl2kGWsdDDfYejw==');
define('LOGGED_IN_SALT',   'n0Qz98gLTIv2Nkyhk/D8kmRo9c1VrwzcBZpNh9te65YRZKdeVn4AkVK4aMOxVy32Na0Sjd9afMs5QK2TE8h7BA==');
define('NONCE_SALT',       'A9+KRrBau+FdtG32322YK8+iexb6x57yn+vlGeQpxGGgDdyJWicO0vLE3hzSNiwbDdsMG2eAgxmZGlpmRIVY7Q==');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

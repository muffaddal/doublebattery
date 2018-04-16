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
define('DB_NAME', 'doublzmw_wp943');

/** MySQL database username */
define('DB_USER', 'doublzmw_wp943');

/** MySQL database password */
define('DB_PASSWORD', ']73S59p0n[');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'wthmn7ivbyjle6g1ughzft4a2vbkxmdb0lvy3c9ekkwqkyxku4ptlrmrigtfktzq');
define('SECURE_AUTH_KEY',  'dfzwbyrzbg2l4fuxv1n0qr1yqdgyb1o6eqhxjow09fitlhveyshwrkude5cfyg9x');
define('LOGGED_IN_KEY',    'w5raqvqsgnxt7lmcsobhrs5yt365pjrmuzvlbdeidcdqcv2hudxbvhyqxcqebo8t');
define('NONCE_KEY',        'e968rrb8qn6fsswikdd572swcuyspxe3af1zlljnpl275un2pkk4azaz5e30ofqt');
define('AUTH_SALT',        't7euaoxhzxo1lbmp8mlyufgetmox4bwfeyykurkmw9c9mqswr6sctxff5cjyv21r');
define('SECURE_AUTH_SALT', '5nmyhgxiitim5hxpeg5bl8l0kgxiqshs0gcjz2dye5idaeujguwr3g1k344bgdle');
define('LOGGED_IN_SALT',   '3mseqeojtotkp9lffck3ryjiyr0aybzvizxto7gltxoczbsoq1qmfhc7muwvsdui');
define('NONCE_SALT',       'ykykmrcmm0k9mc1r7iymo6tjvj5jvfrvrgk7pxaolptwsehq15s6ooitzq29otvg');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpg1_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

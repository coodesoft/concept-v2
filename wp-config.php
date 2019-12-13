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
define( 'DB_NAME', 'globalsax_wp401' );

/** MySQL database username */
define( 'DB_USER', 'globalsax_wp401' );

/** MySQL database password */
define( 'DB_PASSWORD', 'P!@S96K-3S0p' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'f1pzvniqyjlduqdwsjhdvcmppmk34e4dq2iaeom4opgutdl8kdnkajmpavefnusr' );
define( 'SECURE_AUTH_KEY',  'iizp5lcmt1q5r4ffsydefvfazemwrx3vhlykca72bbbl926nse5acxmfdww6mbpa' );
define( 'LOGGED_IN_KEY',    'on4gmtmqlgybevqwnaxsdamnoan5zekulfohm6uzjewgk2q6szu1qtlaxcm8yrpx' );
define( 'NONCE_KEY',        'scjhj5vfpyniz5chy6f2hrhfan2bisskfu93lo5gaiqjouslcj8jwz0wxqywcej3' );
define( 'AUTH_SALT',        'o9o671tl01fwgzuefig6a7ggndhv6xwd2uvpxvwfgwqnza6s67x6lvoa1utsnn0z' );
define( 'SECURE_AUTH_SALT', '8uaqrvnzvsqz7wrkmglt6jbb84sczxtcqspxnta3imvb0djkioimew1nkvbndig8' );
define( 'LOGGED_IN_SALT',   's5comagmtjsiwaygmsp6z0wlld42acar7johbxliagauyv2ggr57eggdthabm1m4' );
define( 'NONCE_SALT',       'rbyhsnh53hzeevqqq5ntpu2kdmdv6mwqorxghzlntnlgglpplzgxpwmmpuaav9ig' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpgt_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

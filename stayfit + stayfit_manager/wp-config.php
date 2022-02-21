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
define( 'DB_NAME', 'stayfit_wp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'uT+`0(Y#BAwuz=^{6r3>RVJ#b1*3zX#3d0Zn4hY-{SvG$Km^6vQd@_D$2b6g([J~' );
define( 'SECURE_AUTH_KEY',  '.._DCTmcze]1fIpp*.DHf{[VvJ0@E%fO2?jY5;.4`F?(R^(]tfB >YXXb{| -;(B' );
define( 'LOGGED_IN_KEY',    'iW)?7I0/o>(KlfE<DK-+${Lt,--F)!/P{z)ifU?OX[sgE)zfI$Yt+v}&WDOo<n;i' );
define( 'NONCE_KEY',        'O89uGJ4bSP<j?G5&4/e52XFh0Zazh:!0LZN@*[>`M98K>L<?pIeBzU^#Io*a9miw' );
define( 'AUTH_SALT',        'f%TPGY08wY f:~Oq_P?20tp_yMMjNOXMp/+K/+xk6N1nOv|~#eSHK190dn`CU)mJ' );
define( 'SECURE_AUTH_SALT', 'DY]tJy:Uz;k+5w29+:abOj?#~dRp `ih5W)(/ce0..cUH)@dNnbQKt%3QuPg95kt' );
define( 'LOGGED_IN_SALT',   '39enB0~.Nl*9fCaJD?!wAh^ UxKZMvJ%qZ%6`u5QtqG*:M.QR3Gb034>%/^_EBCC' );
define( 'NONCE_SALT',       '598o.83rUv:-@R*v~}o_NHpJ}y{yP4Htw3&9AI1UjL@d1mjo>}@2M-*m$wjL<1K3' );

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

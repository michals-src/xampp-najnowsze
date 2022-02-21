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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'stayfit_db' );

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
define( 'AUTH_KEY',         ')t,8)HI@Xz6]645c3cS0IYbx/vG$!_3,=ny#;286E03;=aHT$Yi+z-Z4@12R5{/F' );
define( 'SECURE_AUTH_KEY',  '[`d+N%;Xcx>ZDX(U9**(%!Y+FL762;Y>TAzOoZyVtx/uu|uv>L@pK^GTILp*Og` ' );
define( 'LOGGED_IN_KEY',    '.I8-fsKP*-[]2B}IphnY-&cUBD[FMpt}blwn,&)6VA[)+8OAda(!<hGRp }WkzId' );
define( 'NONCE_KEY',        ')+b%Ykg}8 6j)nsSD:,LK,_YSbq<S7e^t4aqJES9#lNGy9rbpQyM6au*hk{HN$;[' );
define( 'AUTH_SALT',        ',nfx|,+qd}5`8rfw_:]Ch#*qxPY`Zic|heLwVJD[kh  .AIU+RfLhyX$YEFn*Vaa' );
define( 'SECURE_AUTH_SALT', '>k5@(JTH~r8f,[8 aI56N0vZ3oes6{`PRz*^n*3l]haEpLnUN,&83_uI<TL@N#hx' );
define( 'LOGGED_IN_SALT',   'UZu?<,XuS|H.sP%Zj/H,%KP[VEgC:IJK-U4SC]pU: -T[2ehs$$3<!CO~Nxx?!@o' );
define( 'NONCE_SALT',       'IXA+[9cz0I@.^AI8HMKz+k:_ebDs[$!6V+GR*8jG}f^/,/=i_zD#b~H 122fKh61' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

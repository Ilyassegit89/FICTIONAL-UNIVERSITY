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
define( 'DB_NAME', 'fictional_university_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',          ':0viVF<@LX@(Yz%3:tVIQ5J9gjDO$4ldX@FKTLj]<+Yx!N[gs!Ev(2AX=Ff:KCCq' );
define( 'SECURE_AUTH_KEY',   '8x*k!hNk?S|?q7t]F3S)T`0]>{f_lg1G(| d7oCz&:%M,zb5rMKV6a^01L{zo@Xw' );
define( 'LOGGED_IN_KEY',     '1.&*DP*j70LJjplAA?We.1&hKz.RuY?rGYuv- )61Q6p[_%0U&6%jwpH,R#PsH1b' );
define( 'NONCE_KEY',         'sIPFu&2Wx#NDVf$dk(G+$>KO)J:]5S5y L,kwNG4.u2QwNDWS.aCo8w>El(e1T,`' );
define( 'AUTH_SALT',         'zC-GN1yIy%3]AT8IRYO@%N,`d}ZPS@Vv6nnC,:V1zBm!Nus@TiKTcUd=6p>wJmM/' );
define( 'SECURE_AUTH_SALT',  '>pSL/GdLL:9&#~1j4=gmJ82biu#;>i)x/>Xe3-^;,m@1SJZVf[Z];x7)4xjj/^]3' );
define( 'LOGGED_IN_SALT',    ' VL=l=J<%5Bn&:<IaUKOm4X3L6=Yy2LxIH(6Uv62]%UG3<-D9@P1V]eNT.CsY*.<' );
define( 'NONCE_SALT',        'H|e#xgL;P*U?yRZWue>j@T}-W^L)!n<y]JUBiQ]SvT.1x$%#qy]xx*a2Nju|to89' );
define( 'WP_CACHE_KEY_SALT', '_LMc9^n;n8mDzz|x`aFzTUr7%ig7G+n 9pJ,Yd5v-wVvT7F!:dW_&:BMAzSRG!!(' );


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

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
define( 'DB_NAME', 'wordpress1' );

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
define( 'AUTH_KEY',         'PM@b-K3p[ya>#k<<6{JS@iG0EO2<Vz2W;^q{7rjfcSbm8;Dy!h0xlG^LbA2QvUK!' );
define( 'SECURE_AUTH_KEY',  '&b3OZMa+-jn;:ZHIX0#X7yG|#y_ELJt91QGz6j3WNIsDs8Gv~4%F-+~e+m0x/RCQ' );
define( 'LOGGED_IN_KEY',    'k>TxiI_SRS8<Wk3?<sZ6Hcd?mR4#xoF4;PKi,Y}|-=~Z+I6CyZb]}i`>?Wes90D[' );
define( 'NONCE_KEY',        'HgqN|?HXr7OFD`?6GKN(K$bYu09}%!BKx2m-`riu|&:]Uk$^WS?`>V0&Yo;8*QWM' );
define( 'AUTH_SALT',        'g@Ih.Q%h,#Mn}Oa 9xnoZJ@%XZt5(tC)~51`OdRFzw%aZ)ol+Ef/}@0%K^z;!Hr{' );
define( 'SECURE_AUTH_SALT', '-[4L>6iC_Yoesiq~CQ6i8PWP9;aBA}z. 8)d0#MccMfAA3o<xIw]7x7!=/a1Sh*A' );
define( 'LOGGED_IN_SALT',   'qi`9eI{F=YV(_Pvh.-dOkd(OTvNJ 0-@c#|9F<P6E :vXOPP;i:~J=h=T-|;t#*/' );
define( 'NONCE_SALT',       ':WaNda1!1rHW>LCU}<+|E_3E*&!4$9[5t}LPIjJ7JR#$6X&fiEL&m)`ZFV6H-<^c' );

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

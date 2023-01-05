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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'FUTSAL.TECS.CLUB' );

/** Database username */
define( 'DB_USER', 'FUTSAL.TECS.CLUB' );

/** Database password */
define( 'DB_PASSWORD', 'FUTSAL.TECS.CLUB' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'NFRn?=@9;#3q7po2NoN;T D T@-AybO7,+6LwL[vynNK=d6, KL[qZTU{C>./0kw' );
define( 'SECURE_AUTH_KEY',  ')S#@cexZ@.W7pi(B`M>^<;KEiNtt~N/AUEghy(L7~b.BKtk%x9g?q{9rsSOS%ZFM' );
define( 'LOGGED_IN_KEY',    'HqO|nt[Ta/dt]&UV?1CUj>,zD:a1Yuz?93x7I2}s|9)#tJvf>v3Xiaz/Y?:h,4Iw' );
define( 'NONCE_KEY',        't]}Uzv8;@lTC~joJqvARPHF/Rw;*:$hIO.HKQq1K@y=fqw0>$y.x|lh+u!G0AG#F' );
define( 'AUTH_SALT',        'Q|q-a[6L5u(eVN/3=KZ~>_T2eau`mnV<fwrP-GhLfS>x=B$[E<`PYmw<8L[o)tWO' );
define( 'SECURE_AUTH_SALT', '5ToT;<w4KjC<{Kgpw_$jm0:?KjjtQ0 3Jrm+9H]h)&EkASuh!q<F{1}[3^|ecY(Q' );
define( 'LOGGED_IN_SALT',   'P-~:ho*IE!3K0]:d,7f{7?rii9r/TaJRCz]cn,;J:`t]nkweH%}6qHmnZ}P+=VwN' );
define( 'NONCE_SALT',       'M8i;d?J_~DDrN KZV3W!}y^5Hm;+g/GK<Bo+zXNu)R^E6^2v4S&xg:y.E#ePZ^2@' );

/**#@-*/

/**
 * WordPress database table prefix.
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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

define( 'WP_POST_REVISIONS', 0 );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'reknew');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'O}N08T&*yF(4Q+ScnUx&iI-CX9Hp.Z!|I4|@cg,o%vb7BbX>wnTr:Lda4[8/~;=p');
define('SECURE_AUTH_KEY',  'z_SFHkl+hzLN+UK|N9]FAg$-rC&^)qp[d;|<+>B6vtAL>N6Pl*?/.+R=L.LO&2@n');
define('LOGGED_IN_KEY',    '7wE.,0a07F[>jF67]^f&fJ5(T1,n%7}-iK7Es0&/9,fOyNdh/XzH=4ZhU??5-%eA');
define('NONCE_KEY',        'h6i1= cUj-]cl0BNo 8!OPb U5+hF:eP,[Rhik%f3g{z*`<[/9Y_kL-J}6g]^3;t');
define('AUTH_SALT',        're6B]exS+l${0+>+A1b![7uic>;u,Bki<6i}o&%Wf<h#V-ezEuVo<6E3K]0I1sfs');
define('SECURE_AUTH_SALT', 'u]Z+a20`6hG,<3`*_AsV<UKR}KZb94&.nVrw@GD9Sya8<w7WCIleo.*^QXu*mDM;');
define('LOGGED_IN_SALT',   'qsRKz~P@&}e/^%=[qGfGhvVv;5}7EP|j3;gj#j8C|t{&p&Fv<}+yG[#((Pk&|!wZ');
define('NONCE_SALT',       '+,N)@2{-ejT`h*DN3{l7T*-^WC01^neH8D~-fiq,2H&q|;+]2(Sb `y*(:hZaO!u');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

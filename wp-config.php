<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('ENV', 'development');

if(ENV === 'development') {
    define('DB_NAME', '');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_HOST', 'localhost');
    define('WP_DEBUG', true);

    ini_set('html_errors', 1);
}

if(ENV === 'test') {
    define('DB_NAME', '');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'vagrant');
    define('DB_HOST', 'localhost');
    define('WP_DEBUG', true);
}

if(ENV === 'production') {
    define('DB_NAME', '');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'vagrant');
    define('DB_HOST', 'localhost');
    define('WP_DEBUG', false);
}

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
define('AUTH_KEY',         'hJ;9-8 $(+=nc!X?pY:yk4&d#oHD-oOjzS7Y_LTDFWDkyd)dc5k{,) 9v[:-VLZ+');
define('SECURE_AUTH_KEY',  '<v+CHU>(F|),Op715]eF9^oE#J|=~-T2hc3}`Y@j+Xmk}g1MilAl3&U2B)Ca1UZa');
define('LOGGED_IN_KEY',    'X}T$?nizY|jF)HRCWfw]P{EU#urg>#e |I`B)bSTm=Pcz>q#N,6&QHuqtCz?%}ZO');
define('NONCE_KEY',        'pY%}yJOH`)lt6}2v~#eA4813Qe:{JF,LEcB.jpDo|zBSAXzfBvfy_kc5<aAvYcFB');
define('AUTH_SALT',        'D:VK^@?eWIT<Q<m`aptG7Q_$=[$F]`qv?-%{NH?iG[5w|K1SDA|2Y_t5&y:b<@w0');
define('SECURE_AUTH_SALT', 'u%QRG3-CgE>PUl|7#*{hg3s|M<_QZ_{{X`b0a^=M$9/0ky|~;#7N`f:Ec0r$G~tp');
define('LOGGED_IN_SALT',   '!fq(J-67B.9Ev8<ZE&dckv.aSY7DJ}T&(XG:Dhi9t5S3-D]T#yKW@)-1x0]CyUj)');
define('NONCE_SALT',       'tce3WVDMD;+85eT(Md<8X)y~+08n|b?.F!M|FB tHR7J@M)0U&5Pw4+X}(m(Ux0g');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tf_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

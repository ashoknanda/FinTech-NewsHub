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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '|Fv.djg1>rU]+__%iQf+WBr{:_FRTMuyPS)Mu%DghG>p<=*!.o!u?`9*4Ji{/pB,');
define('SECURE_AUTH_KEY',  '2|!g!<Zio&)(2*M`ev:i*E27z>H=^;E=u<kM0a,~bwW]sm/=Mq)jrW9$<I- :yKA');
define('LOGGED_IN_KEY',    '#P_+<,}6y]X>k%1]QL;ufpMlFwEkOA-h&b!$pfAC+*cjSt1pc7d}[c9)R6[B5v,h');
define('NONCE_KEY',        'xe<DX,[[<eXRhrc<.?o9vj0qA[JwJ|nlX`;h&*g$BmQ6dgL2;#vcJb(Gvsh??j_3');
define('AUTH_SALT',        '{4|s6V4q1%Cy{nEWo;rbe>XQd<<048SPWLvsxUIV%XUzvm-#g4fqp7db/Ne_^o,z');
define('SECURE_AUTH_SALT', 'R5C#z$M}IzbrUJCxT~SVKH_H$^x.O#w-Y/#cQvMqX%ltub`Y}GGUJt||7FNrs1as');
define('LOGGED_IN_SALT',   '/)U[MHTJb9DN+Gqm)o2)}tD9pkC--j6Z *,Zz]I$?G@_|hj]`v`<f(Q@_utk_=+8');
define('NONCE_SALT',       'iSlNi*>vHFbr3n/|nH`Q8fR!U-j DPN:>JMBzSA-)Vax?{(*MipVezY@=M,:9eyg');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

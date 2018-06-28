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
define('DB_NAME', 'testkd');

/** MySQL database username */
define('DB_USER', 'itsugestion');

/** MySQL database password */
define('DB_PASSWORD', '<?php!@#?>');

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
define('AUTH_KEY',         'l;[JlJ0/$A@zQq^q5Pv.wtu|&k0/[RC7b~EAklmt%CM=)DUM J4oZn]EC0cEO*LA');
define('SECURE_AUTH_KEY',  ' P5<mbs#EE,sR*VGm_#g]@]PvL-7aZS,CkU;AtW.!D/#F^Yny!L#fY$i*-4.8de4');
define('LOGGED_IN_KEY',    'W)ObL.?4y@m(9Z{cCi8TG^HcpC|jN2^?c>G^*b^Zm{=ie0|kE4=]lAi?TJdW/|6c');
define('NONCE_KEY',        'Pe.J6]aW.Vv{=Dk~HiWmNmD>)9b[C=)gJZw;S-,(t3`y*vi8XAgZ8-tld`NaCBQ ');
define('AUTH_SALT',        'AUVs1iRwaZ7X&9|J`Z*M% l|z o~k38Yf2cV5FrC?s9Aawq_gQ?xd;uwXOI%C$~O');
define('SECURE_AUTH_SALT', 'NiL14_-kTS1)Q HjcpRYBj%3?]n,A1Hsu*gU]cI5FnyD]a_kA^H+,x3DKm1wA+p$');
define('LOGGED_IN_SALT',   'y:Ez9e<YTq7%<ryQH6FUGJ2+^bxdq9PY0Bg%FvPS|;58y$Kw?Yzp=RG}uZxO@!,>');
define('NONCE_SALT',       's>O;KNa{Rl.RM?X.rFJR r^t`;DV3m;{/jRP;t NGIN}Z|JofdD^XVjRu6A>pbl#');

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

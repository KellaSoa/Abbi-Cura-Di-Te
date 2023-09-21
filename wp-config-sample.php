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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'entebilaterale' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'matteo' );

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
define( 'AUTH_KEY',         'y0g-ypb-Ns_8xcd5*z]{X7Hcv#6L5Z[$unns*wDrRiTnkoz.PP4egDUM$wa<@h6w' );
define( 'SECURE_AUTH_KEY',  'YWu+-ta^XU*qcc8IHAJf|fD ,Z^j^|cU`7p+XB;4<uF)g)x3uCq}n/o|;~YxqvgV' );
define( 'LOGGED_IN_KEY',    'jyoU1Bq2RY^mq}I9dG23[f9EtKkx@+cI/HD&&CSl4u149[^BJ+qeia[*LwMJTeb+' );
define( 'NONCE_KEY',        '#nN|ZV5&1M9Yj7TB#Y-?4k2@(t*o7IVERz9{ Eh 7a`<}Q2-77&=O_/q@z1r4#ms' );
define( 'AUTH_SALT',        'BN%,#G4][jjQHz#DA+!6E$ho`9QjPgSJ!N|z7oUg~TkO;5x34HQD;pgd8f.N6/<*' );
define( 'SECURE_AUTH_SALT', 'dh2=K/beLDn._QBO;6gl0}yP.H:9~Z$<.by8A=HBH]OaDdOjgsV}iO9v,05#T(D,' );
define( 'LOGGED_IN_SALT',   'o>i{H=Yi c%-]}9iPKNbRmjK`#-vD+.H*>]2r=vfoN0 g#;7AVg-^9[~NGJ|Vd#`' );
define( 'NONCE_SALT',       'F{ .Q@~aezXHO64XH<P4KAlVIPC/^>r^-t]8WQ{}xCv)9s,Y-D~#.YLKf6q~DtcV' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

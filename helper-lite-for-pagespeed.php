<?php
/**
 * Plugin name: Helper Lite for PageSpeed
 * Description: Speed up your site with attributes decoding="async" & loading="lazy" for &lt;img&gt; and &lt;iframe&gt;. Removes problem "Does not use passive listeners to improve scrolling performance". Help to Up Your Google PageSpeed Insights Score.
 * Version: 3.1.6.2
 * Author: WP Booster
 * Author URI: https://wp-booster.com/
 * Plugin URI: https://wordpress.org/plugins/helper-lite-for-pagespeed/
 * GitHub Plugin URI: https://github.com/seojacky/helper-lite-for-pagespeed
 * Text Domain: helper-lite-for-pagespeed
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package helper-lite-for-pagespeed
 */

namespace Karenina\HelperLightForPageSpeed;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

define( 'HLFP_FILE', __FILE__ );
define( 'HLFP_DIR', __DIR__ );
define( 'HLFP_URL', plugin_dir_url( __FILE__ ) );
define( 'HLFP_VERSION', '3.1.6.2' );
define( 'HLFP_TITLE', __( 'PageSpeed Helper', 'helper-lite-for-pagespeed' ) );
define( 'HLFP_SLUG', 'helper-lite-for-pagespeed' );
define( 'HLFP_URL_JS', HLFP_URL . 'js' );

if ( file_exists( HLFP_DIR . '/vendor/autoload.php' ) ) {
	require_once HLFP_DIR . '/vendor/autoload.php';

	( new Main() )->setup_hooks();
}

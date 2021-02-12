<?php
/**
 * Plugin name: Helper Lite for PageSpeed
 * Description: Speed up your site with attributes decoding="async" & loading="lazy" for &lt;img&gt; and &lt;iframe&gt;. Removes problem "Does not use passive listeners to improve scrolling performance". Help to Up Your Google PageSpeed Insights Score. | <a href="https://wordpress.org/support/plugin/helper-lite-for-pagespeed/" target="blank_">Support</a> | <a href="https://github.com/seojacky/helper-lite-for-pagespeed" target="blank_">GitHub</a>
 * Version: 3.0.8
 * Author: seojacky, Каренина, wdup
 * Author URI: https://t.me/big_jacky
 * Plugin URI: https://wordpress.org/plugins/helper-lite-for-pagespeed/
 * GitHub Plugin URI: https://github.com/seojacky/helper-lite-for-pagespeed
 * Text Domain: helper-lite-for-pagespeed
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Karenina\HelperLightForPageSpeed;

defined('ABSPATH') or exit('No direct script access allowed');

define('HLFP_FILE', __FILE__);
define('HLFP_DIR', __DIR__);
define('HLFP_URL', plugin_dir_url(__FILE__));
define('HLFP_VERSION', '3.0.8');
define('HLFP_TITLE', __('PageSpeed Helper', 'helper-lite-for-pagespeed'));
define('HLFP_SLUG', 'helper-lite-for-pagespeed');

file_exists(HLFP_DIR . '/vendor/autoload.php') or exit('No autoload found for helper-lite-for-pagespeed plugin!');

require_once HLFP_DIR . '/vendor/autoload.php';

$helper_light_for_page_speed = new Main();

if ( is_wp_version_compatible ( '5.5' ) ) {
    //disable lazy-loading in WP 5.5 and higher
    add_filter( 'wp_lazy_loading_enabled', '__return_false' );
}

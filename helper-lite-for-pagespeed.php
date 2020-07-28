<?php
/**
 * Plugin name: Helper Lite for PageSpeed
 * Description: A faster your site with image attributes decoding="async" & loading="lazy". Remove problem "Does not use passive listeners to improve scrolling performance". Help to Up Your Google PageSpeed Insights Score. | <a href="https://t.me/wp_booster" target="blank_">WP Boost</a> | <a href="https://github.com/seojacky/helper-lite-for-pagespeed" target="blank_">GitHub</a>
 * Version: 2.5.8
 * Author: seojacky, Каренина
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

// define plugin dir name
define('HLFP_VERSION', '2.5.8');

// define plugin dir name
define('HLFP_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

// define plugin dir name
define('HLFP_TITLE', __('PageSpeed Helper', 'helper-lite-for-pagespeed'));

// define plugin dir path
define('HLFP_DIR', WP_PLUGIN_DIR . '/' . HLFP_NAME);

// define plugin's admin dir path
define('HLFP_DIR_ADMIN', HLFP_DIR . '/admin');

// define plugin's inc dir path
define('HLFP_DIR_INC', HLFP_DIR . '/inc');

define('HLFP_URL', plugin_dir_url(__FILE__));

// define plugin's inc dir path
define('HLFP_URL_JS', HLFP_URL . '/js');

if (!is_admin() && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    // require content filter
    require_once HLFP_DIR_INC . '/filter.php';
}

// require content filter
require_once HLFP_DIR_INC . '/scripts.php';

if (is_admin())
{
    // require admin fields configuration
    require_once HLFP_DIR_ADMIN . '/admin-fields.php';

    function hlfp_plugin_page_settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=hlfp-settings.php">' . __('Settings') . '</a>';
        $author_link = '<a href="https://t.me/wp_booster">' . __('Author') . '</a>';
        
        array_unshift($links, $settings_link);
        array_push($links, $author_link);

        return $links;
    }
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), __NAMESPACE__ . '\\hlfp_plugin_page_settings_link');
}

<?php
/**
 * Plugin name: Helper Lite for PageSpeed
 * Description: A faster your site with image attributes decoding="async" & loading="lazy". Remove problem "Does not use passive listeners to improve scrolling performance". Help to Up Your Google PageSpeed Insights Score. | <a href="https://t.me/big_jacky" target="blank_">Author</a> 
 * Version: 2.5.2
 * Author: @big_jacky 
 * Author URI: https://t.me/big_jacky
 * Plugin URI: https://wordpress.org/plugins/helper-lite-for-pagespeed/
 * GitHub Plugin URI: https://github.com/seojacky/helper-lite-for-pagespeed
 * Text Domain: helper-lite-for-pagespeed
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('ABSPATH') or exit('No direct script access allowed');

// define plugin dir name
if (!defined('HLFP_VERSION'))
{
    define('HLFP_VERSION', '2.5.2');
}

// define plugin dir name
if (!defined('HLFP_TITLE'))
{
    define('HLFP_TITLE', __('PageSpeed Helper'));
}

// define plugin dir name
if (!defined('HLFP_NAME'))
{
    define('HLFP_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));
}

// define plugin dir path
if (!defined('HLFP_DIR'))
{
    define('HLFP_DIR', WP_PLUGIN_DIR . '/' . HLFP_NAME);
}

// define plugin's admin dir path
if (!defined('HLFP_DIR_ADMIN'))
{
    define('HLFP_DIR_ADMIN', HLFP_DIR . '/admin');
}

// define plugin's inc dir path
if (!defined('HLFP_DIR_INC'))
{
    define('HLFP_DIR_INC', HLFP_DIR . '/inc');
}

if (!defined('HLFP_URL'))
{
    define('HLFP_URL', plugin_dir_url(__FILE__));
}

// define plugin's inc dir path
if (!defined('HLFP_URL_JS'))
{
    define('HLFP_URL_JS', HLFP_URL . '/js');
}

// require content filter
require_once HLFP_DIR_INC . '/filter.php';

// require content filter
require_once HLFP_DIR_INC . '/scripts.php';

if (is_admin())
{
    // require admin fields configuration
    require_once HLFP_DIR_ADMIN . '/admin_fields.php';
}

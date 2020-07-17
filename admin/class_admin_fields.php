<?php

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_DIR') or exit('No HLFP_DIR defined');

// define WPOSA options
if (!defined('WPOSA_VERSION'))
{
    define('WPOSA_VERSION', '1.0.0');
}

if (!defined('WPOSA_DIR_NAME'))
{
    define('WPOSA_DIR_NAME', '/WP-OOP-Settings-API');
}

if (!defined('WPOSA_NAME'))
{
    define('WPOSA_NAME', 'kek');
}

// require WPOSA
require_once HLFP_DIR . WPOSA_DIR_NAME . '/class-wp-osa.php';

/** 
 * extends WP_OSA for own menu settings
 */
class HLFP_OSA extends WP_OSA
{
    public function admin_menu()
    {
        add_options_page(
            __('Pagespeed Helper'),
            __('Pagespeed Helper'),
            'manage_options',
            'hlfp_osa_settings',
            array($this, 'plugin_page')
        );
    }
}
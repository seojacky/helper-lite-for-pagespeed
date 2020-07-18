<?php

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_DIR') or exit('No HLFP_DIR defined');

// define WPOSA options
if (!defined('WPOSA_VERSION'))
{
    define('WPOSA_VERSION', '1.0.0');
}

if (!defined('HLFP_VERSION'))
{
    define('HLFP_VERSION', WPOSA_VERSION);
}

// define plugin dir name
if (!defined('HLFP_TITLE'))
{
    define('HLFP_TITLE', 'PageSpeed Helper');
}

if (!defined('WPOSA_DIR_NAME'))
{
    define('WPOSA_DIR_NAME', '/WP-OOP-Settings-API');
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
            HLFP_TITLE,
            HLFP_TITLE,
            'manage_options',
            'hlfp_osa_settings',
            array($this, 'plugin_page')
        );
    }

    public function plugin_page()
    {
        echo '<div class="wrap">';
        echo '<h1>' . HLFP_TITLE . ' <span style="font-size:50%;">v' . HLFP_VERSION . '</span></h1>';
        $this->show_navigation();
        $this->show_forms();
        echo '</div>';
    }
}

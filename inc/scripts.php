<?php

namespace Karenina\HelperLightForPageSpeed;

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_URL') or exit('No HLFP_URL defined');

if (!defined('HLFP_URL_JS'))
{
    define('HLFP_URL_JS', HLFP_URL . '/js');
}

/**
 * Enqueue scripts based on admin options
 */
function hlfp_enqueue_scripts()
{
    // get options
    $options = get_option('hlfp_scripts', array());

    // check if option is enabled
    if (!empty($options['passive_events']) &&
        ($options['passive_events'] === 'on' || $options['passive_events'] === true || $options['passive_events'] === 1))
    {
        wp_enqueue_script('hlfp_passive_events', HLFP_URL_JS . '/hlfp_passive_events.min.js');
    }
}
add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\hlfp_enqueue_scripts' );
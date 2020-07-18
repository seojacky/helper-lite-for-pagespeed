<?php

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_URL') or exit('No HLFP_URL defined');

if (!defined('HLFP_URL_JS'))
{
    define('HLFP_URL_JS', HLFP_URL . '/js');
}

$options = get_option('hlfp_scripts', array());

if ($options['passive_events'] === 'on'|| $options['passive_events'] === true || $options['passive_events'] === 1)
{
    wp_enqueue_script('hlfp_passive_events', HLFP_URL_JS . '/hlfp_passive_events.min.js');
}

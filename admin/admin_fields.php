<?php

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_DIR') or exit('No HLFP_DIR defined');

if (!defined('HLFP_DIR_ADMIN'))
{
    define('HLFP_DIR_ADMIN', HLFP_DIR . '/admin');
}

// require field configuration class
require_once HLFP_DIR_ADMIN . '/class_admin_fields.php';

// create admin fields
if (class_exists('HLFP_OSA'))
{
    $wposa_obj = new HLFP_OSA();

    // Settings section
    $wposa_obj->add_section(
        array(
            'id' => 'hlfp_settings',
            'title' => __('Settings', 'WPOSA'),
        )
    );

    // Filter type selection field
    $wposa_obj->add_field(
        'hlfp_settings',
        array(
            'id' => 'filter_type',
            'type' => 'select',
            'name' => __('Select filter type', 'WPOSA'),
            'options' => array(
                'filter' => 'Filters',
                'buffering' => 'Buffer',
            ),
        )
    );
}

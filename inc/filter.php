<?php

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_DIR') or exit('No HLFP_DIR defined');

if (!defined('HLFP_DIR_INC'))
{
    define('HLFP_DIR_INC', HLFP_DIR . '/inc');
}

// require filter classes
require_once HLFP_DIR_INC . '/class_buffer_filter.php';
require_once HLFP_DIR_INC . '/class_light_filter.php';

// get options
$options = get_option('hlfp_settings', array());

// create filter based on option type
if (!empty($options['filter_type']) && $options['filter_type'] == 'filter')
{
    $filter = new HLFP_Light_Filter($options);
}
else
{
    $filter = new HLFP_Buffer_Filter($options);
}

// apply filters
$filter->add_filters();

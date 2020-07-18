<?php

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_DIR') or exit('No HLFP_DIR defined');

if (!defined('HLFP_DIR_INC'))
{
    define('HLFP_DIR_INC', HLFP_DIR . '/inc');
}

// require filter interface
require_once HLFP_DIR_INC . '/interface_filter.php';

/**
 * This class users Wordpress' default filters 
 * to filter images
 */
class HLFP_Light_Filter implements HLFP_Filter
{
    protected $content_filters = array(
        'widget_custom_html_content',
        'widget_text',
        'the_content',
    );

    protected $image_filters = array(
        'wp_get_attachment_image_attributes',
    );

    public function __construct()
    {
    }

    public function add_filters()
    {
        // add content filters
        foreach ($this->content_filters as $filter)
        {
            add_filter($filter, function ($content)
            {
                $content = str_replace('<img', '<img decoding="async" loading="lazy"', $content);
                return $content;
            });
        }

        // add image filters
        foreach ($this->image_filters as $filter)
        {
            add_filter($filter, function ($attributes)
            {
                $attributes['decoding'] = 'async';
                $attributes['loading'] = 'lazy';

                return $attributes;
            });
        }
    }
}

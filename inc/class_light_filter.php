<?php

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_DIR') or exit('No HLFP_DIR defined');

if (!defined('HLFP_DIR_INC'))
{
    define('HLFP_DIR_INC', HLFP_DIR . '/inc');
}

// require filter class
require_once HLFP_DIR_INC . '/class_filter.php';

/**
 * This class users Wordpress' default filters
 * to filter images
 */
class HLFP_Light_Filter extends HLFP_Filter
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
            $this->create_content_filter($filter);
        }

        // add image filters
        foreach ($this->image_filters as $filter)
        {
            $this->create_image_filter($filter);
        }
    }

    private function create_content_filter($filter)
    {
        add_filter($filter, function ($content)
        {
            $content = $this->filter_content($content);
            return $content;
        });
    }

    private function create_image_filter($filter)
    {
        add_filter($filter, function ($attributes)
        {
            $attributes['decoding'] = 'async';
            $attributes['loading'] = 'lazy';

            return $attributes;
        });
    }

    public function add_content_filter($filter)
    {
        if (!is_string($filter))
        {
            return;
        }

        array_push($this->content_filters, $filter);
        $this->create_content_filter($filter);
    }

    public function add_image_filter($filter)
    {
        if (!is_string($filter))
        {
            return;
        }

        array_push($this->image_filters, $filter);
        $this->create_image_filter($filter);
    }
}

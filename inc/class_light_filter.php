<?php

namespace Karenina\HelperLightForPageSpeed;

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
    // content filter hooks
    protected $content_filters = array(
        'widget_custom_html_content',
        'widget_text',
        'the_content',
    );

    // image filter hooks
    protected $image_filters = array(
        'wp_get_attachment_image_attributes',
    );

    /**
     * @param array $options filter options
     */
    public function __construct($options)
    {
        parent::__construct($options);
    }

    /**
     * Add content and image filter hooks
     */
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

    /**
     * Create content filter hook
     *
     * @param string $filter hook name
     */
    private function create_content_filter(string $filter)
    {
        add_filter($filter, function ($content)
        {
            $content = $this->filter_content($content);
            return $content;
        });
    }

    /**
     * Create image filter hook
     *
     * @param string $filter hook name
     */
    private function create_image_filter(string $filter)
    {
        add_filter($filter, function ($attributes)
        {
            // get loading options
            $loading_option = $this->get_option('loading_type', 'lazy');

            // if loading is not turned off, set attribute
            if ($loading_option != 'none')
            {
                $attributes['loading'] = $loading_option;
            }

            // get decoding option
            $decoding_option = $this->get_option('decoding_type', 'async');

            // if decoding is not turned off, set attribute
            if ($decoding_option != 'none')
            {
                $attributes['decoding'] = $decoding_option;
            }

            return $attributes;
        });
    }

    /**
     * Add content filter for hook
     * 
     * @param string $filter hook name
     */
    public function add_content_filter(string $filter)
    {
        // check for string
        if (!is_string($filter))
        {
            return;
        }

        // save hook
        array_push($this->content_filters, $filter);

        // create filter
        $this->create_content_filter($filter);
    }

    /**
     * Add image filter for hook
     * 
     * @param string $filter hook name
     */
    public function add_image_filter($filter)
    {
        // check for string
        if (!is_string($filter))
        {
            return;
        }

        // save hook
        array_push($this->image_filters, $filter);

        // create filter
        $this->create_image_filter($filter);
    }
}

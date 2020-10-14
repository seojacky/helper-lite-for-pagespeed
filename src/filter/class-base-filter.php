<?php

namespace Karenina\HelperLightForPageSpeed\Filter;

use Karenina\HelperLightForPageSpeed\Admin\HLFP_OSA;

defined('ABSPATH') or exit('No direct script access allowed');

/**
 * class BaseFilter
 * 
 * @package Karenina\HelperLightForPageSpeed\Filter
 */
class BaseFilter
{
    /**
     * Admin Settings wrap instance
     * 
     * @var HLFP_OSA
     */
    protected $hlfp_osa;

    /**
     * Options section name
     * 
     * @var string
     */
    protected $section = 'hlfp_settings';

    /**
     * BaseFilter constructor 
     * 
     * @param array $options filter options
     */
    public function __construct(HLFP_OSA $hlfp_osa)
    {
        $this->hlfp_osa = $hlfp_osa;
    }

    /**
     * Filter images and iframes in given content using options from admin panel
     * Adds "loading" and "decoding" attributes if not turned of
     *
     * @param string $content content to filter
     *
     * @return string $content filtered content
     */
    public function filter_content($content)
    {
        // set double quotes escaping if it's AJAX call
        $quote = wp_doing_ajax() ? '\"' : '"';

        $replacement = '<img';

        // get option for loading attribute
        $loading_option = $this->get_option('loading_type', '-');

        // if it's not off, set option
        if ($loading_option != 'none')
        {
            $replacement .= ' loading=' . $quote . $loading_option . $quote;
        }

        // get option for decoding attribute
        $decoding_option = $this->get_option('decoding_type', 'async');

        // if it's not off, set option
        if ($decoding_option != 'none')
        {
            $replacement .= ' decoding=' . $quote . $decoding_option . $quote;
        }

        // make replace
        $content = str_replace('<img', $replacement, $content);

        // get option for iframe
        $iframe_option = $this->get_option('iframe_loading_type', 'lazy');

        if ($iframe_option != 'none')
        {
            // make replace
            $iframe_replacement = '<iframe loading=' . $quote . $iframe_option . $quote;
            $content = str_replace('<iframe', $iframe_replacement, $content);
        }

        return $content;
    }

    /**
     * Get option from local HLFP_OSA instance
     *
     * @param string $option option's name
     * @param string|mixed $default default value to return if option doesn't exist
     *
     * @return string|mixed option value or default value
     */
    protected function get_option($option, $default = '')
    {
        return $this->hlfp_osa->get_option($option, $this->section, $default);
    }
}

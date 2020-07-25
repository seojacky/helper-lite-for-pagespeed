<?php

namespace Karenina\HelperLightForPageSpeed;

defined('ABSPATH') or exit('No direct script access allowed');

/**
 * Base Filter class.
 * Defines options storage and content filtering.
 * Needs to be extended.
 */
class HLFP_Filter
{
    // options to store
    protected $options;

    /**
     * @param array $options filter options
     */
    public function __construct(array $options)
    {
        // if $options is not an array, save empty array
        if (!is_array($options))
        {
            $this->options = array();
        }
        else
        {
            // save $options
            $this->options = $options;
        }
    }

    /**
     * Filter images in given content using options from admin panel
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
        $loading_option = $this->get_option('loading_type', 'lazy');

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
        return $content;
    }

    /**
     * Add filters. For child classes to implement
     */
    public function add_filters()
    {
    }

    /**
     * Get option for saved options array.
     *
     * @param string $name option's name
     * @param string $default default value to return if option doesn't exist
     *
     * @return string option value or default value
     */
    protected function get_option(string $name, string $default = '')
    {
        // check $name for string
        if (!is_string($name))
        {
            return $default;
        }

        // check if option exists
        if (empty($this->options[$name]))
        {
            return $default;
        }

        // return option
        return $this->options[$name];
    }
}

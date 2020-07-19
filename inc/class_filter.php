<?php

defined('ABSPATH') or exit('No direct script access allowed');

/**
 * Just to pre-define methods
 */
class HLFP_Filter
{
    protected $options;

    public function __construct($options)
    {
        if (!is_array($options))
        {
            $this->options = array();
        }
        else
        {
            $this->options = $options;
        }
    }

    public function filter_content($content)
    {
        $replacement = '<img decoding="async" loading="lazy"';

        if (wp_doing_ajax())
        {
            $replacement = '<img decoding=\"async\" loading=\"lazy\"';
        }

        $content = str_replace('<img', $replacement, $content);
        return $content;
    }

    public function add_filters()
    {
    }

    protected function get_option($name, $default = '')
    {
        if (!is_string($name))
        {
            return $default;
        }

        if (empty($this->options[$name]))
        {
            return $default;
        }

        return $this->options[$name];
    }
}

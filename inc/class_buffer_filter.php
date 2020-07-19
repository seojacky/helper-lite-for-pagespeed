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
 * This class uses buffering to collect output
 * and filter all images
 */
class HLFP_Buffer_Filter extends HLFP_Filter
{
    public function __construct()
    {
        // if not an admin page, start buffering
        if (!is_admin())
        {
            ob_start();
        }
    }

    public function add_filters()
    {
        add_action('shutdown', function ()
        {
            // if no buffer, just return
            if (ob_get_level() == 0)
            {
                return;
            }

            $content = '';

            // We need to iterate over each ob level, collecting that buffer's output into the final output.
            while (ob_get_level() > 0)
            {
                $content .= ob_get_clean();
            }

            $content = $this->filter_content($content);

            echo $content;
        }, 0);
    }
}

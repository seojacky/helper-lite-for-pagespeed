<?php

namespace Karenina\HelperLightForPageSpeed;

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_DIR') or exit('No HLFP_DIR defined');

if (!defined('HLFP_DIR_INC'))
{
    define('HLFP_DIR_INC', HLFP_DIR . '/inc');
}

// require filter class
require_once HLFP_DIR_INC . '/class-filter.php';

/**
 * This class uses buffering to collect output
 * and filter all images
 */
class HLFP_Buffer_Filter extends HLFP_Filter
{
    /**
     * Starts buffering if not an admin page
     *
     * @param array $options filter options
     */
    public function __construct($options)
    {
        parent::__construct($options);

        // if not an admin page, start buffering
        if (!is_admin())
        {
            ob_start(array($this, 'filter_content'));
        }
    }
}

<?php

namespace Karenina\HelperLightForPageSpeed\Filter;

use Karenina\HelperLightForPageSpeed\Admin\HLFP_OSA;

defined('ABSPATH') or exit('No direct script access allowed');

/**
 * class BufferFilter
 *
 * @package Karenina\HelperLightForPageSpeed\Filter
 */
class BufferFilter extends BaseFilter
{
    /**
     * BufferFilter constructor
     *
     * @param HLFP_OSA $hlfp_osa HLFP_OSA instance
     */
    public function __construct(HLFP_OSA $hlfp_osa)
    {
        if ( is_wp_version_compatible ( '5.5' ) ) {
			//disable lazy-loading in WP 5.5 and higher
            add_filter( 'wp_lazy_loading_enabled', '__return_false' );
        }
        parent::__construct($hlfp_osa);
        ob_start(array($this, 'filter_content'));
    }
}
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
        parent::__construct($hlfp_osa);
        ob_start(array($this, 'filter_content'));
    }
}
<?php
/**
 * Class FilterManager
 *
 * @package helper-lite-for-pagespeed
 */

namespace Karenina\HelperLightForPageSpeed\Filter;

use Karenina\HelperLightForPageSpeed\Admin\HLFP_OSA;

/**
 * Class FilterManager
 *
 * @package Karenina\HelperLightForPageSpeed\Filter
 */
class FilterManager {
	/**
	 * Current filter instance
	 *
	 * @var BaseFilter
	 */
	protected $filter;

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
	 * FilterManager constructor
	 *
	 * @param HLFP_OSA $hlfp_osa HLFP_OSA instance.
	 */
	public function __construct( HLFP_OSA $hlfp_osa ) {
		$this->hlfp_osa = $hlfp_osa;
	}

	/**
	 * Set content filter based on admin options
	 */
	public function set_filter() {
		// just double-check for not-admin & GET request.
		if ( is_admin() || ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] !== 'GET' ) ) {
			return;
		}

		$filter_type = $this->get_option( 'filter_type', 'filter' );

		// Set filter.
		if ( $filter_type === 'buffering' ) {
			$this->filter = new BufferFilter( $this->hlfp_osa );
		} else {
			$this->filter = new LightFilter( $this->hlfp_osa );
		}
	}

	/**
	 * Get option from local HLFP_OSA instance
	 *
	 * @param string       $option  Option's name.
	 * @param string|mixed $default Default value to return if option doesn't exist.
	 *
	 * @return string|mixed option value or default value
	 */
	private function get_option( $option, $default = '' ) {
		return $this->hlfp_osa->get_option( $option, $this->section, $default );
	}
}

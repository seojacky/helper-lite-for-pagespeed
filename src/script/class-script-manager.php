<?php
/**
 * Class ScriptManager
 *
 * @package helper-lite-for-pagespeed
 */

namespace Karenina\HelperLightForPageSpeed\Script;

use Karenina\HelperLightForPageSpeed\Admin\HLFP_OSA;

/**
 * Class ScriptManager
 *
 * @package Karenina\HelperLightForPageSpeed\Script
 */
class ScriptManager {
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
	protected $section = 'hlfp_scripts';

	/**
	 * ScriptManager constructor
	 *
	 * @param HLFP_OSA $hlfp_osa HLFP_OSA instance.
	 */
	public function __construct( HLFP_OSA $hlfp_osa ) {
		$this->hlfp_osa = $hlfp_osa;
	}

	/**
	 * Enable script hooks
	 */
	public function hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * WP hook,
	 * Enqueue scripts based on admin options
	 */
	public function enqueue_scripts() {
		$passive_events_option = $this->get_option( 'passive_events', 'off' );

		// check if option is enabled.
		if ( $passive_events_option === 'on' ) {
			wp_enqueue_script(
				'hlfp_passive_events',
				HLFP_URL_JS . '/hlfp_passive_events.min.js',
				[],
				HLFP_VERSION,
				true
			);
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
	protected function get_option( $option, $default = '' ) {
		return $this->hlfp_osa->get_option( $option, $this->section, $default );
	}
}

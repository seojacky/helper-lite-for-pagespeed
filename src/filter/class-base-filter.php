<?php
/**
 * Class BaseFilter
 *
 * @package helper-lite-for-pagespeed
 */

namespace Karenina\HelperLightForPageSpeed\Filter;

use Karenina\HelperLightForPageSpeed\Admin\HLFP_OSA;

/**
 * Class BaseFilter
 *
 * @package Karenina\HelperLightForPageSpeed\Filter
 */
class BaseFilter {
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
	 * @param HLFP_OSA $hlfp_osa Filter options.
	 */
	public function __construct( HLFP_OSA $hlfp_osa ) {
		$this->hlfp_osa = $hlfp_osa;
	}

	/**
	 * Filter images and iframes in given content using options from admin panel
	 * Adds "loading" and "decoding" attributes if not turned off
	 *
	 * @param string $content Content to filter.
	 *
	 * @return string $content filtered content
	 */
	public function filter_content( $content ) {
		$search  = array();
		$replace = array();
		$matches = array();

		preg_match_all( '/<img[\s\r\n]+.*?>/is', $content, $matches );

		// Set double quotes escaping if it's AJAX call.
		$quote = wp_doing_ajax() ? '\"' : '"';

		foreach ( $matches[0] as $img_html ) {
			// Check if exist class 'skip-lazy'.
			if ( strpos( $img_html, 'skip-lazy' ) === false ) {

				$replacement = '<img';
				// Get option for loading attribute.
				$loading_option = $this->get_option( 'loading_type', '-' );
				// If it's not off, set option.
				if ( $loading_option !== 'none' ) {
					$replacement .= ' loading=' . $quote . $loading_option . $quote;
				}

				// Get option for decoding attribute.
				$decoding_option = $this->get_option( 'decoding_type', 'async' );
				// If it's not off, set option.
				if ( $decoding_option !== 'none' ) {
					$replacement .= ' decoding=' . $quote . $decoding_option . $quote;
				}
				// Make replace.
				$replace_html = str_replace( '<img', $replacement, $img_html );

				array_push( $search, $img_html );
				array_push( $replace, $replace_html );
			}
		}

		$search  = array_unique( $search );
		$replace = array_unique( $replace );
		$content = str_replace( $search, $replace, $content );

		$iframe_option = $this->get_option( 'iframe_loading_type', 'lazy' );
		if ( $iframe_option !== 'none' ) {
			// Make replace.
			$iframe_replacement = '<iframe loading=' . $quote . $iframe_option . $quote;
			$content            = str_replace( '<iframe', $iframe_replacement, $content );
		}

		return $content;
	}

	/**
	 * Get option from local HLFP_OSA instance
	 *
	 * @param string       $option  Aption's name.
	 * @param string|mixed $default Default value to return if option doesn't exist.
	 *
	 * @return string|mixed option value or default value
	 */
	protected function get_option( $option, $default = '' ) {
		return $this->hlfp_osa->get_option( $option, $this->section, $default );
	}
}

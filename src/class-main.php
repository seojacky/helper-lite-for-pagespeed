<?php
/**
 * Class Main
 *
 * @package helper-lite-for-pagespeed
 */

namespace Karenina\HelperLightForPageSpeed;

use Karenina\HelperLightForPageSpeed\Admin as Admin;
use Karenina\HelperLightForPageSpeed\Filter as Filter;
use Karenina\HelperLightForPageSpeed\Script as Script;
use Karenina\HelperLightForPageSpeed\Image as Image;

/**
 * Сlass Main
 *
 * Manages plugin's components
 *
 * @package Karenina\HelperLightForPageSpeed
 */
class Main {
	/**
	 * Admin Settings wrap instance
	 *
	 * @var Admin\HLFP_OSA
	 */
	private $hlfp_osa;

	/**
	 * Admin fields Manager instance
	 *
	 * @var Admin\AdminManager
	 */
	private $admin_manager;

	/**
	 * Filter Manager instance
	 *
	 * @var Filter\FilterManager
	 */
	private $filter_manager;

	/**
	 * Script Manager instance
	 *
	 * @var Script\ScriptManager
	 */
	private $script_manager;

	/**
	 * Script Manager instance
	 *
	 * @var Script\ScriptManager
	 */
	private $image_manager;

	/**
	 * Main constructor
	 */
	public function __construct() {
		$this->hlfp_osa = new Admin\HLFP_OSA();

		$this->admin_manager  = new Admin\AdminManager( $this->hlfp_osa );
		$this->filter_manager = new Filter\FilterManager( $this->hlfp_osa );
		$this->script_manager = new Script\ScriptManager( $this->hlfp_osa );
		$this->image_manager  = new Image\ImageOptimize( $this->hlfp_osa );

		$this->managers_enable();
	}

	/**
	 * Setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks() {
		add_filter( 'wp_lazy_loading_enabled', '__return_false' );
	}

	/**
	 * Enables managers based on current request options
	 */
	public function managers_enable() {
		if ( is_admin() ) {
			// enable admins hooks.
			$this->admin_manager->hooks();
		} elseif ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'GET' ) {
			// enable filters on not-admin GET request.
			$this->filter_manager->set_filter();
		}

		// enable scripts hook.
		$this->script_manager->hooks();

		// enable images hooks.
		$this->image_manager->hooks();
	}
}

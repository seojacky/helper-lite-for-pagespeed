<?php
/**
 * Class AdminManager
 *
 * @package helper-lite-for-pagespeed
 */

namespace Karenina\HelperLightForPageSpeed\Admin;

use WP_Plugin_Install_List_Table;

/**
 * Class AdminManager.
 *
 * @package Karenina\HelperLightForPageSpeed\Admin
 */
class AdminManager {
	/**
	 * Flag Codes
	 *
	 * @var array
	 */
	protected $flags = array(
		'uk'  => '&#127468;&#127463;',
		'usa' => '&#127482;&#127480;',
		'ru'  => '&#127479;&#127482;',
		'ua'  => '&#127482;&#127462;',
		'pl'  => '&#127477;&#127473;',
	);
	/**
	 * Admin Settings wrap instance
	 *
	 * @var HLFP_OSA
	 */
	protected $hlfp_osa;

	/**
	 * AdminManager constructor
	 *
	 * @param HLFP_OSA $hlfp_osa HLFP_OSA instance.
	 */
	public function __construct( HLFP_OSA $hlfp_osa ) {
		$this->hlfp_osa = $hlfp_osa;
	}

	/**
	 * Enable Admins hooks
	 */
	public function hooks() {
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'admin_init', array( $this, 'setup_fields' ), 9, 0 );
		add_action( 'admin_menu', array( $this, 'create_admin_page' ), 8, 0 );
		add_action( 'admin_print_styles', array( $this, 'hide_wp_boost_sub_menu' ) );
		add_action( 'admin_print_styles', array( $this, 'admin_page_style' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( HLFP_FILE ), array( $this, 'setup_extra_links' ), 10, 1 );
		add_filter( 'plugin_row_meta', array( $this, 'setup_meta_links' ), 10, 2 );

		add_filter( 'install_plugins_nonmenu_tabs', array( $this, 'install_plugins_nonmenu_tabs' ) );
		add_filter( 'install_plugins_table_api_args_' . HLFP_SLUG, array( $this, 'install_plugins_table_api_args' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_filter( 'plugins_api_result', array( $this, 'plugins_api_result' ), 10, 3 );
	}

	/**
	 * Добавить нужные скрипты на нашу страницу настроек.
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'plugin_install' );
		wp_enqueue_script( 'updates' );
		add_thickbox();
	}

	/**
	 * Добавить новый скрытый таб со списком наших плагинов.
	 *
	 * @param array $tabs Дефолтные табы.
	 *
	 * @return array
	 */
	public function install_plugins_nonmenu_tabs( $tabs ) {

		$tabs[] = HLFP_SLUG;

		return $tabs;
	}

	/**
	 * Подправим запрос на наполнение нашего скрытого таба чиз API wp.org.
	 *
	 * @param array $args Массив дефолтных аргументов запроса.
	 *
	 * @return array
	 */
	public function install_plugins_table_api_args( $args ) {
		global $paged;

		return array(
			'plugin'   => HLFP_SLUG,
			'page'     => $paged,
			'per_page' => 100,
			'locale'   => get_user_locale(),
			'author'   => 'seojacky',
		);
	}

	/**
	 * Подправим ответ из API wp.org и внесем туда плагины другого автора,
	 * который тоже красавчик.
	 *
	 * @param object $res Объект ответа из API.
	 * @param string $action Название запроса (query_plugins).
	 * @param object $args Аргументы запроса.
	 *
	 * @return mixed
	 */
	public function plugins_api_result( $res, $action, $args ) {
		global $paged;

		if ( isset( $args->plugin ) && HLFP_SLUG === $args->plugin ) {
			foreach ( $res->plugins as $key => $plugin ) {
				// Удалить текущий плагин из ответа.
				if ( HLFP_SLUG === $plugin['slug'] ) {

					// Добавить свои плагины к ответу вместо удаленных.
					$our_plugins = plugins_api(
						'query_plugins',
						array(
							'page'     => $paged,
							'per_page' => 100,
							'locale'   => get_user_locale(),
							'search'   => 'Mihdan: Lite YouTube Embed',
						)
					);

					$res->plugins[ $key ] = $our_plugins->plugins[0];
				}
			}
		}

		return $res;
	}

	/**
	 * Create admin page.
	 *
	 * @return void
	 */
	public function create_admin_page() {
		global $admin_page_hooks;

		if ( ! isset( $admin_page_hooks['wp-booster'] ) ) {
			add_menu_page(
				esc_html__( 'WP Booster', 'helper-lite-for-pagespeed' ),
				esc_html_x( 'WP Booster', 'Menu item', 'helper-lite-for-pagespeed' ),
				'manage_options',
				'wp-booster',
				array( $this->hlfp_osa, 'plugin_page' ),
				'dashicons-backup',
				92.3
			);
		}
	}

	/**
	 * Hide wp boost submenu
	 *
	 * @return void
	 */
	public function hide_wp_boost_sub_menu() {
		?>
		<style>
		#toplevel_page_wp-booster li.wp-first-item {
			display: none;
		}
		</style>
		<?php
	}

	/**
	 * Add admin page styles.
	 *
	 * @return void
	 */
	public function admin_page_style() {
		?>
		<style>
		.nav-tab-wrapper span.dashicons {
			margin-right: 5px; position: relative; top: 2px;
		}
		h2 span.dashicons {
			margin-right: 5px;
		}
		.wp-list-table.toplevel_page_wp-booster .column-name img {
			position: absolute;
			top: 20px;
			left: 20px;
			width: 128px;
			height: 128px;
			margin: 0 20px 20px 0;
		}
		</style>
		<?php
	}

	/**
	 * Load plugin's text domain
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'helper-lite-for-pagespeed', false, basename( dirname( HLFP_FILE ) ) . '/languages/' );
	}

	/**
	 * WP filter hook,
	 * Creates "Settings" and "Author" links
	 * on plugins page
	 *
	 * @param array $links Initial WP links.
	 *
	 * @return array populated links
	 */
	public function setup_extra_links( $links ) {
		$extra_links = array(
			sprintf(
				'<a href="%s">%s</a>',
				add_query_arg( [ 'page' => 'hlfp-settings' ], admin_url( 'admin.php' ) ),
				__( 'Settings', 'helper-lite-for-pagespeed' )
			),
			'<a href="https://bit.ly/3yO9unF" target="_blank" style="color:#3db634;">' . __( 'Buy developer a coffee', 'helper-lite-for-pagespeed' ) . '</a>',
		);

		return array_merge( $links, $extra_links );
	}

	/**
	 * WP filter hook
	 * Adds meta links to the plugin's footer
	 *
	 * @param array  $links Initial WP links.
	 * @param string $file  Current plugin filename.
	 *
	 * @return array populated links
	 */
	public function setup_meta_links( $links, $file ) {
		// If not current plugin, return default links.
		if ( plugin_basename( HLFP_FILE ) !== $file ) {
			return $links;
		}

		$subdomen = '';
		$loc      = substr( determine_locale(), 0, 2 );
		if ( 'ru' === $loc ) {
			$subdomen = $loc . '.';
		}

		$meta_links = array(
			'<a href="https://' . $subdomen . 'wordpress.org/plugins/helper-lite-for-pagespeed/#faq-header" target="_blank">' . __( 'FAQ', 'helper-lite-for-pagespeed' ) . '</a>',
			'<br>' . __( 'Rate us:', 'helper-lite-for-pagespeed' ) . " <span class='rating-stars'><a href='//wordpress.org/support/plugin/helper-lite-for-pagespeed/reviews/?rate=1#new-post' target='_blank' data-rating='1' title='" . __( 'Poor', 'helper-lite-for-pagespeed' ) . "'><span class='dashicons dashicons-star-filled' style='color:#ffb900 !important;'></span></a><a href='//wordpress.org/support/plugin/helper-lite-for-pagespeed/reviews/?rate=2#new-post' target='_blank' data-rating='2' title='" . __( 'Works', 'helper-lite-for-pagespeed' ) . "'><span class='dashicons dashicons-star-filled' style='color:#ffb900 !important;'></span></a><a href='//wordpress.org/support/plugin/helper-lite-for-pagespeed/reviews/?rate=3#new-post' target='_blank' data-rating='3' title='" . __( 'Good', 'helper-lite-for-pagespeed' ) . "'><span class='dashicons dashicons-star-filled' style='color:#ffb900 !important;'></span></a><a href='//wordpress.org/support/plugin/helper-lite-for-pagespeed/reviews/?rate=4#new-post' target='_blank' data-rating='4' title='" . __( 'Great', 'helper-lite-for-pagespeed' ) . "'><span class='dashicons dashicons-star-filled' style='color:#ffb900 !important;'></span></a><a href='//wordpress.org/support/plugin/helper-lite-for-pagespeed/reviews/?rate=5#new-post' target='_blank' data-rating='5' title='" . __( 'Fantastic!', 'helper-lite-for-pagespeed' ) . "'><span class='dashicons dashicons-star-filled' style='color:#ffb900 !important;'></span></a><span>",
		);

		return array_merge( $links, $meta_links );
	}

	/**
	 * Configure setting fields
	 */
	public function setup_fields() {
		// ======================== SETTINGS ========================

		// Settings section.
		$this->hlfp_osa->add_section(
			array(
				'id'    => 'hlfp_settings',
				'icon'  => '<span class="dashicons dashicons-admin-generic"></span>',
				'title' => __( 'Settings', 'helper-lite-for-pagespeed' ),
			)
		);

		// Filter type selection field.
		$this->hlfp_osa->add_field(
			'hlfp_settings',
			array(
				'id'      => 'filter_type',
				'type'    => 'select',
				'name'    => __( 'Select filter type', 'helper-lite-for-pagespeed' ),
				'desc'    => __( 'Filter - use default Wordpress filters. Will not filter all images on page.<br />Buffer - use PHP buffer. Filter all images on page. Might cause problems on some servers.', 'helper-lite-for-pagespeed' ),
				'options' => array(
					'filter'    => 'Filters',
					'buffering' => 'Buffer',
				),
			)
		);

		// Loading type selection field.
		$this->hlfp_osa->add_field(
			'hlfp_settings',
			array(
				'id'      => 'loading_type',
				'type'    => 'select',
				'name'    => __( 'loading', 'helper-lite-for-pagespeed' ),
				'desc'    => __( 'Attribute "loading" for &lt;image&gt;', 'helper-lite-for-pagespeed' ),
				'options' => array(
					'none'  => '-',
					'lazy'  => 'lazy',
					'eager' => 'eager',
					'auto'  => 'auto',

				),
			)
		);

		// Decoding type selection field.
		$this->hlfp_osa->add_field(
			'hlfp_settings',
			array(
				'id'      => 'decoding_type',
				'type'    => 'select',
				'name'    => __( 'decoding', 'helper-lite-for-pagespeed' ),
				'desc'    => __( 'Attribute "decoding" for &lt;image&gt;', 'helper-lite-for-pagespeed' ),
				'options' => array(
					'async' => 'async',
					'sync'  => 'sync',
					'auto'  => 'auto',
					'none'  => '-',
				),
			)
		);

		// Iframe loading type selection field.
		$this->hlfp_osa->add_field(
			'hlfp_settings',
			array(
				'id'      => 'iframe_loading_type',
				'type'    => 'select',
				'name'    => __( 'iframe loading', 'helper-lite-for-pagespeed' ),
				'desc'    => __( 'Attribute "loading" for &lt;iframe&gt;', 'helper-lite-for-pagespeed' ),
				'options' => array(
					'lazy'  => 'lazy',
					'eager' => 'eager',
					'auto'  => 'auto',
					'none'  => '-',
				),
			)
		);
		// ======================== IMAGES ========================

		// Images section.
		$this->hlfp_osa->add_section(
			array(
				'id'    => 'hlfp_images',
				'icon'  => '<span class="dashicons dashicons-format-image"></span>',
				'title' => __( 'Images', 'helper-lite-for-pagespeed' ),
			)
		);

		// Display:none, LQIP radio.
		$this->hlfp_osa->add_field(
			'hlfp_images',
			array(
				'id'      => 'hlfp_lqip',
				'type'    => 'radio',
				'name'    => __( 'LQIP', 'helper-lite-for-pagespeed' ),
				'desc'    => __( 'Improve Largest Contentful Paint (LCP) by optimizing thumbnail loading<br/> - method display:none - to hide Post Thumbnail on mobile device via the CSS property display<br/> - method LQIP - set Low Quality Image Placeholders for Post Thumbnail', 'helper-lite-for-pagespeed' ),
				'options' => array(
					'disable' => 'Disable',
					'dnone'   => 'display:none',
					'lqip'    => 'LQIP',
				),
			)
		);
		// ======================== SCRIPTS ========================

		// Scripts section.
		$this->hlfp_osa->add_section(
			array(
				'id'    => 'hlfp_scripts',
				'icon'  => '<span class="dashicons dashicons-editor-code"></span>',
				'title' => __( 'Scripts', 'helper-lite-for-pagespeed' ),
			)
		);

		// Passive event checkbox.
		$this->hlfp_osa->add_field(
			'hlfp_scripts',
			array(
				'id'   => 'passive_events',
				'type' => 'checkbox',
				'name' => __( 'Use passive events', 'helper-lite-for-pagespeed' ),
				'desc' => __( 'Events with attribute passive perform better for touch and wheel', 'helper-lite-for-pagespeed' ),
			)
		);

		// ======================== MORE OPTIMIZATION ========================

		// Other plugins section.
		$this->hlfp_osa->add_section(
			array(
				'id'    => 'hlfp_other_plugins',
				'icon'  => '<span class="dashicons dashicons-admin-plugins"></span>',
				'title' => __( 'More optimization', 'helper-lite-for-pagespeed' ),
			)
		);

		$this->hlfp_osa->add_field(
			'hlfp_other_plugins',
			array(
				'id'   => 'plugins',
				'type' => 'html',
				'name' => '',
				'desc' => function () {
					// Кэшируем ответ от API на сутки,
					// чтобы не дергать его при каждом открытии страницы.
					$transient = HLFP_SLUG . '-plugins';
					$cached    = get_transient( $transient );

					if ( false !== $cached ) {
						return $cached;
					}

					ob_start();
					require_once ABSPATH . 'wp-admin/includes/class-wp-plugin-install-list-table.php';
					$_POST['tab'] = HLFP_SLUG;
					$table        = new WP_Plugin_Install_List_Table();
					$table->prepare_items();
					$table->display();

					$content = ob_get_clean();
					set_transient( $transient, $content, 1 * DAY_IN_SECONDS );

					return $content;
				},
			)
		);

		// ======================== CONTACTS ========================

		// Contacts section.
		$this->hlfp_osa->add_section(
			array(
				'id'    => 'hlfp_help',
				'icon'  => '<span class="dashicons dashicons-editor-help"></span>',
				'title' => __( 'Help', 'helper-lite-for-pagespeed' ),
			)
		);

		// Donate.
		$this->hlfp_osa->add_field(
			'hlfp_help',
			array(
				'id'   => 'donate',
				'type' => 'html',
				'name' => '<h2>' . __( 'Donate', 'helper-lite-for-pagespeed' ) . '</h2>',
				'desc' => function () {
					?>
					<style>#yadonate {
							color: #f8fffa;
							cursor: pointer;
							text-decoration: none;
							background-color: #47b869;
							padding: 8px 30px 8px 30px;
							font-size: 15px;
							border-radius: 3px;
							border: 1px solid rgba(0, 0, 0, .1);
							transition: background-color .1s ease-out 0s;
						}
					</style>
					<div class="inside" style="display: block;margin-right: 12px;">
						<img
							src="<?php echo esc_url( HLFP_URL . 'img/icon_coffe_logo.png' ); ?>"
							title="Купить мне чашку кофе :)"
							width="150"
							height="150"
							style="margin: 5px; float:left;"
						>
						<p>Привет, мы команда разработчиков <strong>Helper lite for PageSpeed</strong>.</p>
						<p>Мы разработали данный плагин бесплатно, но не откажемся от небольшого пожертвования :) <br>
							Можете отблагодарить нас за проделанную работу чашечкой кофе.
						</p>
						<br>
						<a target="_blank" id="yadonate" href="https://bit.ly/3oZjINE" title="Подарить чашечку кофе">Подарить</a>
						<div style="clear:both;"></div>
					</div>
					<?php
				},
			)
		);

		$this->hlfp_osa->add_field(
			'hlfp_help',
			array(
				'id'   => 'faq',
				'type' => 'html',
				'name' => '<h2>' . __( 'FAQ', 'helper-lite-for-pagespeed' ) . '</h2>',
				'desc' => function() {
					?>
					<h4><?php esc_html_e( 'Filters or Buffer?', 'helper-lite-for-pagespeed' ); ?></h4>
					<ul>
						<li>
							<?php echo wp_kses_post( __( '<b>Filters</b> — will not filter all images on page. Affects only post/page content and thumbnails. Uses Wordpress standard filters. Safe to use on any site.', 'helper-lite-for-pagespeed' ) ); ?>
						</li>
						<li>
							<?php echo wp_kses_post( __( '<b>Buffer</b> — will filter all images on page. Uses PHP buffer. Might cause problems on some sites due to servers configuration or conflicts with other plugins that use buffer.<br /> Use this filter type if you want plugin affect to all images on your site. If you see any problems with site loading or post/page saving with Buffer enabled, use Filters type instead.', 'helper-lite-for-pagespeed' ) ); ?>
						</li>
					</ul>
					<h4><?php esc_html_e( 'What attributes should I use?', 'helper-lite-for-pagespeed' ); ?></h4>
					<p><?php echo wp_kses_post( __( 'It has been experimentally proven that combination of attributes <code>loading="lazy"</code> and <code>decoding="async"</code> on <code>&lt;img&gt;</code> speeds up page loading by 0.1-0.2 seconds and increases Your Google PageSpeed Insights Score. We recommend You to use this attributes combination. You can also turn off attribute at all, if You, for example, use third-party lazy loading.<br /><code>loading="lazy"</code> for <code>&lt;iframe&gt;</code> also speeds up page loading.', 'helper-lite-for-pagespeed' ) ); ?></p>
					<p><b style="font-style:normal;"><?php echo wp_kses_post( __( 'For more information visit our <a href="https://wordpress.org/plugins/helper-lite-for-pagespeed/#faq-header" target="_blank">FAQ</a>.', 'helper-lite-for-pagespeed' ) ); ?></p>
					<?php
				},
			)
		);

		// Contact us.
		$this->hlfp_osa->add_field(
			'hlfp_help',
			array(
				'id'   => 'telegram',
				'type' => 'html',
				'name' => '<h2>' . __( 'Support', 'helper-lite-for-pagespeed' ) . '</h2>',
				'desc' => sprintf(
					// translators: available languages.
					__( 'We speak %s languages.', 'helper-lite-for-pagespeed' ),
					'<span style="background-color: #cecece;padding: 2px 5px;border-radius: 10px;">' . $this->get_flags(
						array(
							'uk',
							'usa',
							'ru',
							'ua',
							'pl',
						)
					) . '</span>'
				) . '<br/><b style="font-style:normal;color:#444;">' . __( '- Contact us at' ) . ' <a href="https://wordpress.org/support/plugin/helper-lite-for-pagespeed/" target="_blank">Support Page on WordPress.org</a></b> <br/>',
			)
		);

		// Developers text.
		$this->hlfp_osa->add_field(
			'hlfp_help',
			array(
				'id'   => 'developers',
				'type' => 'html',
				'name' => '<h2>' . __( 'Developers', 'helper-lite-for-pagespeed' ) . '</h2>',
				'desc' => function () {
					?>
					<div style="display:flex;flex-direction:column;">
						<div>
							<h4><?php esc_html_e( 'Eugen Kalinsky', 'helper-lite-for-pagespeed' ); ?></h4>
							<img
								width="100"
								height="100"
								src="<?php echo esc_url( HLFP_URL . 'img/seojacky.jpeg' ); ?>"
								style="border-radius:100%;float:left;"
							>
							<p style="float:left;margin-left:2rem;">
								<?php esc_html_e( 'Web-Master, SEO specialist, SEO optimization + PageSpeed for Wordpress sites', 'helper-lite-for-pagespeed' ); ?>
								<br/>
								<?php esc_html_e( 'Languages', 'helper-lite-for-pagespeed' ); ?>
								<span style="background-color: #cecece;padding: 2px 5px;border-radius: 10px;">
									<?php
									echo wp_kses_post(
										$this->get_flags(
											array(
												'uk',
												'usa',
												'ru',
												'ua',
											)
										)
									);
									?>
								</span>
								<br/>
								<b><?php esc_html_e( 'Telegram profile ', 'helper-lite-for-pagespeed' ); ?><a href="https://t.me/big_jacky" target="_blank">@big_jacky</a></b>
							</p>
						</div>
						<hr style="border-top: 1px solid gray;width:50%;margin:1.5rem 0;"/>
						<div>
							<h4><?php esc_html_e( 'Karenina', 'helper-lite-for-pagespeed' ); ?></h4>
							<img
								width="100"
								height="100"
								src="<?php echo esc_url( HLFP_URL . 'img/karenina.png' ); ?>"
								style="border-radius:100%;float:left;"
							>
							<p style="float:left;margin-left:2rem;">
								<?php esc_html_e( 'PHP & JavaScript (NodeJS) programmer, Wordpress themes and plugins developer', 'helper-lite-for-pagespeed' ); ?>
								<br/>
								<?php esc_html_e( 'Languages', 'helper-lite-for-pagespeed' ); ?>
								<span style="background-color: #cecece;padding: 2px 5px;border-radius: 10px;">
									<?php
									echo wp_kses_post(
										$this->get_flags(
											array(
												'uk',
												'usa',
												'ru',
												'ua',
												'pl',
											)
										)
									);
									?>
								</span><br/>
								<b><?php esc_html_e( 'Telegram profile ', 'helper-lite-for-pagespeed' ); ?><a href="https://t.me/kar_enina" target="_blank">@kar_enina</a></b>
							</p>
						</div>
						<hr style="border-top: 1px solid gray;width:50%;margin:1.5rem 0;">
						<div>
							<h4><?php esc_html_e( 'Mikhail Kobzarev (mihdan)', 'helper-lite-for-pagespeed ' ); ?></h4>
							<img
								width="100"
								height="100"
								src="<?php echo esc_url( HLFP_URL . 'img/mikhail-kobzarev.jpg' ); ?>"
								style="border-radius:100%;float:left;"
							>
							<p style="float:left;margin-left:2rem;"><?php esc_html_e( 'TeamLead, WordPress evangelist, PHP & JavaScript programmer, Wordpress themes and plugins developer', 'helper-lite-for-pagespeed' ); ?>
								<br/>
								<?php esc_html_e( 'Languages', 'helper-lite-for-pagespeed' ); ?>
								<span style="background-color: #cecece;padding: 2px 5px;border-radius: 10px;">
									<?php
									echo wp_kses_post(
										$this->get_flags(
											array(
												'uk',
												'usa',
												'ru',
												'ua',
											)
										)
									);
									?>
								</span><br/>
								<b><?php esc_html_e( 'Telegram profile ', 'helper-lite-for-pagespeed' ); ?><a href="https://t.me/mihdan" target="_blank">@mihdan</a></b><br>
								<b><?php esc_html_e( 'GitHub profile ', 'helper-lite-for-pagespeed' ); ?><a href="https://github.com/mihdan/" target="_blank">@mihdan</a></b><br>
								<b><?php esc_html_e( 'WordPress profile ', 'helper-lite-for-pagespeed' ); ?><a href="https://profiles.wordpress.org/mihdan/" target="_blank">@mihdan</a></b>
							</p>
						</div>
					</div>
					<?php
				},
			)
		);
	}

	/**
	 * Returns flag codes with delimiters
	 *
	 * @param array  $flags Array of country codes.
	 * @param string $delim Delimiter.
	 *
	 * @return string flag codes
	 */
	public function get_flags( $flags, $delim = ' ' ) {
		$result = '';

		foreach ( $flags as $flag ) {
			if ( isset( $this->flags[ $flag ] ) ) {
				$result .= $this->flags[ $flag ] . $delim;
			}
		}

		return $result;
	}
}

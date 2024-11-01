<?php

/**
 * Sharing Plus Settings
 */
if(!class_exists('Sharing_Plus_Settings')):
	
	class Sharing_Plus_Settings {

		private $settings_api;

		function __construct() {

			include_once  SHARING_PLUS_PLUGIN_DIR . '/admin/tcy-strucutre.php';
			$this->settings_api = new Sharing_Plus_Structure();
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'wp_ajax_sharing_plus_export', array( $this, 'export' ) );
			add_action( 'wp_ajax_sharing_plus_import', array( $this, 'import' ) );

		}

		function admin_menu() {

			if ( current_user_can( 'activate_plugins' ) ) {

				add_menu_page( 'Sharing Plus ', 'Sharing Plus ', 'activate_plugins', 'sharing-plus', array( $this, 'plugin_page' ), 'dashicons-share', 100 );

				add_submenu_page( 'sharing-plus', 'Settings', 'Settings', 'manage_options', 'sharing-plus' );
				do_action( 'sharing_plus_add_pro_submenu' );

				add_submenu_page( 'sharing-plus', esc_html__( 'Import and export settings', 'sharing-plus' ), esc_html__( 'Import / Export', 'sharing-plus' ), 'manage_options', 'sharing-plus-import-export', array( $this, 'import_export_page' ) );

			}

		}

		function get_settings_sections() {
			$sections = array(
				array(
					'id'       => 'sharing_plus_networks',
					'title'    => esc_html__( 'Choose Sharing Icons', 'sharing-plus' ),
					'priority' => '10',
				),
				array(
					'id'       => 'sharing_plus_themes',
					'title'    => esc_html__( 'Sharing Icon Themes', 'sharing-plus' ),
					'priority' => '15',
				),
				array(
					'id'       => 'sharing_plus_positions',
					'title'    => esc_html__( 'Sharing Icon Postions', 'sharing-plus' ),
					'priority' => '20',
				),
				array(
					'id'       => 'sharing_plus_sidebar',
					'title'    => esc_html__( 'Sharing Icons Sidebar', 'sharing-plus' ),
					'priority' => '25',
				),
				array(
					'id'       => 'sharing_plus_inline',
					'title'    => esc_html__( 'Sharing Icon Inline', 'sharing-plus' ),
					'priority' => '30',
				),

				array(
					'id'       => 'sharing_plus_advanced',
					'title'    => esc_html__( 'Sharing Icon Advanced', 'sharing-plus' ),
					'priority' => '99',
				),
			);

			$setting_section = apply_filters( 'sharing_plus_settings_panel', $sections );

			usort( $setting_section, array( $this, 'sort_array' ) );

			return $setting_section;
		}

		public function sort_array( $a, $b ){
			return $a['priority'] - $b['priority'];
		}

		public function get_current_post_types() {

			$post_types_list = array(
				'home' => 'Home'
			);

			$args = array(
				'public' => true,
			);

			$post_types = get_post_types( $args );

			foreach ( $post_types as $post_type ) {
				$post_types_list[ $post_type ] = ucfirst( $post_type );
			}

			return $post_types_list;
		}

		/**
		 * Returns all the settings fields
		 *
		 * @return array settings fields
		 */
		function get_settings_fields() {
			$post_types = $this->get_current_post_types();
			$sharing_plus_positions_options = apply_filters( 'sharing_plus_positions_options',  array(
				'sidebar' => 'Sidebar',
				'inline'  => 'Inline',
			) ) ;

			$sharing_plus_sidebar = array(
				array(
					'name'    => 'orientation',
					'label'   => __( 'Sidebar Orientation', 'sharing-plus' ),
					'desc'    => __( '<h4>Display Settings</h4>', 'sharing-plus' ),
					'type'    => 'sharing_plus_select',
					'default' => 'left',
					'options' => array(
						'left'  => 'Left',
						'right' => 'Right',
					),
					'priority' => '5',
				),
				array(
					'name'    => 'animation',
					'label'   => __( 'Intro Animation', 'sharing-plus' ),
					'type'    => 'sharing_plus_select',
					'default' => 'no-animation',
					'options' => array(
						'no-animation'     => 'No',
						'right-in' => 'From Right',
						'top-in' => 'From Top',
						'bottom-in' => 'From Bottom',
						'left-in' => 'From Left',
						'fade-in' => 'FadeIn',
					),
					'priority' => '10',
				),
				array(
					'name'  => 'share_counts',
					'label' => __( 'Display Share Counts', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '15',
				),
				array(
					'name'  => 'total_share',
					'label' => __( 'Display Total Shares', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '20',
				),
				array(
					'name'  => 'icon_space',
					'label' => __( 'Add Icon Spacing', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '25',
				),
				array(
					'name'              => 'icon_space_value',
					'type'              => 'sharing_plus_text',
					'label'             => 'Enter the Space in Pixel',
					'sanitize_callback' => 'sanitize_text_field',
					'priority' => '30',
				),
				array(
					'name'  => 'hide_mobile',
					'label' => __( 'Hide On Mobile Devices', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '35',
				),
				array(
					'name'    => 'posts',
					'label'   => __( 'Post type Settings', 'sharing-plus' ),
					'desc'    => __( 'Multi checkbox description', 'sharing-plus' ),
					'type'    => 'sharing_plus_post_types',
					'default' => array('post' => 'post', 'page' => 'page'),
					'options' => $post_types,
					'priority' => '99',
				),
				
			);

			$sharing_plus_sidebar =  apply_filters( 'sharing_plus_sidebar_fields', $sharing_plus_sidebar );

			$sharing_plus_inline = array(
				array(
					'name'    => 'location',
					'label'   => esc_html__( 'Icon Position', 'sharing-plus' ),
					'desc'    => __( '<h4>Display Settings</h4>', 'sharing-plus' ),
					'type'    => 'sharing_plus_select',
					'default' => 'above',
					'options' => array(
						'above'       => 'Above The Content',
						'below'       => 'Below The Content',
						'above_below' => 'Above + Below The Content',
					),
					'priority' => '5',
				),
				array(
					'name'    => 'icon_alignment',
					'label'   => esc_html__( 'Icon Alignment', 'sharing-plus' ),
					'type'    => 'sharing_plus_select',
					'default' => 'left',
					'options' => array(
						'left'     => 'Left',
						'centered' => 'Centered',
						'right'    => 'Right',
					),
					'priority' => '10',
				),
				array(
					'name'    => 'animation',
					'label'   => esc_html__( 'Animation', 'sharing-plus' ),
					'type'    => 'sharing_plus_select',
					'default' => 'no-animation',
					'options' => array(
						'no-animation' => 'No',
						'bottom-in'    => 'From bottom',
						'top-in'       => 'From top',
						'left-in'      => 'From left',
						'right-in'     => 'From right',
						'fade-in'      => 'Fade In',
					),
					'priority' => '15',
				),
				array(
					'name'  => 'share_counts',
					'label' => esc_html__( 'Display Share Counts', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '20',
				),
				array(
					'name'  => 'total_share',
					'label' => esc_html__( 'Display Total Shares', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '25',
				),
				array(
					'name'  => 'icon_space',
					'label' => esc_html__( 'Add Icon Spacing', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '30',
				),
				array(
					'name'              => 'icon_space_value',
					'type'              => 'sharing_plus_text',
					'label'             => 'Enter the Space in Pixel',
					'sanitize_callback' => 'sanitize_text_field',
					'priority' => '35',
				),
				array(
					'name'  => 'hide_mobile',
					'label' => __( 'Hide On Mobile Devices', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '40',
				),
				array(
					'name'  => 'show_on_category',
					'label' => __( 'Show at Category pages', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '45',
				),
				array(
					'name'  => 'show_on_archive',
					'label' => esc_html__( 'Show at Archive pages', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '50',

				),
				array(
					'name'  => 'show_on_tag',
					'label' => esc_html__( 'Show at Tag pages', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '55',
				),
				array(
					'name'  => 'show_on_search',
					'label' => esc_html__( 'Show at Search pages', 'sharing-plus' ),
					'type'  => 'sharing_plus_checkbox',
					'priority' => '56',
				),
				array(
					'name'  => 'share_title',
					'label' => esc_html__( 'Share Title', 'sharing-plus' ),
					'type'  => 'sharing_plus_text',
					'priority' => '57',
				),
				array(
					'name'    => 'posts',
					'label'   => esc_html__( 'Post type Settings', 'sharing-plus' ),
					'desc'    => esc_html__( 'Multi checkbox description', 'sharing-plus' ),
					'type'    => 'sharing_plus_post_types',
					'default' => array('post' => 'post', 'page' => 'page'),
					'options' => $post_types,
					'priority' => '99',
				),
			);

			$sharing_plus_inline = apply_filters( 'sharing_plus_inline_fields', $sharing_plus_inline );

			$settings_fields = array(
				'sharing_plus_networks' => array(
					array(
						'name' => 'icon_selection',
						'type' => 'sharing_plus_icon_selection',
					)
				),
				'sharing_plus_themes' => array(
					array(
						'name'    => 'icon_style',
						'label'   => __( 'Icon Style', 'sharing-plus' ),
						'type'    => 'icon_style',
						'options' => array(
							'sm-round'           => 'sm-round',
							'simple-round'       => 'simple-round',
							'round-txt'          => 'round-txt',
							'round-btm-border'   => 'round-btm-border',
							'flat-button-border' => 'flat-button-border',
							'round-icon'         => 'round-icon',
							'simple-icons'       => 'simple-icons',
						),
					),
				),
				'sharing_plus_positions' => array(
					array(
						'name'    => 'position',
						'label'   => esc_html__( 'Postions', 'sharing-plus' ),
						'desc'    => esc_html__( 'Multi checkbox description', 'sharing-plus' ),
						'type'    => 'position',
						'default' => 'inline',
						'options' => $sharing_plus_positions_options,
					),

				),
				'sharing_plus_sidebar' => $sharing_plus_sidebar,
				'sharing_plus_inline'  => $sharing_plus_inline,
				'sharing_plus_advanced' => array(
					array(
						'name'              => 'twitter_handle',
						'type'              => 'sharing_plus_text',
						'label'             => __( 'Twitter @username:', 'sharing-plus' ),
						'sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'name'              => 'http_https_resolve',
						'type'              => 'sharing_plus_checkbox',
						'label'             => __( 'Http/Https counts resolve:', 'sharing-plus' ),
					),
				),
			);

			$settings_fields = apply_filters( 'sharing_plus_setting_fields' , $settings_fields, $post_types );

			return $settings_fields;
		}

		function plugin_page() {
			?>
			<div class="wrap">
				<?php
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
				?>
			</div>
			<?php
		}

		/**
		 * Get all the pages
		 *
		 * @return array page names with key value pairs
		 */
		function get_pages() {
			$pages = get_pages();
			$pages_options = array();
			if ( $pages ) {
				foreach ( $pages as $page ) {
					$pages_options[ $page->ID ] = $page->post_title;
				}
			}

			return $pages_options;
		}

		function admin_init() {

				// set the settings
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

				// initialize settings
			$this->settings_api->admin_init();
		}

	/**
	 * Include Import/Export Page.
	 *
	 * @since 1.0.0
	 */
	public function import_export_page() {
		require_once sharing_plus_file_directory('admin/tcy-import-export.php');
	}

	/**
	 * Export Settings
	 *
	 * @since 1.0.0
	 */
	public function export() {

		$sections = $this->get_settings_sections();
		$settings = array();

		foreach ( $sections as $section ) {
			$result                       = get_option( $section ['id'] );
			$settings [ $section ['id'] ] = $result;
		}

		echo json_encode( $settings );
		wp_die();
	}

	/**
	 * Import Settings.
	 *
	 * @since 1.0.0
	 */
	public function  import(){

		$sharing_plus_imp_tmp_name =  wp_normalize_path($_FILES['file']['tmp_name']);
		$sharing_plus_file_content = file_get_contents( $sharing_plus_imp_tmp_name );
		$import_array_data = json_decode( $sharing_plus_file_content, true );
		$sharing_plus_networks = isset($import_array_data['sharing_plus_networks']) ? $import_array_data['sharing_plus_networks'] : '';
		$default_keyset = array(
			'sharing_plus_networks',
			'sharing_plus_themes',
			'sharing_plus_positions',
			'sharing_plus_sidebar',
			'sharing_plus_inline',
			'sharing_plus_advanced',
		);
		if ( json_last_error() == JSON_ERROR_NONE ) {
			foreach ( $import_array_data as $sharing_plus_option_key => $option_details ) {
				if( in_array($sharing_plus_option_key, $default_keyset) ){
					update_option( $sharing_plus_option_key, $option_details );	
				}
			}
		}else{
			esc_html_e('Sorry your please upload json file', 'sharing-plus'); // console error
		}
		wp_die();
	}


}
endif;

new Sharing_Plus_Settings();

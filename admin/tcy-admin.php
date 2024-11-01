<?php
/**
 * Admin class
 *
 * Gets only initiated if this plugin is called inside the admin section ;)
 */
if ( ! class_exists( 'Sharing_Plus_Admin' ) ) :

	 /*extends Sharing_Plus */
	class Sharing_Plus_Admin{

		function __construct() {
			
			//parent::__construct();

			include_once  SHARING_PLUS_PLUGIN_DIR . '/inc/core/tcy-settings.php';

			add_action( 'add_meta_boxes', array( $this, 'sharing_plus_meta_box' ) );
			add_action( 'save_post', array( $this, 'sharing_plus_save_meta' ), 10, 2 );

			add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );

			//add_action( 'admin_footer', array( $this, 'add_deactive_modal' ) );
			//add_action( 'wp_ajax_sharing_plus_deactivate', array( $this, 'sharing_plus_deactivate' ) );
			add_action( 'admin_init', array( $this, 'review_notice' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'in_admin_header', array( $this, 'skip_notices' ), 100000 );

		}

		/**
		 * Add Settings links in plugins.php
		 *
		 * @since 1.0.0
		 */
		public function plugin_action_links( $links, $file ) {
			static $this_plugin;

			if ( ! $this_plugin ) {
				$this_plugin = plugin_basename( __FILE__ );
			}

			if ( $file == $this_plugin ) {
				$settings_link = '<a href="' . admin_url( 'admin.php?page=sharing-plus' ) . '">' . __( 'Settings', 'sharing-plus' ) . '</a>';
				array_unshift( $links, $settings_link );
			}

			return $links;
		}
		function admin_enqueue_scripts( $page ) {

			if ( 'toplevel_page_sharing-plus' == $page  || 'social-buttons_page_sharing-plus-help' == $page || 'widgets.php' == $page ) {
				//wp_enqueue_script( 'jquery-ui-sortable' );
				wp_enqueue_script('post');
				wp_enqueue_script('postbox');
				wp_enqueue_script( 'sharing-plus-admin-js', plugins_url( 'assets/js/sharing-plus-admin.min.js',plugin_dir_path( __FILE__ ) ), array( 'jquery', 'jquery-ui-sortable' ), SHARING_PLUS_VERSION );
			}
			wp_enqueue_style( 'sharing-plus-admin-cs', plugins_url( 'assets/css/sharing-plus-admin.min.css',plugin_dir_path( __FILE__ ) ), false, SHARING_PLUS_VERSION );

		}

		/**
		 * Register meta box to hide/show SHARING_PLUS plugin on single post or page
		 */
		public function sharing_plus_meta_box() {
			
			$postId = isset( $_GET['post'] ) ? absint($_GET['post']) : false;
			$postType = get_post_type( $postId );

			if ( $postType != 'page' && $postType != 'post' ) {
				return false;
			}

			$currentSsbHide = get_post_custom_values( SHARING_PLUS_HIDE_CUSTOM_META_KEY, $postId );

			if ( $currentSsbHide[0] == 'true' ) {
				$checked = true;
			} else {
				$checked = false;
			}

			// Rendering meta box
			if ( ! function_exists( 'add_meta_box' ) ) {
				include( 'includes/template.php' );
			}

			add_meta_box(
				'sharing_plus_meta_box', 
				esc_html__( 'Sharing Plus Settings', 'sharing-plus' ), 
				array( $this, 'render_sharing_plus_meta_box' ), 
				$postType, 
				'side',
				'default', 
				array(
					'type' => $postType,
					'checked' => $checked,
				)
			);
		}

		/**
		 * Showing custom meta field
		 */
		public function render_sharing_plus_meta_box( $post, $metabox ) {

			wp_nonce_field( plugin_basename( __FILE__ ), 'sharing_plus_noncename' );
			?>
		  <label for="<?php echo SHARING_PLUS_HIDE_CUSTOM_META_KEY; ?>"><input type="checkbox" id="<?php echo SHARING_PLUS_HIDE_CUSTOM_META_KEY; ?>" name="<?php echo SHARING_PLUS_HIDE_CUSTOM_META_KEY; ?>" value="true"
				<?php if ( $metabox['args']['checked'] ) : ?>
				 checked="checked"
        <?php endif; ?>/><?php esc_html_e( 'Hide Sharing Plus', 'sharing-plus' ); ?></label>
		<?php
		}


		/**
		 * Saving custom meta value
		 */
		public function sharing_plus_save_meta( $post_id, $post ) {

			$postId = (int) $post_id;
			$nonce_value = isset($_POST['sharing_plus_noncename']) ? esc_html($_POST['sharing_plus_noncename']) : '';
			$post_type = (isset($_POST['post_type']) ) ? esc_html($_POST['post_type']) : '';

			// Verify if this is an auto save routine.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! $nonce_value ) {
				return;
			}
			
			// Verify this came from the our screen and with proper authorization
			if ( ! wp_verify_nonce( $nonce_value, plugin_basename( __FILE__ ) ) ) {
				return;
			}

			// Check permissions
			if ( 'page' == $post_type ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}

			// Saving data
			$newValue = (isset( $_POST[ SHARING_PLUS_HIDE_CUSTOM_META_KEY ] )) ? esc_attr($_POST[ SHARING_PLUS_HIDE_CUSTOM_META_KEY ]) : 'false';

			update_post_meta( $postId, SHARING_PLUS_HIDE_CUSTOM_META_KEY, $newValue );
		}


		/**
		 * Show the popup on pluing deactivate
		 *
		 * @since 1.0.0
		 */
		function add_deactive_modal() {
			global $pagenow;

			if ( 'plugins.php' !== $pagenow ) {
				return;
			}

			include SHARING_PLUS_PLUGIN_DIR . 'inc/tcy-deactivate-form.php';
		}

		/**
		 * Send the user responce to api.
		 *
		 * @since 1.0.0
		 */
		function sharing_plus_deactivate() {
			$email         = get_option( 'admin_email' );
			$_reason       = sanitize_text_field( wp_unslash( $_POST['reason'] ) );
			$reason_detail = sanitize_text_field( wp_unslash( $_POST['reason_detail'] ) );
			$reason        = '';

			if ( $_reason == '1' ) {
				$reason = 'I only needed the plugin for a short period';
			} elseif ( $_reason == '2' ) {
				$reason = 'I found a better plugin';
			} elseif ( $_reason == '3' ) {
				$reason = 'The plugin broke my site';
			} elseif ( $_reason == '4' ) {
				$reason = 'The plugin suddenly stopped working';
			} elseif ( $_reason == '5' ) {
				$reason = 'I no longer need the plugin';
			} elseif ( $_reason == '6' ) {
				$reason = 'It\'s a temporary deactivation. I\'m just debugging an issue.';
			} elseif ( $_reason == '7' ) {
				$reason = 'Other';
			}
			$fields = array(
				'email'             => $email,
				'website'           => get_site_url(),
				'action'            => 'Deactivate',
				'reason'            => $reason,
				'reason_detail'     => $reason_detail,
				'blog_language'     => get_bloginfo( 'language' ),
				'wordpress_version' => get_bloginfo( 'version' ),
				'plugin_version'    => SHARING_PLUS_VERSION,
				'php_version'				=> PHP_VERSION,
				'plugin_name'       => 'Sharing Plus',
			);

			$response = wp_remote_post(
				SHARING_PLUS_FEEDBACK_SERVER, array(
					'method'      => 'POST',
					'timeout'     => 5,
					'httpversion' => '1.0',
					'blocking'    => false,
					'headers'     => array(),
					'body'        => $fields,
				)
			);

			wp_die();
		}

		/**
		 * Check either to show notice or not.
		 *
		 * @since 1.0.0
		 */
		public function review_notice() {

			$this->review_dismissal();
			$this->review_prending();

			$review_dismissal   = get_site_option( 'sharing_plus_review_dismiss' );
			if ( 'yes' == $review_dismissal ) {
				return;
			}

			$activation_time    = get_site_option( 'sharing_plus_active_time' );
			if ( ! $activation_time ) {

				$activation_time = time();
				add_site_option( 'sharing_plus_active_time', $activation_time );
			}

			// 1296000 = 15 Days in seconds.
			if ( time() - $activation_time > 1 ) {
				add_action( 'admin_notices' , array( $this, 'review_notice_message' ) );
			}

		}

		/**
		 * Show review Message After 15 days.
		 *
		 * @since 1.0.0
		 */
		public function review_notice_message() {

			$scheme      = ( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY ) ) ? '&' : '?';
			$url         = $_SERVER['REQUEST_URI'] . $scheme . 'sharing_plus_review_dismiss=yes';
			$dismiss_url = wp_nonce_url( $url, 'sharing-plus-review-nonce' );

			$_later_link = $_SERVER['REQUEST_URI'] . $scheme . 'sharing_plus_review_later=yes';
			$later_url   = wp_nonce_url( $_later_link, 'sharing-plus-review-nonce' );

			?>
		  <div class="sharing-plus-review-notice">
			<div class="sharing-plus-review-thumbnail">
		  <img src="<?php echo plugins_url( '../assets/images/sharing_plus_grey_logo.png', __FILE__ ); ?>" alt="">
		</div>
		<div class="sharing-plus-review-text">
		<h3><?php esc_html_e( 'Leave A Review?', 'sharing-plus' ); ?></h3>
		<p><?php esc_html_e( 'We hope you\'ve enjoyed using Sharing Plus! Would you consider leaving us a review on WordPress.org?', 'sharing-plus' ); ?></p>
		<ul class="sharing-plus-review-ul"><li><a href="https://wordpress.org/support/plugin/sharing-plus/reviews/?filter=5" target="_blank"><span class="dashicons dashicons-external"></span><?php esc_html_e( 'Sure! I\'d love to!', 'sharing-plus' ); ?></a></li>
		  <li><a href="<?php echo $dismiss_url; ?>"><span class="dashicons dashicons-smiley"></span><?php esc_html_e( 'I\'ve already left a review', 'sharing-plus' ); ?></a></li>
		  <li><a href="<?php echo $later_url; ?>"><span class="dashicons dashicons-calendar-alt"></span><?php esc_html_e( 'Maybe Later', 'sharing-plus' ); ?></a></li>
		  <li><a href="<?php echo $dismiss_url; ?>"><span class="dashicons dashicons-dismiss"></span><?php esc_html_e( 'Never show again', 'sharing-plus' ); ?></a></li></ul>
		</div>
		</div>
		<?php
		}

		/**
		 * Set time to current so review notice will popup after 15 days
		 *
		 * @since 1.0.0
		 */
		function review_prending() {

			// delete_site_option( 'sharing_plus_review_dismiss' );
			if ( ! is_admin() ||
			! current_user_can( 'manage_options' ) ||
			! isset( $_GET['_wpnonce'] ) ||
			! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'sharing-plus-review-nonce' ) ||
			! isset( $_GET['sharing_plus_review_later'] ) ) {

				return;
			}

			// Reset Time to current time.
			update_site_option( 'sharing_plus_active_time', time() );

		}

		/**
		 *   Check and Dismiss review message.
		 *
		 *   @since 1.0.0
		 */
		private function review_dismissal() {

			// delete_site_option( 'sharing_plus_review_dismiss' );
			if ( ! is_admin() ||
			! current_user_can( 'manage_options' ) ||
			! isset( $_GET['_wpnonce'] ) ||
			! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'sharing-plus-review-nonce' ) ||
			! isset( $_GET['sharing_plus_review_dismiss'] ) ) {

				return;
			}

			add_site_option( 'sharing_plus_review_dismiss', 'yes' );
		}


		/**
		 * Skip the all the notice from settings page.
		 *
		 * @since 1.0.0
		 */
		function skip_notices() {

			if ( 'toplevel_page_sharing-plus' === get_current_screen()->id ) {

				global $wp_filter;

				if ( is_network_admin() and isset( $wp_filter['network_admin_notices'] ) ) {
					unset( $wp_filter['network_admin_notices'] );
				} elseif ( is_user_admin() and isset( $wp_filter['user_admin_notices'] ) ) {
					unset( $wp_filter['user_admin_notices'] );
				} else {
					if ( isset( $wp_filter['admin_notices'] ) ) {
						unset( $wp_filter['admin_notices'] );
					}
				}

				if ( isset( $wp_filter['all_admin_notices'] ) ) {
					unset( $wp_filter['all_admin_notices'] );
				}
			}

		}


	} // end Sharing_Plus_Admin

endif;
?>

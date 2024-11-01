<?php
/**
 * Widget class for social share follower widget
 * @package ThemeCentury
 * @subpackage Sharing Plus
 * @sicne 1.0.0
 *
 *  Class Sharing_Plus_Follower_Widget
 */
if(!class_exists('Sharing_Plus_Follower_Widget')):

	class Sharing_Plus_Follower_Widget extends Sharing_Plus_Master_Widget{

		/**
		 * Google console api key for google+ and youtube api for getting follower and subscriber
		 * @var string
		 */
		private $api_key = 'AIzaSyBkQDWiRWxWKUoavuajUSAs28ld0Pdx8a4';

		/**
		 * Transient Time
		 *
		 * 43200 = 12 Hours
		 */
		private $cache_time = 43200;

		/**
		 * Register sharing_plus widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$widget_options = array(
				'description' => 'Display Follow Button For your site',
			);
			parent::__construct( 'sharing_plus_follower_widget', 'Follow on Social Media', $widget_options );

		}

		public function widget_fields(){

			$fields = array(
				'sharing_plus_widget_tab'    => array(
					'tcy_widgets_name'          => 'sharing_plus_widget_tab',
					'tcy_widgets_title'         => esc_html__( 'General', 'sharing-plus' ),
					'tcy_widgets_default'       => 'general',
					'tcy_widgets_field_type'    => 'tabgroup',
					'tcy_widgets_tabs'          => array(
						'general'=>array(
							'tcy_tab_label'=>esc_html__('General', 'sharing-plus'),
							'tcy_tab_fields'=> array(
								'title'    => array(
									'tcy_widgets_name'          => 'title',
									'tcy_wraper_class'          => 'title',
									'tcy_widgets_title'         => esc_html__( 'Title', 'sharing-plus' ),
									'tcy_widgets_default'       => '',
									'tcy_widgets_field_type'    => 'text',
								),
								'accordion_settings'    => array(
									'tcy_widgets_name'          => 'accordion_settings',
									'tcy_wraper_class'          => 'accordion_settings',
									'tcy_widgets_field_type'    => 'accordion',
									'tcy_widgets_accordion' => array(
										'facebook'=>array(
											'tcy_accordion_title' => esc_html__('Facebook Settings', 'sharing-plus'),
											'tcy_accordion_fields' => array(
												'show_facebook'    => array(
													'tcy_widgets_name'          => 'show_facebook',
													'tcy_wraper_class'          => 'show-facebook',
													'tcy_widgets_title'         => esc_html__( 'Enable Facebook', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
												),
												'facebook_text'    => array(
													'tcy_widgets_name'          => 'facebook_text',
													'tcy_wraper_class'          => 'facebook-text',
													'tcy_widgets_title'         => esc_html__( 'Facebook button text', 'sharing-plus' ),
													'tcy_widgets_default'       => esc_html__('Follow us on Facebook', 'sharing-plus'),
													'tcy_widgets_field_type'    => 'text',
												),
												'facebook_id'    => array(
													'tcy_widgets_name'          => 'facebook_id',
													'tcy_wraper_class'          => 'facebook-id',
													'tcy_widgets_title'         => esc_html__( 'Facebook user id', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'facebook_show_counter'    => array(
													'tcy_widgets_name'          => 'facebook_show_counter',
													'tcy_wraper_class'          => 'facebook-show-counter',
													'tcy_widgets_title'         => esc_html__( 'Display facebook like counter', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
													'tcy_widget_relations'      => array(
														'0' => array(
															'hide_fields'   => array(
																'facebook-app-id', 
																'facebook-security-key',
																'facebook-access-token',
															),
														),
														'1'   => array(
															'show_fields'   => array(
																'facebook-app-id', 
																'facebook-security-key',
																'facebook-access-token',
															),
														),
													),
												),
												'facebook_app_id'    => array(
													'tcy_widgets_name'          => 'facebook_app_id',
													'tcy_wraper_class'          => 'facebook-app-id',
													'tcy_widgets_title'         => esc_html__( 'Facebook app id', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'facebook_security_key'    => array(
													'tcy_widgets_name'          => 'facebook_security_key',
													'tcy_wraper_class'          => 'facebook-security-key',
													'tcy_widgets_title'         => esc_html__( 'Facebook security key', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'facebook_access_token'    => array(
													'tcy_widgets_name'          => 'facebook_access_token',
													'tcy_wraper_class'          => 'facebook-access-token',
													'tcy_widgets_title'         => esc_html__( 'Facebook access token', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
													'tcy_widgets_description' => __('You can get <a href="javascript:void(0)" class="sharing-plus-fb-token">get  access token</a> by clicking <a href="javascript:void(0)" class="sharing-plus-fb-token">here</a>', 'sharing-plus'),
												),
											),
										),
										'twitter'=>array(
											'tcy_accordion_title' => esc_html__('Twitter Settings', 'sharing-plus'),
											'tcy_accordion_fields' => array(
												'show_twitter'    => array(
													'tcy_widgets_name'          => 'show_twitter',
													'tcy_wraper_class'          => 'show-twitter',
													'tcy_widgets_title'         => esc_html__( 'Enable Twitter', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
												),
												'twitter_text'    => array(
													'tcy_widgets_name'          => 'twitter_text',
													'tcy_wraper_class'          => 'twitter-text',
													'tcy_widgets_title'         => esc_html__( 'Twitter button text', 'sharing-plus' ),
													'tcy_widgets_default'       => esc_html__('Follow us on twitter', 'sharing-plus'),
													'tcy_widgets_field_type'    => 'text',
												),
												'twitter'    => array(
													'tcy_widgets_name'          => 'twitter',
													'tcy_wraper_class'          => 'twitter-handle',
													'tcy_widgets_title'         => esc_html__( 'Twitter handle', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'twitter_show_counter'    => array(
													'tcy_widgets_name'          => 'twitter_show_counter',
													'tcy_wraper_class'          => 'twitter-show-counter',
													'tcy_widgets_title'         => esc_html__( 'Display twitter follower counter', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
													'tcy_widget_relations'      => array(
														'0' => array(
															'hide_fields'   => array(
																'twitter-api-key', 
																'twitter-secret-key',
															),
														),
														'1'   => array(
															'show_fields'   => array(
																'twitter-api-key', 
																'twitter-secret-key',
															),
														),
													),
												),
												'twitter_api_key'    => array(
													'tcy_widgets_name'          => 'twitter_api_key',
													'tcy_wraper_class'          => 'twitter-api-key',
													'tcy_widgets_title'         => esc_html__( 'Consumer Key (Api key)', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'twitter_secret_key'    => array(
													'tcy_widgets_name'          => 'twitter_secret_key',
													'tcy_wraper_class'          => 'twitter-secret-key',
													'tcy_widgets_title'         => esc_html__( 'Consumer Secrect (Api Secret)', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
											),
										),
										'google_plus'=>array(
											'tcy_accordion_title' => esc_html__('Google Plus Settings', 'sharing-plus'),
											'tcy_accordion_fields' => array(
												'show_google_plus'    => array(
													'tcy_widgets_name'          => 'show_google_plus',
													'tcy_wraper_class'          => 'show-google-plus',
													'tcy_widgets_title'         => esc_html__( 'Enable Gogle Plus', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
												),
												'google_text'    => array(
													'tcy_widgets_name'          => 'google_text',
													'tcy_wraper_class'          => 'google-plus-text',
													'tcy_widgets_title'         => esc_html__( 'Google+ Button Text: ', 'sharing-plus' ),
													'tcy_widgets_default'       => esc_html__('Follow us on Google+', 'sharing-plus'),
													'tcy_widgets_field_type'    => 'text',
												),
												'google'    => array(
													'tcy_widgets_name'          => 'google',
													'tcy_wraper_class'          => 'twitter-user-id',
													'tcy_widgets_title'         => esc_html__( 'Google+ User ID', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'google_show_counter'    => array(
													'tcy_widgets_name'          => 'google_show_counter',
													'tcy_wraper_class'          => 'google-show-counter',
													'tcy_widgets_title'         => esc_html__( 'Display google plus follower counter', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
												),
											),
										),
										'youtube'=>array(
											'tcy_accordion_title' => esc_html__('Youtube Settings', 'sharing-plus'),
											'tcy_accordion_fields' => array(
												'show_youtube'    => array(
													'tcy_widgets_name'          => 'show_youtube',
													'tcy_wraper_class'          => 'show-google-plus',
													'tcy_widgets_title'         => esc_html__( 'Enable youtube', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
												),
												'youtube_text'    => array(
													'tcy_widgets_name'          => 'youtube_text',
													'tcy_wraper_class'          => 'youtube-text',
													'tcy_widgets_title'         => esc_html__( 'Youtube button text: ', 'sharing-plus' ),
													'tcy_widgets_default'       => esc_html__('Follow us on Google+', 'sharing-plus'),
													'tcy_widgets_field_type'    => 'text',
												),
												'youtube_type'    => array(
													'tcy_widgets_name'          => 'youtube_type',
													'tcy_wraper_class'          => 'youtube-type',
													'tcy_widgets_title'         => esc_html__( 'Google+ User ID', 'sharing-plus' ),
													'tcy_widgets_default'       => 'channel',
													'tcy_widgets_field_type'    => 'select',
													'tcy_widgets_field_options'=>sharing_plus_youtube_type(),
												),
												'youtube'    => array(
													'tcy_widgets_name'          => 'youtube',
													'tcy_wraper_class'          => 'youtube-chanel-or-id',
													'tcy_widgets_title'         => esc_html__( 'Youtube channel or ID', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'youtube_show_counter'    => array(
													'tcy_widgets_name'          => 'youtube_show_counter',
													'tcy_wraper_class'          => 'youtube-show-counter',
													'tcy_widgets_title'         => esc_html__( 'Display youtube subscribe counter', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
													
												),
											),
										),
										'pinterest'=>array(
											'tcy_accordion_title' => esc_html__('Pinterest Settings', 'sharing-plus'),
											'tcy_accordion_fields' => array(
												'show_pinterest'    => array(
													'tcy_widgets_name'          => 'show_pinterest',
													'tcy_wraper_class'          => 'show-pinterest',
													'tcy_widgets_title'         => esc_html__( 'Enable pinterest', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
												),
												'pinterest_text'    => array(
													'tcy_widgets_name'          => 'pinterest_text',
													'tcy_wraper_class'          => 'pinterest-text',
													'tcy_widgets_title'         => esc_html__( 'Pinterest button text', 'sharing-plus' ),
													'tcy_widgets_default'       => esc_html__('Follow us on Google+', 'sharing-plus'),
													'tcy_widgets_field_type'    => 'text',
												),
												'pinterest'    => array(
													'tcy_widgets_name'          => 'pinterest',
													'tcy_wraper_class'          => 'pinterest-username',
													'tcy_widgets_title'         => esc_html__( 'Pinterest user id', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'pinterest_show_counter'    => array(
													'tcy_widgets_name'          => 'pinterest_show_counter',
													'tcy_wraper_class'          => 'pinterest-show-counter',
													'tcy_widgets_title'         => esc_html__( 'Display pinterest follower counter', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
													'tcy_widget_relations'      => array(
														'0' => array(
															'hide_fields'   => array(
																'pinterest-api-key', 
															),
														),
														'1'   => array(
															'show_fields'   => array(
																'pinterest-api-key', 
															),
														),
													),
													
												),
												'pinterest_api_key'    => array(
													'tcy_widgets_name'          => 'pinterest_api_key',
													'tcy_wraper_class'          => 'pinterest-api-key',
													'tcy_widgets_title'         => esc_html__( 'Pinterest access token', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												
											),
										),
										'instagram'=>array(
											'tcy_accordion_title' => esc_html__('Instagram Settings', 'sharing-plus'),
											'tcy_accordion_fields' => array(
												'show_instagram'    => array(
													'tcy_widgets_name'          => 'show_instagram',
													'tcy_wraper_class'          => 'show-instagram',
													'tcy_widgets_title'         => esc_html__( 'Enable instagram', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
												),
												'instagram_text'    => array(
													'tcy_widgets_name'          => 'instagram_text',
													'tcy_wraper_class'          => 'instagram-text',
													'tcy_widgets_title'         => esc_html__( 'Instagram button text: ', 'sharing-plus' ),
													'tcy_widgets_default'       => esc_html__('Follow us on Google+', 'sharing-plus'),
													'tcy_widgets_field_type'    => 'text',
												),
												'instagram'    => array(
													'tcy_widgets_name'          => 'instagram',
													'tcy_wraper_class'          => 'instagram-username',
													'tcy_widgets_title'         => esc_html__( 'Instagram User Name', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
												'instagram_show_counter'    => array(
													'tcy_widgets_name'          => 'instagram_show_counter',
													'tcy_wraper_class'          => 'instagram-show-counter',
													'tcy_widgets_title'         => esc_html__( 'Display instagram follower counter', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
													
												),
											),
										),
										'whatsapp'=>array(
											'tcy_accordion_title' => esc_html__('WhatsApp Settings', 'sharing-plus'),
											'tcy_accordion_fields' => array(
												'show_whatsapp'    => array(
													'tcy_widgets_name'          => 'show_whatsapp',
													'tcy_wraper_class'          => 'show-whatsapp',
													'tcy_widgets_title'         => esc_html__( 'Enable whatsapp', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'checkbox',
												),
												'whatsapp_text'    => array(
													'tcy_widgets_name'          => 'whatsapp_text',
													'tcy_wraper_class'          => 'whatsapp-text',
													'tcy_widgets_title'         => esc_html__( 'WhatsApp button text', 'sharing-plus' ),
													'tcy_widgets_default'       => esc_html__('Follow us on Whatsapp', 'sharing-plus'),
													'tcy_widgets_field_type'    => 'text',
												),
												'whatsapp'    => array(
													'tcy_widgets_name'          => 'whatsapp',
													'tcy_wraper_class'          => 'whatsapp-username',
													'tcy_widgets_title'         => esc_html__( 'Contact us on WhatsApp', 'sharing-plus' ),
													'tcy_widgets_default'       => '',
													'tcy_widgets_field_type'    => 'text',
												),
											),
										),
									),
								),
							),
						),
					),
				),
			);
            
            $widget_fields_key = $this->id_base.'_fields';
            $widgets_fields = apply_filters( $widget_fields_key, $fields );
            return $widgets_fields;

		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		function widget( $args, $instance ) {
			extract( $args );
			$display = 1;
			$title = isset($instance['title']) ? esc_html($instance['title']) : '';
			$widget_title           = apply_filters( 'widget_title', $title, $instance );

			$show_facebook          = isset($instance['show_facebook']) ? absint($instance['show_facebook']) : 0;
			$show_twitter           = isset($instance['show_twitter']) ? absint($instance['show_twitter']) : 0;
			$show_google_plus       = isset($instance['show_google_plus']) ? absint($instance['show_google_plus']) : 0;
			$show_youtube           = isset($instance['show_youtube']) ? absint($instance['show_youtube']) : 0;
			$show_pinterest         = isset($instance['show_pinterest']) ? absint($instance['show_pinterest']) : 0;
			$show_instagram         = isset($instance['show_instagram']) ? absint($instance['show_instagram']) : 0;
			$show_whatsapp          = isset($instance['show_whatsapp']) ? absint($instance['show_whatsapp']) : 0;

			$facebook_id            = isset($instance['facebook_id']) ? esc_html($instance['facebook_id']) : '';
			$facebook_show_counter  = isset($instance['facebook_show_counter']) ? esc_html($instance['facebook_show_counter']) : '';
			$facebook_text          = isset($instance['facebook_text']) ? esc_html($instance['facebook_text']) : '';
			$facebook_access_token  = isset($instance['facebook_access_token']) ? esc_html($instance['facebook_access_token']) : '';

			$twitter_id             = isset($instance['twitter']) ? esc_html($instance['twitter']) : '';
			$twitter_show_counter   = isset($instance['twitter_show_counter']) ? esc_html($instance['twitter_show_counter']) : '';
			$twitter_text           = isset($instance['twitter_text']) ? esc_html($instance['twitter_text']) : '';
			$twitter_api_key        = isset($instance['twitter_api_key']) ? esc_html($instance['twitter_api_key']) : '';
			$twitter_secret_key     = isset($instance['twitter_secret_key']) ? esc_html($instance['twitter_secret_key']) : '';

			$google_id              = isset($instance['google']) ? esc_html($instance['google']) : '';
			$google_show_counter    = isset($instance['google_show_counter']) ? esc_html($instance['google_show_counter']) : '';
			$google_text            = isset($instance['google_text']) ? esc_html($instance['google_text']) : '';

			$youtube_id             = isset($instance['youtube']) ? esc_html($instance['youtube']) : '';
			$youtube_show_counter   = isset($instance['youtube_show_counter']) ? esc_html($instance['youtube_show_counter']) : '';
			$youtube_text           = isset($instance['youtube_text']) ? esc_html($instance['youtube_text']) : '';
			$youtube_type           = isset($instance['youtube_type']) ? esc_html($instance['youtube_type']) : '';

			$pinterest_id           = isset($instance['pinterest']) ? esc_html($instance['pinterest']) : '';
			$pinterest_show_counter = isset($instance['pinterest_show_counter']) ? esc_html($instance['pinterest_show_counter']) : '';
			$pinterest_api_key      = isset($instance['pinterest_api_key']) ? esc_html($instance['pinterest_api_key']) : '';
			$pinterest_text         = isset($instance['pinterest_text']) ? esc_html($instance['pinterest_text']) : '';

			$instagram_id           = isset($instance['instagram']) ? esc_html($instance['instagram']) : '';
	 		$instagram_show_counter = isset($instance['instagram_show_counter']) ? esc_html($instance['instagram_show_counter']) : '';
	 		$instagram_text         = isset($instance['instagram_text']) ? esc_html($instance['instagram_text']) : '';

	 		$whatsapp               = isset($instance['whatsapp']) ? esc_html($instance['whatsapp']) : '';
	 		$whatsapp_text          = isset($instance['whatsapp_text']) ? esc_html($instance['whatsapp_text']) : '';

			$fb_likes               = $this->get_facebook_likes_count( $facebook_id, $facebook_access_token, $facebook_show_counter );
			$twitter_follower       = $this->get_twitter_followers( $twitter_id, $twitter_api_key, $twitter_secret_key, $twitter_show_counter );
			$google_follower        = $this->get_google_plus_follower( $google_id, $google_show_counter );
			$youtube_subscriber     = $this->get_youtube_subscriber( $youtube_id, $youtube_show_counter, $youtube_type );
			$pinterest_follower     = $this->get_pinterest_followers( $pinterest_api_key, $pinterest_show_counter );
			$instagram_follower     = $this->get_instagram_id_followers( $instagram_id, $instagram_show_counter );
			echo $before_widget;
			include SHARING_PLUS_PLUGIN_DIR . 'inc/widgets/templates/tcy-follower-display.php';
			echo $after_widget;
		}



		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {

			// delete transiant wheb user update widget settings.
			delete_transient( 'sharing_plus_follow_facebook_counter' );
			delete_transient( 'sharing_plus_follow_twitter_counter' );
			delete_transient( 'sharing_plus_follow_google_counter' );
			delete_transient( 'sharing_plus_follow_youtube_counter' );
			delete_transient( 'sharing_plus_follow_pinterest_counter' );
			delete_transient( 'sharing_plus_follow_instagram_counter' );

			return parent::update($new_instance, $old_instance);
			
		}

		/**
		 * passing facebook and access token return facebook like counter
		 *
		 * @since 1.0.0
		 *
		 * @param $facebook_id
		 * @param $access_token
		 *
		 * @return int
		 */
		function get_facebook_likes_count( $facebook_id, $access_token, $show_counter ) {

			if ( $show_counter ) {
				if( '' == $facebook_id ){
					return 0;
				}

				if ( false === get_transient( 'sharing_plus_follow_facebook_counter' ) ) {
					$json_feed_url = "https://graph.facebook.com/$facebook_id/?fields=likes,fan_count&access_token=$access_token";

					$args      = array( 
						'httpversion' => '1.1',
					);
					$json_feed = wp_remote_get( $json_feed_url, $args );

					if ( is_wp_error( $json_feed ) || 200 !== wp_remote_retrieve_response_code( $json_feed ) ) {
						return 0;
					}

					$result  = json_decode( wp_remote_retrieve_body( $json_feed ) );
					$counter   = ( isset( $result->fan_count ) ? $result->fan_count : 0 );
					$counter   = $this->format_number( $counter );

					if ( ! empty( $counter ) ) {
						set_transient( 'sharing_plus_follow_facebook_counter', $counter, $this->cache_time );
					}

					return $counter;
				} else {
					return get_transient( 'sharing_plus_follow_facebook_counter' );
				}
			}
		}

		/**
		 * Pass twitter user name and api key return twitter follower
		 *
		 * @since 1.0.0
		 *
		 * @param $twitter_handle
		 * @param $api_key
		 * @param $secret_key
		 *
		 * @return mixed|void
		 */
		function get_twitter_followers( $twitter_handle, $api_key, $secret_key, $show_count ) {
			// some variables
			$consumerKey    = $api_key;
			$consumerSecret = $secret_key;
			$token          = get_option( 'sharing_plus_follow_twitter_token' );

			// get follower count from cache
			$numberOfFollowers = get_transient( 'sharing_plus_follow_twitter_counter' );

			if ( $show_count ) {

				if( '' == $twitter_handle ){
					return 0;
				}
				// cache version does not exist or expired
				if ( false == get_transient( 'sharing_plus_follow_twitter_counter' ) ) {

					// getting new auth bearer only if we don't have one
					if ( ! $token ) {
						// preparing credentials
						$credentials = $consumerKey . ':' . $consumerSecret;
						$toSend      = base64_encode( $credentials );

						$args = array(
							'method'      => 'POST',
							'httpversion' => '1.1',
							'blocking'    => true,
							'headers'     => array(
								'Authorization' => 'Basic ' . $toSend,
								'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
							),
							'body'        => array( 'grant_type' => 'client_credentials' ),
						);

						add_filter( 'https_ssl_verify', '__return_false' );
						$response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );

						$keys = json_decode( wp_remote_retrieve_body( $response ) );

						if ( $keys && isset( $keys->access_token ) ) {
							// saving token to wp_options table.
							update_option( 'sharing_plus_follow_twitter_token', $keys->access_token );
							$token = $keys->access_token;
						}
					}

					// we have bearer token wether we obtained it from API or from options.
					$args = array(
						'httpversion' => '1.1',
						'blocking'    => true,
						'headers'     => array(
							'Authorization' => "Bearer $token",
						),
					);

					add_filter( 'https_ssl_verify', '__return_false' );
					$api_url   = "https://api.twitter.com/1.1/users/show.json?screen_name=$twitter_handle";
					$response  = wp_remote_get( $api_url, $args );
					if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
						return 0;
					}

					$followers = json_decode( wp_remote_retrieve_body( $response ) );
					$counter   = isset( $followers->followers_count ) ? $followers->followers_count : 0;
					$counter   = $this->format_number( $counter );
					// cache for an hour
					if ( ! empty( $counter ) ) {
						set_transient( 'sharing_plus_follow_twitter_counter', $counter, $this->cache_time );
					}

					return $counter;
				}

				return get_transient( 'sharing_plus_follow_twitter_counter' );

			}
		}

		/**
		 * passing the google plus username  return google+ follower
		 *
		 * @since 1.0.0
		 *
		 * @param $google_iD
		 *
		 * @return int
		 */
		function get_google_plus_follower( $google_id, $show_counter ) {


			if ( $show_counter ) {
				if( '' == $google_id ){
					return 0;
				}

				if( '' == $google_id ){
					return 0;
				}

				if ( false === get_transient( 'sharing_plus_follow_google_counter' )  ) {
					$json_feed_url = 'https://www.googleapis.com/plus/v1/people/' . $google_id . '?fields=circledByCount%2CplusOneCount&key=' . $this->api_key;
					$args          = array( 'httpversion' => '1.1' );
					$json_feed     = wp_remote_get( $json_feed_url, $args );
					if ( is_wp_error( $json_feed ) || 200 !== wp_remote_retrieve_response_code( $json_feed ) ) {
						return 0;
					}

					$result  = json_decode( wp_remote_retrieve_body( $json_feed ) );

					$counter = isset( $result->circledByCount ) ? $result->circledByCount : 0;

					$counter = $this->format_number( $counter );
					if ( ! empty( $counter ) ) {

						set_transient( 'sharing_plus_follow_google_counter', $counter, $this->cache_time );
					}

					return $counter;
				} else {

					return get_transient( 'sharing_plus_follow_google_counter' );
				}
			}
		}

		/**
		 * passing youtube channel id and access token return the channel subscriber counter
		 * @since 1.0.0
		 *
		 * @param $channel_id
		 * @param $access_token
		 *
		 * @return int
		 */
		function get_youtube_subscriber( $channel_id, $show_counter, $youtube_type ) {

			if ( $show_counter ) {

				if( '' == $channel_id ){
					return 0;
				}
				if ( false === get_transient( 'sharing_plus_follow_youtube_counter' ) ) {

					// Check if username of channel id.
					$_type = $youtube_type == 'username' ? 'forUsername' : 'id';

					$json_feed_url = 'https://www.googleapis.com/youtube/v3/channels?key=' . $this->api_key . '&part=contentDetails,statistics&'. $_type . '=' . $channel_id;
					$args  = array(
												'httpversion' => '1.1',
												'timeout'     => 15
											);
					$json_feed     = wp_remote_get( $json_feed_url, $args );
					if ( is_wp_error( $json_feed ) || 200 !== wp_remote_retrieve_response_code( $json_feed ) ) {
						return 0;
					}
					$result  = json_decode( wp_remote_retrieve_body( $json_feed ) );
					$counter       = isset( $result->items[0]->statistics->subscriberCount ) ? $result->items[0]->statistics->subscriberCount : 0;
					$counter       = $this->format_number( $counter );

					if ( ! empty( $counter ) ) {

						set_transient( 'sharing_plus_follow_youtube_counter', $counter, $this->cache_time );
					}

					return $counter;
				} else {

					return get_transient( 'sharing_plus_follow_youtube_counter' );
				}
			}

		}

		/**
		 * passing pinterest access_token  for getting pinterest follower counter
		 * @since 1.0.0
		 * @param $access_token
		 * @param $show_counter
		 *
		 * @return int|string
		 */
		function get_pinterest_followers(  $access_token, $show_counter ) {

			if ( $show_counter ) {
				if( '' == $access_token ){
					return 0;
				}

				if ( false === get_transient( 'sharing_plus_follow_pinterest_counter' ) ) {
					$json_feed_url = 'https://api.pinterest.com/v1/me/followers/?access_token=' . $access_token;
					$args          = array( 'httpversion' => '1.1' );
					$json_feed     = wp_remote_get( $json_feed_url, $args );
					//$result        = json_decode( $json_feed['body'] );
					if ( is_wp_error( $json_feed ) || 200 !== wp_remote_retrieve_response_code( $json_feed ) ) {
						return 0;
					}
					$result  = json_decode( wp_remote_retrieve_body( $json_feed ),true );
					$counter = count($result['data'] );
					$counter = $this->format_number( $counter );

					if ( ! empty( $counter ) ) {

						set_transient( 'sharing_plus_follow_pinterest_counter', $counter, $this->cache_time );
					}

					return $counter;
				} else {

					return get_transient( 'sharing_plus_follow_pinterest_counter' );
				}
			}

		}

		/**
		* Passing instagram access token for getting instagram follower
		* @since 2.0.10
		* @param $instagram_id
		* @param $show_counter
		*
		* @return int|string( insta follower )
		*/
		function  get_instagram_id_followers( $instagram_id, $show_counter ){

			if ( $show_counter ) {
				if( '' == $instagram_id ){
					return 0;
				}

				if ( false === get_transient( 'sharing_plus_follow_instagram_counter' ) ) {
					$json_feed_url = "https://www.instagram.com/$instagram_id/?__a=1";

					$args      = array( 'httpversion' => '1.1' );
					$json_feed = wp_remote_get( $json_feed_url, $args );

					if ( is_wp_error( $json_feed ) || 200 !== wp_remote_retrieve_response_code( $json_feed ) ) {
						return 0;
					}
					$result  = json_decode( wp_remote_retrieve_body( $json_feed ) );
					$counter = isset( $result->user->followed_by->count ) ? $result->user->followed_by->count : 0;
					$counter = $this->format_number( $counter );

					if ( ! empty( $counter ) ) {
						set_transient( 'sharing_plus_follow_instagram_counter', $counter, $this->cache_time );
					}

					return $counter;
				} else {
					return get_transient( 'sharing_plus_follow_instagram_counter' );
				}
			}
		}

		/**
		 * Format the (int)number into easy readable format like 1K, 1M
		 * @since 1.0.0
		 *
		 * @param $value
		 *
		 * @return string
		 */
		function format_number( $value ) {
			if ( $value > 999 && $value <= 999999 ) {
				return $result = floor( $value / 1000 ) . 'K';
			} elseif ( $value > 999999 ) {
				return $result = floor( $value / 1000000 ) . '   M';
			} else {
				return $result = $value;
			}
		}

	} // end class Sharing_Plus_Follower_Widget
endif;
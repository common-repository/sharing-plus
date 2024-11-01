<?php
/**
 * Sharing Plus Inialize called on wordpress init
 * @since 1.0.0
 * @param null
 * @return null;
 */


/**
 * Sharing Plus sharing_plus_metabox_spread_the_words
 * @since 1.0.0
 * @param null
 * @return null;
 */
if(!function_exists('sharing_plus_metabox_spread_the_words')):
	function sharing_plus_metabox_spread_the_words(){
		?>
		<div id="spreadthewords" class="postbox">
			<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text"><?php esc_html_e('Toggle panel: SHARING_PLUS Settings', 'sharing-plus' ); ?></span><span class="toggle-indicator" aria-hidden="true"></span></button>
			<h2 class="hndle"><?php esc_html_e( 'Help us by sharing this plugin.', 'sharing-plus' ) ?></h2>
			<div class=" inside">
				<ul class="sharing_plus_social_links">
					<li>
						<a href="http://twitter.com/share?text=Check out this (FREE) Amazing Social Share Plugin for WordPress&amp;url=https://wordpress.org/plugins/sharing-plus/" data-count="none" class="button twitter" target="_blank" title="Post to Twitter Now"><?php esc_html_e( 'Share on Twitter', 'sharing-plus' ) ?><span class="dashicons dashicons-twitter"></span></a>
					</li>
					<li>
						<a href="https://www.facebook.com/sharer/sharer.php?u=https://wordpress.org/plugins/sharing-plus/" class="button facebook" target="_blank" title="Check out this (FREE) Amazing Social Share Plugin for WordPress"><?php esc_html_e( 'Share on Facebook', 'sharing-plus' ) ?><span class="dashicons dashicons-facebook"></span>
						</a>
					</li>
					<li>
						<a href="https://wordpress.org/plugins/sharing-plus/?filter=5" class="button wordpress" target="_blank" title="Rate on WordPress.org"><?php esc_html_e( 'Rate on WordPress.org', 'sharing-plus' ) ?><span class="dashicons dashicons-wordpress"></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php
	}
endif;
add_action('sharing_plus_settings_innersidebar_metabox', 'sharing_plus_metabox_spread_the_words', 10);

/**
 * Sharing Plus sharing_plus_settings_wraper_sidebar
 * @since 1.0.0
 * @param null
 * @return null;
 */
if(!function_exists('sharing_plus_settings_wraper_sidebar')):
	function sharing_plus_settings_wraper_sidebar(){
		?>
		<div id="postbox-container-1" class="postbox-container">
			<div id="side-shortables" class="meta-box-sortables">
				<?php
                /**
                 * sharing_plus_settings_innersidebar_metabox hook
                 * @since 1.0.0
                 *
                 * @hooked sharing_plus_metabox_spread_the_words -  10
                 */
                do_action('sharing_plus_settings_innersidebar_metabox');
                ?>
            </div>
        </div>
        <?php
    }
endif;
add_action('sharing_plus_settings_sidebar', 'sharing_plus_settings_wraper_sidebar', 10);


/**
 * Sharing Plus sharing_plus_general_settings_content
 * @since 1.0.0
 * @param null
 * @return null;
 */
if(!function_exists('sharing_plus_general_settings_wraper_content')):
	function sharing_plus_general_settings_wraper_content($structure){
		?>
		<div id="post-body-content">
			<div id="normal-sortables" class="meta-box-sortables">
				<?php
				$structure->do_settings_sections( 'sharing_plus_networks' );
				settings_fields( 'sharing_plus_networks' );
				submit_button();
				?>
			</div>
		</div>
        <?php
    }
endif;
add_action('sharing_plus_general_settings_content', 'sharing_plus_general_settings_wraper_content', 10, 1);

/**
 * Sharing Plus sharing_plus_advanced_settings_content
 * @since 1.0.0
 * @param $structure Object Of structure class
 * @return null;
 */
if(!function_exists('sharing_plus_advanced_settings_wraper_content')):
	function sharing_plus_advanced_settings_wraper_content($structure){
		?>
		<div id="post-body-content">
			<div id="normal-sortables" class="meta-box-sortables">
				<?php
				$structure->do_settings_sections( 'sharing_plus_advanced' );
                settings_fields( 'sharing_plus_advanced' );
                submit_button();
				?>
			</div>
		</div>
        <?php
    }
endif;
add_action('sharing_plus_advanced_settings_content', 'sharing_plus_advanced_settings_wraper_content', 10, 1);
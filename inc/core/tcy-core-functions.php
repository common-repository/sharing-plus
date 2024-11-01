<?php
/**
 * Sharing Plus core functions
 *
 * @package Theme Century
 * @subpackage Sharing Plus
 * @since 1.0.0
 *
 */

/**
 * Sharing plus file directory
 *
 * @package Theme Century
 * @subpackage Sharing Plus
 * @since 1.0.0
 *
 * @param string $file_path, path from the plugin
 * @return string full path of file inside plugin
 *
 */

if( !function_exists('sharing_plus_file_directory') ){

    function sharing_plus_file_directory( $file_path ){

        $path = trailingslashit( SHARING_PLUS_PLUGIN_DIR ) . $file_path;
        if(function_exists('wp_normalize_path')){
            $path = wp_normalize_path( $path );
        }       
        return $path;

    }
}

/**
 * Sharing plus file directory
 *
 * @package Theme Century
 * @subpackage Sharing Plus
 * @since 1.0.0
 *
 * @param string $extend_url @default none
 * @return url full url of file inside plugin
 *
 */

if( !function_exists('sharing_plus_plugin_url') ){

    function sharing_plus_plugin_url( $extend_url = '' ){

        $sharing_plus_url = SHARING_PLUS_PLUGIN_URL.$extend_url;
        $file_url = esc_url_raw( $sharing_plus_url );
        return $file_url;

    }
}

/**
 * Youtube type
 *
 * @package Theme Century
 * @subpackage Sharing Plus
 * @since 1.0.0
 *
 * @return array $youtube_type
 *
 */

if( !function_exists('sharing_plus_youtube_type') ){

    function sharing_plus_youtube_type(){

    	$youtube_type = array(
    		'channel'=>esc_html__('Channel', 'sharing-plus' ),
    		'username'=>esc_html__('Username', 'sharing-plus' ),
    	);
        return $youtube_type;

    }
}
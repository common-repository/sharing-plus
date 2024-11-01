<?php
if ( empty( $athm_field_value ) ) {
	$athm_field_value = $tcy_widgets_default;
}
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
?>
<p class="tcy-widget-field-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>">
		<?php echo esc_html( $tcy_widgets_title ); ?>: 
	</label>
	<?php
	/* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
	$args = array(
		'selected'              => $athm_field_value,
		'name'                  => esc_attr( $instance->get_field_name( $tcy_widgets_name ) ),
		'id'                    => esc_attr( $instance->get_field_id( $tcy_widgets_name ) ),
		'class'                 => 'widefat',
		'show_option_none'      => esc_html__('Select Page','sharing-plus'),
		'option_none_value'     => 0 // string
	);
	wp_dropdown_pages( $args );
	if($athm_field_value){
		/*?>
		<a href="<?php echo get_edit_post_link($athm_field_value ); ?>" target="_blank"><?php esc_html_e('Edit Page', 'sharing-plus') ?></a>
		<?php */
	}
	if ( isset( $tcy_widgets_description ) ) { 
		?>
		<br/>
		<small><?php echo esc_html( $tcy_widgets_description ); ?></small>
		<?php 
	} 
	?>
</p>

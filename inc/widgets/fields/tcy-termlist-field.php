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
		'show_option_none'   => false,
		'orderby'            => 'name',
		'order'              => 'asc',
		'show_count'         => 1,
		'hide_empty'         => 0,
		'echo'               => 1,
		'selected'           => $athm_field_value,
		'hierarchical'       => 1,
		'name'               => esc_attr( $instance->get_field_name( $tcy_widgets_name ) ),
		'id'                 => esc_attr( $instance->get_field_id( $tcy_widgets_name ) ),
		'class'              => 'widefat',
		'taxonomy'           => $tcy_taxonomy_type,
		'hide_if_empty'      => false,
	);
	wp_dropdown_categories( $args );

	if ( isset( $tcy_widgets_description ) ) { 
		?>
		<br/>
		<small><?php echo esc_html( $tcy_widgets_description ); ?></small>
		<?php 
	} 
	?>

</p>
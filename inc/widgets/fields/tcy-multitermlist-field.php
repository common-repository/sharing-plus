<?php
if ( empty( $athm_field_value ) ) {
	$athm_field_value = $tcy_widgets_default;
}
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
?>
<div class="tcy-widget-field-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>">
		<?php echo esc_html( $tcy_widgets_title ); ?>: 
	</label>
	<ul class="te-multiple-checkbox">
		<?php
		/* see more here https://developer.wordpress.org/reference/functions/get_terms/*/
		$args = array(
			'taxonomy'     => $tcy_taxonomy_type,
			'hide_empty'   => false,
			'number'      => 999,
		);
		$all_terms = get_terms($args);
		if( $all_terms ){
			foreach( $all_terms as $single_term ){
				$tcy_term_id = $single_term->term_id;
				$tcy_term_name = $single_term->name;
				?>
				<li>
					<input 
					id="<?php echo esc_attr( $instance->get_field_id($tcy_widgets_name) ).'_'.$tcy_taxonomy_type.'_'.$tcy_term_id; ?>" 
					name="<?php echo esc_attr( $instance->get_field_name($tcy_widgets_name).'[]' ); ?>" 
					type="checkbox" 
					value="<?php echo $tcy_term_id; ?>" 
					<?php checked(in_array($tcy_term_id, (array)$athm_field_value)); ?> 
					/>
					<label for="<?php echo esc_attr( $instance->get_field_id($tcy_widgets_name) ).'_'.$tcy_taxonomy_type.'_'.$tcy_term_id; ?>"><?php echo esc_html( $tcy_term_name ).' ('.$single_term->count.')'; ?></label>
				</li>
				<?php
			}
		}
		if ( isset( $tcy_widgets_description ) ) { 
			?>
			<br/>
			<small><?php echo esc_html( $tcy_widgets_description ); ?></small>
			<?php 
		}
		?>
	</ul>
</div>
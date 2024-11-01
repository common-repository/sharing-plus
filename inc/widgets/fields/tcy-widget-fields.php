<?php
/**
 * Define custom fields for widgets
 *
 * @package Theme Egg
 * @subpackage MultiCommerce
 * @since 1.0.0
 */

function tcy_widgets_show_widget_field( $instance = '', $widget_field = '', $athm_field_value = '' ) {

	extract( $widget_field );
	switch ( $tcy_widgets_field_type ) {

		// Standard text field
		case 'text':
			require sharing_plus_file_directory('inc/widgets/fields/tcy-text-field.php');
			break;
		// Standard text field
		case 'color':
			require sharing_plus_file_directory('inc/widgets/fields/tcy-color-field.php');
			break;
		// Standard url field
		case 'url' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-url-field.php');
			break;
		// Checkbox field
		case 'checkbox' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-checkbox-field.php');
			break;

		// Textarea field
		case 'textarea' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-textarea-field.php');
			break;
		// Radio fields
		case 'radio' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-radio-field.php');
			break;
		// Radio fields
		case 'icon' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-icon-field.php');
			break;
		// Select field
		case 'select' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-select-field.php');
			break;
		case 'pagelist' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-pagelist-field.php');
			break;
		case 'number' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-number-field.php');
			break;
		case 'widget_section_header':
			?>
			<span class="section-header"><?php echo esc_html( $tcy_widgets_title ); ?></span>
			<?php
			break;
		case 'widget_layout_image':
			?>
			<div class="layout-image-wrapper">
				<span class="image-title"><?php echo esc_html( $tcy_widgets_title ); ?></span>
				<img src="<?php echo esc_url( $tcy_widgets_layout_img ); ?>"
				     title="<?php echo esc_attr__( 'Widget Layout', 'sharing-plus' ); ?>"/>
			</div>
			<?php
			break;
		case 'repeater':
			require sharing_plus_file_directory('inc/widgets/fields/tcy-repeater-field.php');
			break;

		case 'accordion':
			require sharing_plus_file_directory('inc/widgets/fields/tcy-accordion-field.php');
			break;

		case 'tabgroup':
			require sharing_plus_file_directory('inc/widgets/fields/tcy-tabgroup-field.php');
			break;

		case 'termlist':
			require sharing_plus_file_directory('inc/widgets/fields/tcy-termlist-field.php');
			break;
			
		case 'multitermlist':
			require sharing_plus_file_directory('inc/widgets/fields/tcy-multitermlist-field.php');
			break;

		case 'upload' :
			require sharing_plus_file_directory('inc/widgets/fields/tcy-upload-field.php');
			break;
		default:
			?>
			<p>Field type <?php echo esc_attr($tcy_widgets_field_type); ?> Not found.</p>
			<?php
			break;
	}
}

function tcy_widgets_updated_field_value( $widget_field, $new_field_value ){

	$tcy_widgets_field_type = '';

	extract( $widget_field );

	switch ( $tcy_widgets_field_type ) {
		// Allow only integers in number fields
		case 'number':
			return multicommerce_sanitize_number( $new_field_value, $widget_field );
			break;
		// Allow some tags in textareas
		case 'textarea':
			$tcy_widgets_allowed_tags = array(
				'p' => array(),
				'em' => array(),
				'strong' => array(),
				'a' => array(
					'href' => array(),
				),
			);
			return wp_kses( $new_field_value, $tcy_widgets_allowed_tags );
			break;
		// No allowed tags for all other fields
		case 'url':
			return esc_url_raw( $new_field_value );
			break;
		case 'multitermlist':
			$multi_term_list = array();
			if(is_array($new_field_value)){
				foreach($new_field_value as $key=>$value){
					$multi_term_list[] = absint($value);
				}
			}
			return $multi_term_list;
			break;
		case 'accordion':
			$dropdown_accordions = array();
			if(is_array($new_field_value)){
				foreach($new_field_value as $key=>$value){
					$dropdown_accordions[] = esc_attr($value);
				}
			}
			return $dropdown_accordions;
			break;
		case 'repeater':
			//return $new_field_value;
			$sanitize_repeater_value = array();
			if(count($new_field_value) && is_array($new_field_value)){
				foreach($new_field_value as $index=>$repeater_row){
					$repeater_fields = $widget_field['repeater'];
					foreach($repeater_fields as $fields_key=>$fields_data){
						$repeater_field_type = isset($fields_data['tcy_repeater_field_type']) ? $fields_data['tcy_repeater_field_type'] : '';
						$repeater_field_name = isset($fields_data['tcy_repeater_name']) ? $fields_data['tcy_repeater_name'] : '';
						$repeater_field_value = isset($repeater_row[$repeater_field_name]) ? $repeater_row[$repeater_field_name] : '';
						switch($repeater_field_type){
							case 'url':
								$sanitize_repeater_value[$index][$repeater_field_name] = esc_url_raw( $repeater_field_value  );
							case 'upload':
								$sanitize_repeater_value[$index][$repeater_field_name] = esc_url_raw( $repeater_field_value  );
							default:
								$sanitize_repeater_value[$index][$repeater_field_name] = wp_kses_post( sanitize_text_field( $repeater_field_value  ) );
								break;
						}
					}
				}
			}
			return $sanitize_repeater_value;
			break;
		default:
			return wp_kses_post( sanitize_text_field( $new_field_value ) );

	}
}
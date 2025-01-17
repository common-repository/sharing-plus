<?php
    $tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
?>
<div class="tcy-widget-field-wrapper te-icons-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
    <div class="icon-preview">
        <?php if( !empty( $athm_field_value ) ) { echo '<i class="fa '. esc_attr( $athm_field_value ).'"></i>'; } ?>
    </div>
    <div class="icon-toggle">
        <?php echo ( empty( $athm_field_value )? esc_html__('Add Icon','sharing-plus'): esc_html__('Edit Icon','sharing-plus') ); ?>
        <span class="dashicons dashicons-arrow-down"></span>
    </div>
    <div class="icons-list-wrapper hidden">
        <input class="icon-search widefat" type="text" placeholder="<?php esc_attr_e('Search Icon','sharing-plus')?>">
        <?php
        $fa_icon_list_array = multicommerce_icons_array();
        foreach ( $fa_icon_list_array as $single_icon ) {
            if( $athm_field_value == $single_icon ) {
                echo '<span class="single-icon selected"><i class="fa '. esc_attr( $single_icon ) .'"></i></span>';
            } else {
                echo '<span class="single-icon"><i class="fa '. esc_attr( $single_icon ) .'"></i></span>';
            }
        }
        ?>
    </div>
    <input class="widefat te-icon-value" id="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>" type="hidden" name="<?php echo esc_attr( $instance->get_field_name( $tcy_widgets_name ) ); ?>" value="<?php echo esc_attr( $athm_field_value ); ?>" placeholder="fa-desktop"/>
</div>
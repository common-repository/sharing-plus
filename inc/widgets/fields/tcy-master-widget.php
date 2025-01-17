<?php
/**
 * Class for adding Social Section Widget
 *
 * @package Theme Century
 * @subpackage Sharing Plus
 * @since 1.0.0
 */
if ( ! class_exists( 'Sharing_Plus_Master_Widget' ) ) {

    abstract class Sharing_Plus_Master_Widget extends WP_Widget {

        /**
         * Helper function that holds widget fields
         * Array is used in update and form functions
         */
        public function widget_fields(){

            $fields = array(
                'title'    => array(
                    'tcy_widgets_name'          => 'title',
                    'tcy_widgets_title'         => esc_html__( 'Title', 'sharing-plus' ),
                    'tcy_widgets_default'       => '',
                    'tcy_widgets_field_type'    => 'text',
                ),
            );

            return $fields;

        }

        /*Widget Backend*/
        public function form( $instance ) {

            $widget_fields = $this->widget_fields();
            
            // Loop through fields
            foreach ( $widget_fields as $widget_field ) {

                // Make array elements available as variables
                extract( $widget_field );
                $tcy_widgets_field_value = isset( $instance[ $tcy_widgets_name ] ) ? $instance[ $tcy_widgets_name ] : '';
                tcy_widgets_show_widget_field( $this, $widget_field, $tcy_widgets_field_value );
            }
            
        }


        /**
         * Function to Updating Tab widget
         *
         * @access public
         * @since 1.0.2
         *
         * @param array $tcy_widgets_tabs tab fields array value
         * @param array $new_instance new arrays value
         * @param array $instance updated widget value
         * @return $instance
         *
         */
        public function update_tabgroup($tcy_widgets_tabs, $new_instance, $instance){
            $tcy_widgets_tabs = (array)$tcy_widgets_tabs;
            foreach ( $tcy_widgets_tabs as $tab_slug=>$tab_details ){
                $widget_fields = $tab_details['tcy_tab_fields'];
                foreach ( $widget_fields as $widget_field ) {
                    extract( $widget_field );
                                // Use helper function to get updated field values
                    $tcy_widget_field_value = isset($new_instance[$tcy_widgets_name]) ? $new_instance[$tcy_widgets_name] : '';
                    $instance[$tcy_widgets_name] = tcy_widgets_updated_field_value( $widget_field, $tcy_widget_field_value );
                    $instance = $this->field_wise_update($widget_field, $new_instance, $instance);
                }
            }
            return $instance;
        }

        /**
         * Function to Updating Accordion widget
         *
         * @access public
         * @since 1.0.2
         *
         * @param array $tcy_widgets_accordion tab fields array value
         * @param array $new_instance new arrays value
         * @param array $instance updated widget value
         * @return $instance
         *
         */
        public function update_accordion($tcy_widgets_accordion, $new_instance, $instance){
            $tcy_widgets_accordion = (array)$tcy_widgets_accordion ;
            foreach ( $tcy_widgets_accordion as $accordion_slug=>$accordion_details ){
                $widget_fields = $accordion_details['tcy_accordion_fields'];
                foreach ( $widget_fields as $widget_field ) {
                    extract( $widget_field );
                    // Use helper function to get updated field values
                    $tcy_widget_field_value = isset($new_instance[$tcy_widgets_name]) ? $new_instance[$tcy_widgets_name] : '';
                    $instance[$tcy_widgets_name] = tcy_widgets_updated_field_value( $widget_field, $tcy_widget_field_value );
                    $instance = $this->field_wise_update($widget_field, $new_instance, $instance);
                }
            }
            return $instance;
        }

        public function field_wise_update($widget_field, $new_instance, $instance){
            extract($widget_field);
            switch ($tcy_widgets_field_type) {
                case 'tabgroup':
                    $instance = $this->update_tabgroup($tcy_widgets_tabs, $new_instance, $instance);
                    break;
                case 'accordion':
                    $instance = $this->update_accordion($tcy_widgets_accordion, $new_instance, $instance);
                    break;
                default:
                    //No need to set default
                    break;
            }
            return $instance;
        }

        /**
         * Function to Updating widget replacing old instances with new
         *
         * @access public
         * @since 1.0.0
         *
         * @param array $new_instance new arrays value
         * @param array $old_instance old arrays value
         * @return array
         *
         */
        public function update( $new_instance, $old_instance ) {
            
            $instance = $old_instance;

            $widget_fields = $this->widget_fields();

            // Loop through fields
            foreach ( $widget_fields as $widget_field ) {

                extract( $widget_field );

                // Use helper function to get updated field values
                $tcy_main_widget_value = isset($new_instance[$tcy_widgets_name]) ? $new_instance[$tcy_widgets_name] : '';
                $instance[$tcy_widgets_name] = tcy_widgets_updated_field_value( $widget_field,  $tcy_main_widget_value);

                $instance = $this->field_wise_update($widget_field, $new_instance, $instance );
                
            }
            return $instance;
        }

        /**
         * Function to Creating widget front-end. This is where the action happens
         *
         * @access public
         * @since 1.0.0
         *
         * @param array $args widget setting
         * @param array $instance saved values
         * @return void
         *
         */
        public function widget($args, $instance) {

        	esc_html_e('Blank widget created', 'sharing-plus');
            
        }

    } // Class Sharing_Plus_Master_Widget ends here
    
}
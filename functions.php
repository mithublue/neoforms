<?php

if( !function_exists('neoforms_pri' ) ) {
    function neoforms_pri( $data ) {
        echo '<pre>'; print_r($data);echo '</pre>';
    }
}

class NeoForms_Functions {

    /**
     * Check if the plugin is pro
     * @return bool
     */
    static function is_pro() {
        if( is_file( dirname(__FILE__).'/pro/loader.php' ) ) {
            return true;
        }
        return false;
    }

    /**
     * get form capability
     * @return mixed|void
     */
    public static function form_capability() {
        return apply_filters( 'neoforms_form_capability', 'manage_options');
    }

    /**
     * Get form types
     */
    public static function get_form_types() {
        return apply_filters( 'neoforms_form_types', array(
            'blank_form' => array(
                'label' => __( 'Blank Form', 'neoforms' ),
                'desc' => __( 'Choose this if you want to create a blank form rather than bothering with thinking about the type and decide the form type later')
            ),
            'contact' => array(
                'label' => __( 'Contact Form', 'neoforms' ),
                'desc' => __( 'Choose this if you want to create contact form' )
            )
        ));
    }

    public static function get_form_post_status( $id ) {
        return get_post_status($id);
    }

    /**
     * Get formdata for
     * the given id
     * @param $id
     * @return mixed
     */
    public static function get_formdata( $id, $formatted = false ) {
        if( $formatted ) {
            return json_decode(base64_decode(get_post_meta( $id, 'neoforms_formdata', true )), true);
        }
        return $formdata = get_post_meta( $id, 'neoforms_formdata', true );
    }

    /**
     * Get form settings
     * for given id
     * @param $id
     * @return mixed
     */
    public static function get_form_settings( $id, $formatted = false ) {
        if( $formatted ) {
            return json_decode(base64_decode(get_post_meta( $id, 'neoforms_form_settings', true ) ), true);
        }
        return $form_settings = get_post_meta( $id, 'neoforms_form_settings', true );
    }

    /**
     * Get global settings
     * @param null $option_name
     * @return array|mixed|object|string|void
     */
    public static function get_settings($option_name = null) {
        global $neo_global_settings;
        if( !$neo_global_settings ) {
            $neo_global_settings = get_option( 'neo_global_settings' );
            $neo_global_settings = json_decode(base64_decode($neo_global_settings),true);
        }

        if( $option_name ) {
            return isset($neo_global_settings[$option_name]) ? $neo_global_settings[$option_name] : '';
        }

        return $neo_global_settings;
    }

    /**
     * Validate recaptcha
     */
    public static function recaptcha_validate($token) {
        $response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify?secret='.NeoForms_Functions::get_settings('secrect_key').'&response='.$token );

        if( isset( $response['body'] ) ) {
            $body = json_decode($response['body'], true );
            if( $body['success'] ) {
                return true;
            }
        }
        return false;
    }

    public static function get_submission_occurance ( $submission_id ) {
	    $neo_submission_times = get_post_meta( $submission_id, 'neo_submission_times', true );
	    !$neo_submission_times ? $neo_submission_times = 0 : '';
	    return $neo_submission_times;
    }
    /**
     * Update submission times
     */
    public static function update_submission_occurance( $submission_id, $occurance = 1 ) {
	    $neo_submission_times = get_post_meta( $submission_id, 'neo_submission_times', true );
	    if( !$neo_submission_times ) $neo_submission_times = 0;
	    update_post_meta( $submission_id, $neo_submission_times + $occurance );
    }
}
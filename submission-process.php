<?php

class Neoforms_Submission_Process {

    /**
     * @var Singleton The reference the *Singleton* instance of this class
     */
    private static $instance;
    protected $postdata;
    protected $form_settings;
    protected $formdata;
    protected $errors = array();

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct( $postdata ) {

        /**
         * Check if the form exists
         * and published
         */
        if( NeoForms_Functions::get_form_post_status( $postdata['neoform_submission_id'] ) !== 'publish' ) {
            $this->set_error( 'Form is not submittable !' );
            return false;
        }

        $this->postdata = $postdata;
        $this->form_settings = NeoForms_Functions::get_form_settings($this->postdata['neoform_submission_id'], true );
        $this->formdata = NeoForms_Functions::get_formdata($this->postdata['neoform_submission_id'], true );

        if( empty( $this->get_errors() ) ) {
            if( $this->process_form() ) {
	            /**
	             * Save number of submission
	             * in form
	             */
            	NeoForms_Functions::update_submission_occurance( $this->postdata['neoform_submission_id'] );
	            return true;
            }
        }

        if( empty( $this->get_errors() ) )
            $this->set_error( 'Something went wrong !' );
        return false;
    }


    /**
     * Process form
     * @return bool|mixed|void
     */
    public function process_form () {
        /**
         * Data validation to check if
         * all data is okay
         */
        if( !$this->validate_data( $this->postdata, $this->formdata ) ) {
            return false;
        };
        if( !$this->common_validation() ) {
            return false;
        }

        if( method_exists( $this, 'process_'.$this->form_settings['form_settings']['s']['form_type'] ) ) {
            $process_method = 'process_'.$this->form_settings['form_settings']['s']['form_type'];
            if( $this->{$process_method}() ) {
                return true;
            };
            return false;
        } else {
            return apply_filters( 'neo_process_form_'.$this->form_settings['form_settings']['s']['form_type'], false, $this->postdata, $this->form_settings, $this );
        }
    }

    /**
     * Form specific process
     * Send mail
     * @return bool
     */
    public function process_contact() {
        $formwise_settings = $this->form_settings[$this->form_settings['form_settings']['s']['form_type'].'_settings']['s'];

        $to = isset($formwise_settings['mail_to']) && $formwise_settings['mail_to'] ? $formwise_settings['mail_to'] : get_bloginfo('admin_email');
        $email = isset($this->postdata[$formwise_settings['email_field']]) ? $this->postdata[$formwise_settings['email_field']] : '';
        $subject = isset( $this->postdata[$formwise_settings['subject_field']] ) ? $this->postdata[$formwise_settings['subject_field']] : '' ;
        $message = isset( $this->postdata[$formwise_settings['message_field']] ) ? $this->postdata[$formwise_settings['message_field']] : '';

        /**
         * If custom message format
         * is there
         */
        if( isset( $formwise_settings['message_format'] ) && !empty( $formwise_settings['message_format'] )) {
            $message = str_replace( array_keys( $this->postdata ), array_values( $this->postdata ), $formwise_settings['message_format'] );
        }

        if( !$email ) {
            $this->set_error( 'Email is not set !' );
            return false;
        }

        $headers = "From: " . strip_tags($email) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($to) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if( wp_mail( $to, $subject, $message, $headers ) )
            return true;
        return false;
    }

    public function common_validation() {
        /**
         * Recaptcha validation
         */
        if( isset( $this->postdata['g-recaptcha-response'] ) ) {
            $token = $this->postdata['g-recaptcha-response'];
            if( NeoForms_Functions::recaptcha_validate($token) ) {
                return true;
            } else {
                $this->set_error( 'Recaptcha is not valid' );
            }
            return false;
        }

        return true;
    }

    /**
     * Data validation after submission
     */
    public function validate_data() {
        $postdata = $this->postdata;
        $formdata = $this->formdata;

        if( !$this->form_settings['form_settings']['s']['is_multistep'] ) {
	        foreach ( $formdata['field_data'] as $k => $data ) {
		        if( $data['type'] == 'row' ) {
			        $this->row_validation($data);
		        }
	        }
        } else {
	        do_action( 'neo_form_validate_data', $postdata, $formdata, $this );
        }



        if( empty( $this->get_errors() ) )
            return true;
        return false;
    }

    public function row_validation( $data ) {
	    $postdata = $this->postdata;

	    foreach ( $data['row_formdata'] as $k => $col_data ) {
		    /**
		     * Validation : Required
		     */
		    if( isset( $col_data['s']['required'] ) && $col_data['s']['required'] == true ) {
			    /**
			     * if data type if
			     * file
			     */
			    //neoforms_pri($_FILES);
			    if( $col_data['preview']['name'] == 'upload' ) {
				    if( $_FILES[$col_data['s']['name']]['error'][0] ) {
					    $this->set_error( ( isset( $col_data['s']['label'] ) ? $col_data['s']['label'] : $col_data['s']['name'] ) .' is Required ' );
				    }
			    } else {
				    if( !isset( $postdata[$col_data['s']['name']] ) || empty( $postdata[$col_data['s']['name']] ) ) {
					    $this->set_error( ( isset( $col_data['s']['label'] ) ? $col_data['s']['label'] : $col_data['s']['name'] ) .' is Required ' );
				    }
			    }


		    }
	    }
    }

    /**
     * Set Errors
     * @param $msg
     */
    public function set_error( $msg ) {
        $this->errors[] = $msg;
    }

    /**
     * Get Errors
     * @return array
     */
    public function get_errors() {
        return $this->errors;
    }

}

<?php

class NeoForms_Admin {
    /**
     * @var Singleton The reference the *Singleton* instance of this class
     */
    private static $instance;

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

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
        add_action( 'admin_footer', array( $this, 'admin_footer' ) );
        add_action( 'neoforms_prepend_scripts_styles', array( $this, 'prepend_scripts_styles' ) );
    }

    public function register_admin_menu() {
        global $submenu;

        $capability = NeoForms_Functions::form_capability();
        $hook = add_menu_page( __( 'neoForms - The Best and Fastest Form Builder Ever', 'neoforms' ), 'neoForms', $capability, 'neoforms', array( $this, 'neoforms_page'), NEOFORMS_ASSET_PATH.'/img/icon.png' );

        if ( current_user_can( $capability ) ) {
            $submenu['neoforms'][] = array( __( 'All Forms', 'neoforms' ), $capability, 'admin.php?page=neoforms#/' );
            $submenu['neoforms'][] = array( __( 'Add Form', 'neoforms' ), $capability, 'admin.php?page=neoforms#/forms/form-types' );

            $submenu = apply_filters( 'neoforms_admin_menu', $submenu, $hook, $capability );
            do_action( 'neoforms_admin_menu', $submenu, $hook, $capability );
        }

        // only admins should see the settings page
        if ( current_user_can( 'manage_options' ) ) {
            $submenu['neoforms'][] = array( __( 'Settings', 'neoforms' ), 'manage_options', 'admin.php?page=neoforms#/settings' );
        }

	    $submenu['neoforms'][] = array( __( 'Help', 'neoforms' ), 'manage_options', 'admin.php?page=neoforms#/help' );

        add_action( 'load-'. $hook, array( $this, 'load_scripts' ) );
    }


    public function neoforms_page() {
        include_once NEOFORMS_ROOT.'/templates/main.php';
    }

    public function load_scripts() {
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_style('neoforms-framework-css', NEOFORMS_ASSET_PATH.'/css/framework.css' );
        wp_enqueue_style('neoforms-style-css', NEOFORMS_ASSET_PATH.'/css/style.css' );
        wp_enqueue_style('neoforms-element-css', NEOFORMS_ASSET_PATH.'/css/element.css' );

        wp_enqueue_script('neoforms-vue', NEOFORMS_ASSET_PATH.'/js/vue.js', array(), false, true );
        wp_enqueue_script('neoforms-vue-router', NEOFORMS_ASSET_PATH.'/js/vue-router.min.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-vuex', NEOFORMS_ASSET_PATH.'/js/vuex.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-functions', NEOFORMS_ASSET_PATH.'/js/functions.js' );
        wp_enqueue_script('neoforms-formbuilder-js', NEOFORMS_ASSET_PATH.'/js/templates/core/form-builder.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-element-js', NEOFORMS_ASSET_PATH.'/js/element.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-element-en-js', NEOFORMS_ASSET_PATH.'/js/element-en.js', array( 'neoforms-vue' ), false, true );

        /*form data*/
        do_action('neoforms_prepend_scripts_styles' );

        wp_enqueue_script('neoforms-form-type-data-js', NEOFORMS_ASSET_PATH.'/js/form-type-data.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-form-fields-js', NEOFORMS_ASSET_PATH.'/js/form-fields.js', array( 'neoforms-vue' ), false, true );
        
        wp_enqueue_script('neoforms-field-attributes-js', NEOFORMS_ASSET_PATH.'/js/field-attributes.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-form-settings-js', NEOFORMS_ASSET_PATH.'/js/form-settings.js', array( 'neoforms-vue' ), false, true );
        wp_enqueue_script('neoforms-store-js', NEOFORMS_ASSET_PATH.'/js/store.js', array( 'neoforms-vue' ), false, true );

        wp_enqueue_script('neoforms-form-js', NEOFORMS_ASSET_PATH.'/js/templates/form.js', array( 'neoforms-vue' ), false, true );

        do_action('neoforms_load_scripts_styles' );

        wp_enqueue_script('neoforms-script-js', NEOFORMS_ASSET_PATH.'/js/script.js', array( 'neoforms-vue', 'jquery' ), false, true );
    }

    public function prepend_scripts_styles() {
        if( !NeoForms_Functions::is_pro() ) {
            wp_enqueue_script('neoforms-pro-data-js', NEOFORMS_ASSET_PATH.'/js/pro-data.js'/*, array( 'neoforms-vue' ), false, true */);
        }
    }

    public function admin_footer() {
        include_once 'templates/core/form-builder.php';
    }
}

NeoForms_Admin::get_instance();
<?php
/*
 * Plugin Name: neoForms
 * Description: Best, Fastest, Easiest Multipurpose Form Plugin for Wordpress.
 * Plugin URI:
 * Author URI: https://cybercraftit.com/
 * Author: CyberCraft
 * Text Domain: neoforms
 * Domain Path: /languages
 * Version: 1.0.2
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NEOFORMS_VERSION', '1.0.2' );
define( 'NEOFORMS_ROOT', dirname(__FILE__) );
define( 'NEOFORMS_ASSET_PATH', plugins_url('assets',__FILE__) );
define( 'NEOFORMS_BASE_FILE', __FILE__ );

Class NeoForms_Init {
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
        add_action( 'init', array( $this, 'register_post_type' ) );
	    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'action_links' ) );
        $this->includes();
    }

	public function action_links($links) {
		$links[] = '<a href="https://cybercraftit.com/contact/" target="_blank">'.__( 'Ask for Modification', 'neoforms' ).'</a>';
		if( ! NeoForms_Functions::is_pro() ) {
			$links[] = '<a href="https://cybercraftit.com/neoforms-pro/" style="color: #fa0000;" target="_blank">'.__( 'Upgrade to Pro', 'neoforms' ).'</a>';
		}
		return $links;
	}

    public function includes() {
        include_once 'ajax-actions.php';
        include_once 'form-builder-admin.php';
        include_once 'functions.php';
        include_once 'shortcode.php';
        include_once 'submission-process.php';
        include_once 'data.php';

        if( NeoForms_Functions::is_pro() ) {
            include_once 'pro/loader.php';
        } else {
            include_once 'pro-data.php';
        }
    }


    public function register_post_type() {
        $capability = NeoForms_Functions::form_capability();

        $labels = array(
            'name'                  => _x('Form', 'post type general name', 'neoforms'),
            'singular_name'         => _x('Form', 'post type singular name','neoforms'),
            'menu_name'             => _x( 'Form', 'admin menu', 'neoforms'),
            'name_admin_bar'        => _x( 'Form', 'add new on admin bar', 'neoforms'),
            'add_new'               => _x('Add New Form', 'Form' , 'neoforms' ),
            'add_new_item'          => __('Add New Form', 'neoforms'),
            'edit_item'             => __('Edit Form', 'neoforms'),
            'new_item'              => __('New Form' , 'neoforms' ),
            'view_item'             => __('View Form', 'neoforms' ),
            'all_items'             => __( 'All Form', 'neoforms' ),
            'search_items'          => __('Search Form', 'neoforms' ),
            'not_found'             =>  __('Nothing found', 'neoforms' ),
            'not_found_in_trash'    => __('Nothing found in Trash', 'neoforms' ),
            'parent_item_colon'     => '',

        );

        register_post_type( 'neoforms_form', array(
            'label'           => __( 'Forms', 'neoforms' ),
            'public'          => false,
            'show_ui'         => true,
            'show_in_menu'    => false,
            'capability_type' => 'post',
            'hierarchical'    => false,
            'query_var'       => false,
            'supports'        => array('title'),
            'capabilities' => array(
                'publish_posts'       => $capability,
                'edit_posts'          => $capability,
                'edit_others_posts'   => $capability,
                'delete_posts'        => $capability,
                'delete_others_posts' => $capability,
                'read_private_posts'  => $capability,
                'edit_post'           => $capability,
                'delete_post'         => $capability,
                'read_post'           => $capability,
            ),
            'labels' => $labels,
        ) );

        /**
         * Entry post type
         */
        $labels = array(
            'name'                  => _x('Entry', 'post type general name', 'neoforms'),
            'singular_name'         => _x('Entry', 'post type singular name','neoforms'),
            'menu_name'             => _x( 'Entry', 'admin menu', 'neoforms'),
            'name_admin_bar'        => _x( 'Entry', 'add new on admin bar', 'neoforms'),
            'add_new'               => _x('Add New Entry', 'Form' , 'neoforms' ),
            'add_new_item'          => __('Add New Entry', 'neoforms'),
            'edit_item'             => __('Edit Entry', 'neoforms'),
            'new_item'              => __('New Entry' , 'neoforms' ),
            'view_item'             => __('View Entry', 'neoforms' ),
            'all_items'             => __( 'All Entry', 'neoforms' ),
            'search_items'          => __('Search Entry', 'neoforms' ),
            'not_found'             =>  __('Nothing found', 'neoforms' ),
            'not_found_in_trash'    => __('Nothing found in Trash', 'neoforms' ),
            'parent_item_colon'     => '',

        );

        register_post_type( 'neoforms_entry', array(
            'label'           => __( 'Entries', 'neoforms' ),
            'public'          => false,
            'show_ui'         => true,
            'show_in_menu'    => false,
            'capability_type' => 'post',
            'hierarchical'    => false,
            'query_var'       => false,
            'supports'        => array('title'),
            'capabilities' => array(
                'publish_posts'       => $capability,
                'edit_posts'          => $capability,
                'edit_others_posts'   => $capability,
                'delete_posts'        => $capability,
                'delete_others_posts' => $capability,
                'read_private_posts'  => $capability,
                'edit_post'           => $capability,
                'delete_post'         => $capability,
                'read_post'           => $capability,
            ),
            'labels' => $labels,
        ) );
    }
}

NeoForms_Init::get_instance();
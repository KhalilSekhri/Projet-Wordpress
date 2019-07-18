<?php
/**
 * Plugin Name: Insert - Google Analytics
 * Plugin URI: http://www.wangzhenchao.com/
 * Version: 1.0.0
 * Author: WANGZHENCHAO
 * Author URI: http://www.wangzhenchao.com/
 * Description: Allows you to insert code or text in the header of your WordPress blog
 * License: GPL2
 * Text Domain: insert - Google Analytics
 */


/**
 * Insert Headers Class
 */
class InsertHeaders {

    public function __construct() {

        // Plugin Details
        $this->plugin               = new stdClass;
        $this->plugin->name         = 'insert-header'; // Plugin Folder
        $this->plugin->displayName  = 'Google Analytics'; // Plugin Name
        $this->plugin->version      = '1.0.0';
        $this->plugin->folder       = plugin_dir_path( __FILE__ );
        $this->plugin->url          = plugin_dir_url( __FILE__ );
        $this->plugin->db_welcome_dismissed_key = $this->plugin->name . '_welcome_dismissed_key';
        
        // Hooks
        add_action( 'admin_init', array( &$this, 'registerSettings' ) );
        add_action( 'admin_menu', array( &$this, 'adminPanelsAndMetaBoxes' ) );

        // Frontend Hooks
        add_action( 'wp_head', array( &$this, 'frontendHeader' ) );
        add_action( 'wp_footer', array( &$this, 'frontendFooter' ) );

    }

    /**
     * Register Settings
     */
    function registerSettings() {
        register_setting( $this->plugin->name, 'ihaf_insert_header', 'trim' );
    }

    /**
     * Register the plugin settings panel
     */
    function adminPanelsAndMetaBoxes() {
        add_submenu_page( 'options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array( &$this, 'adminPanel' ) );
    }

    /**
     * Output the Administration Panel
     * Save POSTed data from the Administration Panel into a WordPress option
     */
    function adminPanel() {
        // only admin user can access this page
        if ( !current_user_can( 'administrator' ) ) {
            echo '<p>' . __( 'Sorry, you are not allowed to access this page.', 'insert-header' ) . '</p>';
            return;
        }

        // Save Settings
        if ( isset( $_REQUEST['submit'] ) ) {
            // Check nonce
            if ( !isset( $_REQUEST[$this->plugin->name.'_nonce'] ) ) {
                // Missing nonce
                $this->errorMessage = __( 'nonce field is missing. Settings NOT saved.', 'insert-header' );
            } elseif ( !wp_verify_nonce( $_REQUEST[$this->plugin->name.'_nonce'], $this->plugin->name ) ) {
                // Invalid nonce
                $this->errorMessage = __( 'Invalid nonce specified. Settings NOT saved.', 'insert-header' );
            } else {
                // Save
                // $_REQUEST has already been slashed by wp_magic_quotes in wp-settings
                // so do nothing before saving
                update_option( 'ihaf_insert_header', $_REQUEST['ihaf_insert_header'] );
                update_option( $this->plugin->db_welcome_dismissed_key, 1 );
                $this->message = __( 'Settings Saved.', 'insert-header' );
            }
        }

        // Get latest settings
        $this->settings = array(
            'ihaf_insert_header' => esc_html( wp_unslash( get_option( 'ihaf_insert_header' ) ) ),
        );

        // Load Settings Form
        include_once( $this->plugin->folder . '/views/viewAddHeader.php' );
    }

    /**
     * Outputs script / CSS to the frontend header
     */
    function frontendHeader() {
        $this->output( 'ihaf_insert_header' );
    }

    /**
     * Outputs the given setting, if conditions are met
     *
     * @param string $setting Setting Name
     * @return output
     */
    function output( $setting ) {
        // Ignore admin, feed, robots or trackbacks
        if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
            return;
        }

        // provide the opportunity to Ignore IHAF - both headers and footers via filters
        if ( apply_filters( 'disable_ihaf', false ) ) {
            return;
        }

        // provide the opportunity to Ignore IHAF - header only via filters
        if ( 'ihaf_insert_header' == $setting && apply_filters( 'disable_ihaf_header', false ) ) {
            return;
        }

        // Get meta
        $meta = get_option( $setting );
        if ( empty( $meta ) ) {
            return;
        }
        if ( trim( $meta ) == '' ) {
            return;
        }

        // Output
        echo wp_unslash( $meta );
    }
}

new InsertHeaders();
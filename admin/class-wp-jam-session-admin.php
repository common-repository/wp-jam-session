<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 *
 * @package    Wp_Jam_Session
 * @subpackage Wp_Jam_Session/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Jam_Session
 * @subpackage Wp_Jam_Session/admin
 * @author     Wonkasoft <info@wonkasoft.com>
 */
class Wp_Jam_Session_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Jam_Session_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Jam_Session_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Enqueued bootstrap only on our settings page
		if ( get_current_screen()->base == 'wonkasoft-tools_page_wp_jam_session_settings_page' || get_current_screen()->base == 'toplevel_page_wonkasoft_menu' ) {
		// Check to see if bootstrap style is already enqueue before setting the enqueue
		$style = 'bootstrap';
		if( ! wp_style_is( $style, 'enqueued' ) &&  ! wp_style_is( $style, 'done' ) ) {
	    //queue up your bootstrap
			wp_enqueue_style( $style, str_replace( array( 'http:', 'https:' ), '', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css'), array(), '3.3.7', 'all');
		}

		wp_enqueue_style( $this->plugin_name, str_replace( array( 'http:', 'https:' ), '', plugin_dir_url( __FILE__ ) . 'css/wp-jam-session-admin.css'), array(), $this->version, 'all' );

		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Jam_Session_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Jam_Session_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( get_current_screen()->base == 'wonkasoft-tools_page_wp_jam_session_settings_page' || get_current_screen()->base == 'toplevel_page_wonkasoft_menu' ) {
		
		// enqueue our custom admin js file
		wp_enqueue_script( $this->plugin_name . '-admin-js', str_replace( array( 'http:', 'https:' ), '', plugin_dir_url( __FILE__ ) . 'js/wp-jam-session-admin.js'), array( 'jquery' ), $this->version, true );

		// Creating a localize script for the ajax features
		wp_localize_script($this->plugin_name . '-admin-js', 'WP_JAM_KIT', array(
			'security' => wp_create_nonce( 'wp-jam-number' ),
			'success' => 'Your options were successfully updated.',
			'failure' => 'There was an error updating your options.'
			));

		// Check to see if bootstrap js is already enqueue before setting the enqueue
		$bootstrapjs = 'bootstrap-js';
		if ( ! wp_script_is( $bootstrapjs, 'enqueued' ) && ! wp_script_is($bootstrapjs, 'done' ) ) {
		 	// enqueue bootstrap js
			wp_enqueue_script( $bootstrapjs, str_replace( array( 'http:', 'https:' ), '', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js' ), array( 'jquery' ), '3.3.7', true );
		} 
		}
	}

// Active the Admin / Settings page
	public function wp_jam_session_display_admin_page() {
		
		/**
		 * This will check for Wonkasoft Tools Menu, if not found it will make it.
		 */
		if ( empty ( $GLOBALS['admin_page_hooks']['wonkasoft_menu'] ) ) {
			
			global $wp_jam_session_page;
			$wp_jam_session_page = 'wonkasoft_menu';
			add_menu_page(
				'Wonkasoft',
				'Wonkasoft Tools',
				'manage_options',
				'wonkasoft_menu',
				array( $this,'wp_jam_session_settings_page' ),
				plugins_url( '/img/wonka-logo-2.svg', __FILE__ ),
				100
			);

			add_submenu_page(
				'wonkasoft_menu',
				'WP Jam Session',
				'WP Jam Session',
				'manage_options',
				'wonkasoft_menu',
				array( $this,'wp_jam_session_settings_page' )
			);

		} else {

			/**
			 * This creates option page in the settings tab of admin menu
			 */
			global $wp_jam_session_page;
			$wp_jam_session_page = 'wp_jam_session_settings_page';
			add_submenu_page(
				'wonkasoft_menu',
				'WP Jam Session',
				'WP Jam Session',
				'manage_options',
				'wp_jam_session_settings_page',
				array( $this,'wp_jam_session_settings_page' )
			);

		}
	}

	// Create the mark up for the admin settings page
	public function wp_jam_session_settings_page() {
		include plugin_dir_path( __FILE__ ) . 'partials/wp-jam-session-admin-display.php';
	}

	// Create the action links on the plugins page
	public function wp_jam_session_add_action_links() {
		include plugin_dir_path( __FILE__ ) . 'partials/wp-jam-session-add-action-links.php';
	}

	// Create the session store the parameters into variables and load forms with data
	public function wp_jam_session_start_session() {
		include plugin_dir_path( __FILE__ ) . 'partials/wp-jam-session-start-session.php';
	}
	
}
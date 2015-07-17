<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://kobkob.org
 * @since      1.0.0
 *
 * @package    Map_List_Search
 * @subpackage Map_List_Search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Map_List_Search
 * @subpackage Map_List_Search/admin
 * @author     Monsenhor <filipo@kobkob.org>
 */
class Map_List_Search_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $map_list_search    The ID of this plugin.
	 */
	private $map_list_search;

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
	 * @param      string    $map_list_search       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $map_list_search, $version ) {

		$this->map_list_search = $map_list_search;
		$this->version = $version;

	}

	/**
	 * Saves the custom meta input
	 * @since    1.0.0
	 * @param    integer    $post_id    The post's id.
	public function map_list_meta_save( $post_id ) {
	 
	    // Checks save status
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_valid_nonce = ( isset( $_POST[ 'map_list_nonce' ] ) && wp_verify_nonce( $_POST[ 'map_list_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
	    // Exits script depending on save status
	    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	    }
	 
	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'name' ] ) ) {
		//update_post_meta( $post_id, 'name', sanitize_text_field( $_POST[ 'contact_information[name]' ] ) );
	    }
	 
	}
	 */

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Map_List_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Map_List_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->map_list_search, plugins_url() . '/map-list-search/admin/css/map-list-search-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Map_List_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Map_List_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->map_list_search, plugins_url() . '/map-list-search/admin/js/map-list-search-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create the widgets for the admin area.
	 *
	 * @since    1.0.0
	 */
        public function add_dashboard_widgets() {

		wp_add_dashboard_widget(
			 $this->map_list_search,         // Widget slug.
			 'Map List Search',         // Title.
			 array($this, 'dashboard_widget_display') // Display function.
		);	

                //global $wp_meta_boxes;
 	
		// Get the regular dashboard widgets array 
		// (which has our new widget already but at the end)
	 
		//$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		
		// Backup and delete our new dashboard widget from the end of the array
	 
		//$example_widget_backup = array( $this->map_list_search  => $normal_dashboard[$this->map_list_search] );
		//unset( $normal_dashboard[$this->map_list_search] );
	 
		// Merge the two arrays together so our widget is at the beginning
	 
		//$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
	 
		// Save the sorted array back into the original metaboxes 
	 
		//$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
        } 

	/**
	 * Display the widget for the admin area.
	 *
	 * @since    1.0.0
	 */
        public function dashboard_widget_display() {
                include(plugin_dir_path( __FILE__ ) . 'partials/map-list-search-admin-display.php');
        }

	/**
	 * Organize columns for map_lists view.
	 *
	 * @since    1.0.0
	 */
        public function change_columns( $cols ) {

        $cols = array(
          'cb'       => '<input type="checkbox" />',
          'title'     => __('Title', 'trans'),
          'name'      => __( 'Name',      'trans' ),
          'city' => __( 'City', 'trans' ),
          'url'     => __( 'Website', 'trans' ),
        );
        return $cols;
	} 

	/**
	 * Fill columns for map_lists view.
	 *
	 * @since    1.0.0
	 */
        public function custom_columns( $column, $post_id ) {
          $custom_fields_array = get_post_meta($post_id, 'contact_information');
          $custom_fields = $custom_fields_array[0];
	  switch ( $column ) {
	    case "title":
              echo'<a class="row-title" href="post.php?post='.$post_id.'&action=edit" title="Edit “'.get_the_title($post_id).'”">'.get_the_title($post_id).'</a>';
	      break;
	    case "name":
	      echo $custom_fields['name'];
	      break;
	    case "city":
	      echo $custom_fields['city'];
	      break;
	    case "url":
	      echo $custom_fields['url'];
	      break;
	  }
        }

        /**
	 * The admin menus.
	 *
	 * @since    1.0.0
	 */
        public function admin_menus() {
            // import CSV
	    add_submenu_page (
                'edit.php?post_type=map_list',
		'Import Maplist from CSV',
		'Import CSV',
		'manage_options',
		'import-csv',
		array($this, 'import_csv') 
	    );
        } 

        /**
	 * Importing csv file.
	 *
	 * @since    1.0.0
	 */
        public function import_csv() {
            include(plugin_dir_path( __FILE__ ) . 'partials/map-list-search-import-csv.php');
        }
}

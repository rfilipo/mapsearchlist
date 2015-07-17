<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://kobkob.org
 * @since      1.0.0
 *
 * @package    Map_List_Search
 * @subpackage Map_List_Search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Map_List_Search
 * @subpackage Map_List_Search/public
 * @author     Monsenhor <filipo@kobkob.org>
 */
class Map_List_Search_Public {

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
	 * @param      string    $map_list_search       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $map_list_search, $version ) {

		$this->map_list_search = $map_list_search;
		$this->version = $version;

	}

	/*
	 * Facade pointing to each page content method
	 *	 
	 * @since    1.0.0
	 */
	function map_list_facade($my_content) {
             
             if(isset( $wp_query->query_vars['mls'] ) && 
                       $wp_query->query_vars['mls']==1) {

             }
             return $my_content;
	}


	/*
	 * Registering the short codes
	 *	 
	 * @since    1.0.0
	 */
	function register_short_codes() {
            add_shortcode( 'maplist-search', 
                           array($this, 'main_search_short_code') 
            );
	}

	/*
	 * Main search short codes
	 *	 
	 * @since    1.0.0
	 */

	function main_search_short_code() {
            $sc = file_get_contents (dirname( __FILE__ ) .  "/partials/main_search.html" );
            return $sc;
	}


	/*
	 * Send email form
	 *	 
	 * @since    1.0.0
	 */

	function email_form($my_WP) {

            if (isset( $_GET['mls'])){
             if ($_GET['mls']  == 'mail'){
                //echo "<h1>UNDER MLS: ".$_GET['mls']."</h1>";
            	include_once (dirname( __FILE__ ) .  "/send_email_form.php") ;
           }}
	}



	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->map_list_search, plugins_url( ) . '/map-list-search/public/css/map-list-search-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_script( $this->map_list_search, plugins_url() . '/map-list-search/public/js/map-list-search-public.js', array( 'jquery','google-maps' ), $this->version, false );

                //wp_enqueue_script( $this->map_list_search, "https://maps.googleapis.com/maps/api/js?key=AIzaSyDqEQDfGl_8JLBbIRORFx-5F_2K52vn5XM", array( 'jquery' ), $this->version, false );
                wp_enqueue_script( 'google-maps', "https://maps.googleapis.com/maps/api/js?key=AIzaSyDqEQDfGl_8JLBbIRORFx-5F_2K52vn5XM&signed_in=true", $this->version, false );
		wp_enqueue_script( 'infobox', plugins_url() . '/map-list-search/public/js/infobox.js', array( 'jquery','google-maps' ), $this->version, false );
	}

	/*
	 * Force using special templates for map-list
	 *	 
	 * @since    1.0.0
	 */
	function map_list_template($single_template) {
	     global $post;

	     if ($post->post_type == 'map_list') {
		  $single_template = dirname( __FILE__ ) . '/single-map-list.php';
	     }
	     return $single_template;
	}

	/*
	 * Process content template for map-list search results
	 *	 
	 * @since    1.0.0
	 */
	function map_list_search_results($search_template) {
	     global $post;

	     if ($post->post_type == 'map_list') {
		  $page_template = dirname( __FILE__ ) . '/search-map-list.php';
                  $search_template = eval(file_get_contents($page_template));
	     }
	     return $search_template;
	}

	/*
	 * Force using special page templates for map-list pages
	 *	 
	 * @since    1.0.0
	 */
	function map_list_page_template($page_template) {
	     global $post;

             
	     if ($post->post_type == 'map_list') {
		  $page_template = dirname( __FILE__ ) . '/single-map-list.php';
	     }
	     return $page_template;
	}


        /*
	 * Force includind map_list in the search
	 *	 
	 * @since    1.0.0
	 */
	function search_filter($query) { 
          $is_mls = get_query_var('mls', 0);
	  if ( !is_admin() && $query->is_main_query() ) {
	    if ($query->is_search) {
	      $query->set('post_type', array( 'post', 'map_list' ) );
              if ( $is_mls ) {
                 echo "<h1>Testing before query</h1>\n";
                 echo "<li>" . get_query_var('country') ."</li>\n";

		$args = array(
			'meta_key'   => 'country',
			'meta_value' => get_query_var('country')
		);
		$query = new WP_Query( $args );



              }
	    }
	  }
        }

        /*
	 * Custom vars used in querys
	 *	 
	 * @since    1.0.0
	 */
	function add_query_vars( $vars ){
	  $vars = array_merge ( $vars, array("mls","mls_name","geosearch","zip","dt","city","state","country","mls_id"));
	  return $vars;
	}

        /*
	 * the custom query with metas
	 *	 
	 * @since    1.0.0
	 */
	function custom_search_query( $query ){
          if( isset( $_GET['mls'] ) && $_GET['mls'] == 1) {

$query->set( 'posts_per_page', '-1' );
$query->set( 'order', 'ASC' );
$query->set( 'post_type', 'map_list' );
$query->set( 'cat', '22,47,67' );
$query->set( 'orderby', 'name' );
$query->set( 'order', 'ASC' );
$query->set( 'nopaging', true );

    }
	}


        /*
	 * the where query construction
	 *	 
	 * @since    1.0.0
	function where_query_where( $where ){
          $is_mls = get_query_var('mls', 1);
	  if ( $is_mls ) {

             $my_query = "select * from wp_posts where ID = (select post_id from wp_postmeta where meta_value REGEXP '".$my_values."');";

             echo "<h1>Testing under query</h1>\n";
             echo "<li>" . $_GET['country']."</li>\n";
          }

	  return $where;
	}
	 */


}

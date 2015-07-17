<?php

/**
 * Fired during plugin init
 *
 * @link       http://kobkob.org
 * @since      1.0.0
 *
 * @package    Map_List_Search
 * @subpackage Map_List_Search/includes
 */

/**
 * Fired during plugin init.
 *
 * This class defines all code necessary to run during the init hook.
 *
 * @since      1.0.0
 * @package    Map_List_Search
 * @subpackage Map_List_Search/includes
 * @author     Monsenhor <filipo@kobkob.org>
 */
class Map_List_Search_Init { // TODO
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
	 * Activate stuff and options.
	 *
	 * Create tables, register options, import templates.
	 *
	 * @since    1.0.0
	 */
	public static function create_types() {
                /*
                 *  map_list custom post type
                 */
		register_post_type( 'map_list',
		    array(
		      'labels' => array(
			'name' => __( 'Map List' ),
                        'singular_name' => __( 'Map List' ),
                        'edit_item' => __( 'Edit Map List' ),
                        'add_new_item' => __( 'Add Map List' ),
                        'new_item' => __( 'New Map List' ),
                        'add_new' => __( 'Add new Map List' ),

		      ),
		      'public' => true,
		      'has_archive' => true,
                      'menu_icon'=> 'dashicons-location-alt',
                      'rewrite' => array( 'slug' => 'map_list' ),
		      'supports' => array('title'),
		    )
		  );
		$fm = new Fieldmanager_Group( array(
			'name' => 'contact_information',
			'children' => array(
	'name' => new Fieldmanager_Textfield( 'Name' ),
	'street' => new Fieldmanager_Textfield( 'Street' ),
	'city' => new Fieldmanager_Textfield( 'City' ),
	'county' => new Fieldmanager_Textfield( 'County' ),
	'stateprovince' => new Fieldmanager_Textfield( 'State Province' ),
	'postalcode' => new Fieldmanager_Textfield( 'Postal Code' ),
	'country' => new Fieldmanager_Textfield( 'Country' ),
	'phone' => new Fieldmanager_Textfield( 'Phone' ),
	'fax' => new Fieldmanager_Textfield( 'Fax' ),
	'email' => new Fieldmanager_Textfield( 'E-Mail' ),
	'url' => new Fieldmanager_Textfield( 'Url' ),
	'contact' => new Fieldmanager_Textfield( 'Contact Name' ),
	'areas' => new Fieldmanager_Textfield( 'Practice Areas' ),
			),
		) );
		$fm->add_meta_box( 'Contact Information', array( 'map_list' ) );
		$fmc = new Fieldmanager_Group( array(
			'name' => 'map_coordinates',
			'children' => array(
	'latitude' => new Fieldmanager_Textfield( 'Latitude' ),
	'longitude' => new Fieldmanager_Textfield( 'Longitude' ),
			),
		) );
		$fmc->add_meta_box( 'Map Coordinates', array( 'map_list' ) );


	}
}

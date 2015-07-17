<?php

/**
 * Kobkob's Map List Search
 *
 * @link              http://kobkob.org
 * @since             1.0.0
 * @package           Map_List_Search
 *
 * @wordpress-plugin
 * Plugin Name:       KobKob - Map List Search
 * Plugin URI:        http://kobkob.org/map-list-search-uri/
 * Description:       List administration and search with Google Maps support 
 * Version:           1.0.0
 * Author:            Monsenhor
 * Author URI:        http://kobkob.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       map-list-search
 * Domain Path:       /utilities
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-map-list-search-activator.php
 */
function activate_map_list_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-map-list-search-activator.php';
	Map_List_Search_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-map-list-search-deactivator.php
 */
function deactivate_map_list_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-map-list-search-deactivator.php';
	Map_List_Search_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_map_list_search' );
register_deactivation_hook( __FILE__, 'deactivate_map_list_search' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-map-list-search.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_map_list_search() {

	$plugin = new Map_List_Search();
	$plugin->run();

}
run_map_list_search();

////////////////////////////////////////////////////////////////////
/////// Utility functions

/**
 * distanceGeoPoints.
 * Returns the distance between 2 geopoints in miles 
 * 
 * @param $lat1
 * @param $lng1
 * @param $lat2
 * @param $lng2
 *
 * @since    1.0.0
 */
function distanceGeoPoints ($lat1, $lng1, $lat2, $lng2) {

    $earthRadius = 3958.75;

    $dLat = deg2rad($lat2-$lat1);
    $dLng = deg2rad($lng2-$lng1);


    $a = sin($dLat/2) * sin($dLat/2) +
       cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
       sin($dLng/2) * sin($dLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $dist = $earthRadius * $c;

    // from miles to meters
    //$meterConversion = 1609;
    //$geopointDistance = $dist * $meterConversion;
    $geopointDistance = $dist;

    return $geopointDistance;
}

/**
 * addhttp.
 * Inserts "http://" in url if it doesn't have protocol 
 * 
 * @param $url
 *
 * @since    1.0.0
 */
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}



<?php

$target_dir = plugin_dir_path( __FILE__ ) ."zip/";
$target_file = $target_dir . "zipcode.csv";

if (file_exists ( $target_file)) {
	if (($handle = fopen($target_file, "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 50000, ",")) !== FALSE) {
            // fill array with values from zip
            //"zip","city","state","latitude","longitude","timezone","dst"
            if (sanitize_text_field($data[0]) == $wp_query->query_vars['zip'] )
            $zip = array  ( 
                 'zip'   => sanitize_text_field($data[0]), // zip code 
                 'city'  => sanitize_text_field($data[1]), // city 
                 'state' => sanitize_text_field($data[2]), // state
                 'lat'   => sanitize_text_field($data[3]), // latitude 
                 'long'  => sanitize_text_field($data[4])  // longitude
            );
            }
            
	} else {
            echo "<h1>Sorry, ". $target_file . " could not be read. Verify the file permissions, please.</h1>";
	}
} else {
    echo "<h1>Sorry, strange error ... ". $target_file . " does not exist.</h1>";
}

?>

<?php
if (isset($_POST['cvs_file'])){
?>

<h1>File uploaded</h1>

<?php
	$target_dir = plugin_dir_path( __FILE__ ) ."uploads/";
	$target_file = $target_dir . basename($_FILES["uploaded_csv"]["name"]);

	if (move_uploaded_file($_FILES["uploaded_csv"]["tmp_name"], $target_file)) {
            echo "<p>The file ". basename( $_FILES["uploaded_csv"]["name"]). " has been uploaded."; 
		$row = 1;
		if (($handle = fopen($target_file, "r")) !== FALSE) {
                    $post_id = null;
                    // show results to user
		    echo "<table border>\n";
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			$row++;
			for ($c=0; $c < $num; $c++) {
                            switch ( $c ) {
	    case 0:
              // create post with title and date
              $my_post = array(
                 'post_title' => $data[$c],
                 //'post_date' => $_SESSION['cal_startdate'],
                 'post_status' => 'publish',
                 'post_type' => 'map_list',
              );
              $coordinates  = array();
              $contact_info = array();
              $post_id = wp_insert_post($my_post);
              // meta name 
              $contact_info['name'] = sanitize_text_field($data[$c]);
              echo'<tr><td>'.$post_id.'</td><td>';
	      break;
 	    case 1:
              // meta street
              $contact_info['street'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 2:
              // meta city
              $contact_info['city'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 3:
              // meta county
              $contact_info['county'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
	    case 4:
              // meta stateprovince 
              $contact_info['stateprovince'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 5:
              // meta postalcode
              $contact_info['postalcode'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 6:
              // meta country
              $contact_info['country'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 7:
              // meta latitude
              $coordinates['latitude'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 8:
              // meta longitude
              $coordinates['longitude'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 9:
              // meta phone
              $contact_info['phone'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 10:
              // meta fax
              $contact_info['fax'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 11:
              // meta email
              $contact_info['email'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 12:
              // meta url
              $contact_info['url'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
 	    case 13:
              // meta contact
              $contact_info['contact'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
  	    case 14:
              // meta areas
              $contact_info['areas'] = sanitize_text_field($data[$c]);
              echo'<td>';
	      break;
                           }

			    echo $data[$c] . "</td>\n";
                            update_post_meta($post_id, 'contact_information', $contact_info, false);
                            update_post_meta($post_id, 'map_coordinates', $coordinates, false);

			}
                    echo "</tr>";
		    }
		    fclose($handle);
                    echo "</table>";
		}
	} else {
	    echo "Sorry, there was an error uploading your file: ". $target_dir . basename($_FILES["uploaded_csv"]["name"]);
	}

} else {
?>
<h1>Import CSV file</h1>

<p>Prepare a CSV file with columns in the order bellow:

<table border><tr>
<td>Company Name</td>
<td>Address</td>
<td>City</td>
<td>County</td>
<td>State</td>
<td>Postal Code</td>
<td>Country</td>
<td>Latitude</td>
<td>Longitude</td>
<td>Phone 1</td>
<td>Phone 2</td>
<td>E-mail</td>
<td>Website</td>
<td>Contact name</td>
<td>Custom fields</td>
</tr></table>

<form method="post" enctype="multipart/form-data" >
<p>Select the CSV file: <input type="file" name="uploaded_csv"></input>
<br><input type="submit" name="cvs_file" value="Upload"></input>
</form>

<?php
}
?>

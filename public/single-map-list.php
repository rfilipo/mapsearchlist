<?php
/**
 * The Template for displaying all single map list
 *
 * @package Map List Search
 * @subpackage public
 * @since 1.0
 */
get_header();
?>
<!-- WP head -->
<?php //wp_head(); ?>
<div id="primary" class="map-list-content-area">
    <div id="content" class="map-list-content" role="main">

        <?php
the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );

$my_fields_a = get_post_meta(get_the_ID(), 'contact_information');
$my_fields = $my_fields_a[0];
$my_coordinates_a = get_post_meta(get_the_ID(), 'map_coordinates');
$my_coordinates = $my_coordinates_a[0];

    echo '<span class="map-list-return "><a href="#" onclick="history.back();">Return</a></span> | ';
    echo '<span class="map-list-sendmail "><a href="/?mls=mail&mls_id='.get_the_ID().'">Send Claim to Lawyer</a></span> | ';
    echo '<span class="map-list-directions "><a href="#" onclick="get_directions()">Get directions</a></span>';
			?>

<!-- /////////////////// Map List Panel /////////////////////// -->
<div id="map-list-canvas" class="list">
<div class="map-list-info">
<h3>Contact Information:</h3>
<?php
//var_dump($my_fields);
foreach ($my_fields as $key=>$value){
    echo '<li>'.$key.': '.$value.'</li>';
}
?>
</div>
<hr>

<div class="map-list-coordinates">
<h3>Map Coordinates:</h3>
<?php
echo '<p>Lat: '.$my_coordinates['latitude'].' Long: '.$my_coordinates['longitude'];
?>
</div>
<div id="map-canvas-frame">
<div id="map-canvas"></div>
</div>
<p><small>Map List Search by monsenhor</small>
</div>
<script>

/*
 * Create the map for this list record
 */
function initialize() {
  var latitude  = <?php echo $my_coordinates['latitude'];?> ;
  var longitude = <?php echo $my_coordinates['longitude'];?>;
  var my_html = "";
<?php

        echo 'my_html += \'<h1 class="name">'.esc_html($my_fields["name"]).'</h1> \';'."\n";
if($my_fields["contact"])
        echo 'my_html += \'<b>Contact: </b><span class="contact">'.esc_html($my_fields["contact"]).'</span> \';'."\n";
        echo 'my_html += \'<br><span class="street">'.esc_html($my_fields["street"]).'</span>, <span class="county">'.esc_html($my_fields["county"]).'</span>, <span class="stateprovince">'.esc_html($my_fields["stateprovince"]).'</span>, <span class="country">'.esc_html($my_fields["country"]).'</span> <span class="postalcode">'.esc_html($my_fields["postalcode"]).'</span> \';'."\n";
if($my_fields["areas"])
        echo 'my_html += \'<br><b>Practice areas: </b><span class="areas">'.esc_html($my_fields["areas"]).'</span> \';'."\n";
if($my_fields["phone"])
        echo 'my_html += \'<br><b>Phone: </b><span class="phone">'.esc_html($my_fields["phone"]).'</span> \';'."\n";
if($my_fields["fax"])
        echo 'my_html += \'<br><b>Fax: </b><span class="fax">'.esc_html($my_fields["fax"]).'</span> \';'."\n";
if($my_fields["url"])
        echo 'my_html += \'<br><b>Web: </b><a  target="_blank" href="'.addhttp(esc_html($my_fields["url"])).'" target="_blank"><span class="url">'.esc_html($my_fields["url"]).'</span></a> \';'."\n";
if($my_fields["email"])
        echo 'my_html += \'<br><b>Email: </b><a href="mailto:'.esc_html($my_fields["email"]).'"><span class="email">'.esc_html($my_fields["email"]).'</span></a> \';'."\n";
       
?>
  var mapOptions = {
    mapTypeControl: true,
    center: { 
	lat: latitude, 
	lng: longitude
    },
    zoom: 17
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  var marker = new google.maps.Marker({
	 map: map,
	 draggable: false,
	 position: new google.maps.LatLng(latitude, longitude),
	 visible: true
	});
		
        var boxText = document.createElement("div");
        boxText.style.cssText = "border: 1px solid black; margin-top: 10px; background: white; padding: 20px;";
        boxText.innerHTML = my_html;
		
	var myOptions = {
		 content: boxText
		,disableAutoPan: false
		,maxWidth: 0
		,pixelOffset: new google.maps.Size(-140, 0)
		,zIndex: null
		,boxStyle: { 
		  background: "url('tipbox.gif') no-repeat"
		  ,opacity: 0.75
		  ,width: "280px"
		 }
		,closeBoxMargin: "10px 2px 2px 2px"
		,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
		,infoBoxClearance: new google.maps.Size(1, 1)
		,isHidden: false
		,pane: "floatPane"
		,enableEventPropagation: false
	};

	var ib = new InfoBox(myOptions);
	ib.open(map, marker);

}
google.maps.event.addDomListener(window, 'load', initialize);

//

</script>
<!-- ////////////////////////////////////////////////////////// -->




	</div><!-- #content -->
	</div><!-- #primary -->


<?php
get_sidebar( 'content' );
//get_sidebar();
get_footer();


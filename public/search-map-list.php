<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Map List Search 1.0
 * @since 1.0
 */

get_header(); ?>

<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
 
<div id="main-content"><div id="main-mls">
<?php
global $wp_query;
$zip = array() ;
$dt = 30; // distance in miles
$zoom = 8; // zoom for map
if(isset( $wp_query->query_vars['dt'] )) $dt = $wp_query->query_vars['dt'];
if($dt == 5){
    $zoom = 12;
} elseif ($dt == 10){
    $zoom = 10;
} elseif ($dt == 15){
    $zoom = 9;
} elseif ($dt == 20){
    $zoom = 7;
} elseif ($dt == 50){
    $zoom = 6;
}
 
// Special search for detailed maplist query form
if(isset( $wp_query->query_vars['mls'] ) && $wp_query->query_vars['mls']==1) {
    $my_query_flag = "";
    $my_field_flag = "";
    $posts_found = 0;
    update_option( 'posts_per_page', -1 ); // show all records without paging
?>

    <?php if ( have_posts() ) : ?>
<script>
jQuery.noConflict();

// create global array vars
var my_id = [];
var marker = [];
var boxText = [];
var myOptions = [];
var ib = [];
var my_html = [];
var latitude = [];
var longitude = [];
var locations = [];
</script>
<?php
// Defines what search is it
?>
        <?php if(isset( $wp_query->query_vars['geosearch'] )) : ?>

<!-- Search by google geocoder  -->
<?php $my_query_flag = "mls_name";?>
<?php $my_field_flag = "geosearch";?>
<header class="page-header">
   <h3>Search for: <?php echo $wp_query->query_vars['geosearch']; ?></h3>
</header><!-- .page-header -->


        <?php elseif(isset( $wp_query->query_vars['mls_name'] )) : ?>

<!-- Search by name  -->
<?php $my_query_flag = "mls_name";?>
<?php $my_field_flag = "name";?>
<header class="page-header">
   <h3>Search for name: <?php echo $wp_query->query_vars['mls_name']; ?></h3>
</header><!-- .page-header -->

        <?php elseif(isset( $wp_query->query_vars['city'] )) : ?>
 
<!-- Search by city  -->
<?php $my_query_flag = "city";?>
<?php $my_field_flag = "city";?>
<header class="page-header">
   <h3>Search for city: <?php echo $wp_query->query_vars['city'];?></h3>
</header><!-- .page-header -->

       <?php elseif(isset( $wp_query->query_vars['zip'] )) : ?>
 
<!-- Search by zip  -->
<?php $my_query_flag = "zip";?>
<?php $my_field_flag = "postalcode";?>
<header class="page-header">
   <h3>Search for postal code: <?php echo $wp_query->query_vars['zip'];?></h3>
</header><!-- .page-header -->

<?php
// read zip info for query var from csv file into $zip
include ("get_zip_info.php"); 
?>

       <?php elseif(isset( $wp_query->query_vars['state'] )) : ?>
 
<!-- Search by state  -->
<?php $my_query_flag = "state";?>
<?php $my_field_flag = "stateprovince";?>
   <h3>Search for state: <?php echo $wp_query->query_vars['state'];?></h3>

       <?php elseif(isset( $wp_query->query_vars['country'] )) : ?>
 
<!-- Search by country  -->
<?php $my_query_flag = "country";?>
<?php $my_field_flag = "country";?>
<header class="page-header">
   <h3>Search for country: <?php echo $wp_query->query_vars['country'];?></h3>
</header><!-- .page-header -->

       <?php else : //no query_var is set .. hmmm ?>

<h3>Something very wrong happened, sorry about this ... :(</h3>

        <?php endif; ?>

<div id="mls-entries">
	<?php while ( have_posts() ) : the_post();
	$my_fields_a = get_post_meta(get_the_ID(), 'contact_information');
        $my_coordinates_a = get_post_meta(get_the_ID(), 'map_coordinates');
        if (isset($my_fields_a[0])){
	$my_fields = $my_fields_a[0];
        $my_coordinates = $my_coordinates_a[0];
        $zip_found = false;
        //echo "<li>".distanceGeoPoints ($my_coordinates['latitude'], $my_coordinates['longitude'], $zip['lat'], $zip['long'])."</li>\n";
        if (isset( $wp_query->query_vars['zip'] )) {
            if (distanceGeoPoints ($my_coordinates['latitude'], $my_coordinates['longitude'], $zip['lat'], $zip['long']) < $dt
            ){  
                     $zip_found = true; 
                     //echo "<li>Lat: ".$my_coordinates['latitude'].", ".$zip['lat']."</li>\n"; 
                     //echo "<li>Long: ".$my_coordinates['longitude'].", ".$zip['long']."</li>\n"; 
             }
        }
//echo "<pre>".$wp_query->query_vars[$my_query_flag]."</pre>";
//echo "<pre>-- ".$my_fields[$my_field_flag]."</pre>";
	//$preg = "/".soundex($wp_query->query_vars[$my_query_flag])."/";
        //$rreg= "/".soundex($my_fields[$my_field_flag])."/";
        $preg = "/".$wp_query->query_vars[$my_query_flag]."/";
	if (preg_match( strtoupper($preg), strtoupper($my_fields[$my_field_flag])) || $zip_found ){
        //if (preg_match($preg, $rreg)){
        //echo "<pre>".var_dump($zip)."</pre>\n";
?>

<!-- //////// record from ID: <?php echo get_the_ID(); ?>  ///////// -->
<div class='mls-entry'>

		<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
		//get_template_part( 'content', get_post_format() );
                $posts_found ++;
                $last_id = get_the_ID();
                echo "<p><span class='fields'>".$my_fields['street'] ."<br>"
                .$my_fields['city'].", "
                .$my_fields['stateprovince'].", "
                .$my_fields["country"]." "
                .$my_fields["postalcode"]
                ."</span><p><br>"; 


                echo "<p><span class='distance'><b>Distance:</b> ".intval(distanceGeoPoints ($my_coordinates['latitude'], $my_coordinates['longitude'], $zip['lat'], $zip['long']))." miles.</span></p><br>\n";
                echo '<li><span class="map-list-sendmail "><a href="/?mls=mail&mls_id='.get_the_ID().'">Send Claim to Lawyer</a></span><br>';
                echo '<li><span class="map-list-directions "><a href="">Get directions</a></span><hr>';
	
?>


</div><!-- mls entry -->

        <?php if( $my_query_flag == 'mls_name' || $my_query_flag == 'country' || $my_query_flag == 'city' ||  $my_query_flag == 'state' || $my_query_flag == 'zip' || $my_query_flag == 'geosearch'  ) : ?>


<script>
my_id[<?php echo ($posts_found -1);?>] = <?php echo get_the_ID(); ?>;
//console.log('Marker for id: <?php echo get_the_ID(); ?>');
//console.log(my_id);
latitude[<?php echo get_the_ID(); ?>]  = <?php echo $my_coordinates['latitude'];?> ;
longitude[<?php echo get_the_ID(); ?>] = <?php echo $my_coordinates['longitude'];?>;
my_html[<?php echo get_the_ID(); ?>] = "";

locations[<?php echo ($posts_found -1);?>] = [
 my_id[<?php echo ($posts_found -1);?>],
 latitude[<?php echo get_the_ID(); ?>],   
 longitude[<?php echo get_the_ID(); ?>]
];	 

<?php
 
        echo 'my_html['. get_the_ID().'] += \'<h1 class="name">'.esc_html($my_fields["name"]).'</h1> \';'."\n";
if($my_fields["contact"])
        echo 'my_html['. get_the_ID().'] += \'<b>Contact: </b><span class="contact">'.esc_html($my_fields["contact"]).'</span> \';'."\n";
        echo 'my_html['. get_the_ID().'] += \'<br><span class="street">'.esc_html($my_fields["street"]).'</span>, <span class="county">'.esc_html($my_fields["county"]).'</span>, <span class="stateprovince">'.esc_html($my_fields["stateprovince"]).'</span>, <span class="country">'.esc_html($my_fields["country"]).'</span> <span class="postalcode">'.esc_html($my_fields["postalcode"]).'</span> \';'."\n";
if($my_fields["areas"])
        echo 'my_html['. get_the_ID().'] += \'<br><b>Practice areas: </b><span class="areas">'.esc_html($my_fields["areas"]).'</span> \';'."\n";
if($my_fields["phone"])
        echo 'my_html['. get_the_ID().'] += \'<br><b>Phone: </b><span class="phone">'.esc_html($my_fields["phone"]).'</span> \';'."\n";
if($my_fields["fax"])
        echo 'my_html['. get_the_ID().'] += \'<br><b>Fax: </b><span class="fax">'.esc_html($my_fields["fax"]).'</span> \';'."\n";
if($my_fields["url"])
        echo 'my_html['. get_the_ID().'] += \'<br><b>Web: </b><a  target="_blank" href="'.addhttp(esc_html($my_fields["url"])).'" target="_blank"><span class="url">'.esc_html($my_fields["url"]).'</span></a> \';'."\n";
if($my_fields["email"])
        echo 'my_html['. get_the_ID().'] += \'<br><b>Email: </b><a href="mailto:'.esc_html($my_fields["email"]).'"><span class="email">'.esc_html($my_fields["email"]).'</span></a> \';'."\n";
        
	?>
</script>
<!-- ////////////////////////////////////////////////////////// -->
 <?php endif; ?>



        <?php
	}
        }else{//echo "<h1>ID: ".get_the_ID()."</h1>";
        }
	endwhile;?>
</div><!-- mls-entries -->

<?php if( $posts_found > 0 && ( $my_query_flag == 'city' ||  $my_query_flag == 'state' || $my_query_flag == 'zip' || $my_query_flag == 'country')  ) : ?>
<!-- Google Map -->
<?php
$my_coordinates_a = get_post_meta($last_id, 'map_coordinates');
$my_coordinates = $my_coordinates_a[0];
?>
<div id="map-canvas-frame-multiple">
<div id="map-canvas"></div>
</div><!-- map-canvas-frame-multiple -->
</div><!-- main mls -->
<script>
/*
 * Create the map centering in the last record
 */
//console.log('Define map');
var map;
function initialize() {
  //console.log('INIT');
  //console.log(locations);
  
  //var mapLatitude  = <?php echo $my_coordinates['latitude'];?> ;
  //var mapLongitude = <?php echo $my_coordinates['longitude'];?>;
  var mapOptions = {
    /*center: bound.getCenter(),
    center: { 
	lat: mapLatitude, 
	lng: mapLongitude
    },*/
    zoom: <?php echo $zoom;?>
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  var bound = new google.maps.LatLngBounds(map.getBounds());
  for (i = 0; i < locations.length; i++) {
      bound.extend( new google.maps.LatLng(locations[i][1], locations[i][2]) );
  }
  map.setCenter(bound.getCenter());
  //map.panBy(0, -200);
  //map.fitBounds(bound);
  //console.log(bound.getCenter());
  //console.log(my_id);

  // create state layer from fusion tables
  geo = 'col4';
  table = 210217;
  layer = new google.maps.FusionTablesLayer({
      query: {  select: geo, from: table }, 
      styles: [{
      
        polygonOptions: {
                fillOpacity: 0.01,
                strokeColor: "#39B7CD",
        strokeWeight: 2
        }
      
      }]
  });
  layer.setMap(map);
  // create the info boxes
  for (var i = 0; i < my_id.length; i++) {
	marker[my_id[i]] = new google.maps.Marker({
		 map: map,
		 draggable: false,
		 position: new google.maps.LatLng(latitude[my_id[i]], longitude[my_id[i]]),
		 visible: true
		});
	marker[my_id[i]].theID = my_id[i];
	boxText[my_id[i]] = document.createElement("div");
	boxText[my_id[i]].style.cssText = "border: 1px solid black; margin-top: 5px; background: white; padding: 10px;";
	boxText[my_id[i]].innerHTML = my_html[my_id[i]];
			
	myOptions[my_id[i]] = {
		 content: boxText[my_id[i]]
		,disableAutoPan: false
		,maxWidth: 0
		,pixelOffset: new google.maps.Size(-100, -150)
		,zIndex: null
		,boxStyle: { 
		  background: "url('tipbox.gif') no-repeat"
		  ,opacity: 0.75
		  ,width: "260px"
		 }
		,closeBoxMargin: "5px 2px 2px 2px"
		,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
		,infoBoxClearance: new google.maps.Size(1, 1)
		,isHidden: true
		,pane: "floatPane"
		,enableEventPropagation: false
	  };

	ib[my_id[i]] = new InfoBox(myOptions[my_id[i]]);
	ib[my_id[i]].open(map, marker[my_id[i]]);
        //my_ib = ib[my_id[i]];
        google.maps.event.addListener(marker[my_id[i]], 'click', function (){
    //console.log(this.theID);
    ib[this.theID].show();
        });
  }

}



//


</script>
<?php endif; ?>
<?php if ($posts_found == 0) : ?>
<h1>Sorry. No results found in this search.<h1>
<?php endif; ?>
<div class="navigation">
 <div class="alignleft"><?php previous_posts_link('&laquo; Previous Entries') ?></div>
 <div class="alignright"><?php next_posts_link('Next Entries &raquo;','') ?></div>
 </div>
    <?php else :  // no have posts
    get_template_part( 'content', 'none' );

    endif;
?>


<?php
}else{
// Normal search query, no mls query var
?>



			<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyfourteen' ), get_search_query() ); ?></h1>
			</header><!-- .page-header -->

				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;
					// Previous/next post navigation.
					//twentyfourteen_paging_nav(); ?>
<div class="navigation">
 <div class="alignleft"><?php previous_posts_link('&laquo; Previous Entries') ?></div><div class="alignright"><?php next_posts_link('Next Entries &raquo;','') ?></div></div> <?php

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>

		</div><!-- #content -->
	</section><!-- #primary -->

<p><small>Map List Search by monsenhor</small>
</div><!-- main content -->
<?php
}
get_sidebar( 'content' );
get_sidebar();
get_footer();
?>

<script>
 
jQuery( document ).ready(function( $ ) {
   //$( "#main" ).addClass( "map-list-multiple-map" );
<?php if( $posts_found > 0 && ( $my_query_flag == 'city' ||  $my_query_flag == 'state' || $my_query_flag == 'zip' || $my_query_flag == 'country')  ) : ?>
   //console.log('Hooking map to window.load()');
   google.maps.event.addDomListener(window, 'load', initialize);
<?php endif;?>
});
</script>


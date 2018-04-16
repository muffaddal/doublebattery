<?php
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if (!class_exists('Lane_Googlemap')) 
{
	class Lane_Googlemap 
	{
		function __construct() 
		{
			//add_action('wp_enqueue_scripts',array($this,'lane_front_scripts'),11);
			add_shortcode('lane_googlemap', array($this, 'lane_googlemap_shortcode' ));
		}
		function lane_front_scripts() 
		{
            //$min_suffix = defined( 'LANE_SCRIPT_DEBUG' ) && LANE_SCRIPT_DEBUG ? '' : '.min';
            //wp_enqueue_script('wplane-googlemap', '//maps.googleapis.com/maps/api/js', false, true);
            wp_enqueue_script('theme-gmap-core', '//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places',array(),'1.0',true );
        }
		function lane_googlemap_shortcode($atts) 
		{
			$title = $el_class = '';
			extract(shortcode_atts(array(
				'title' => '',
				'gmap_address' => 'Crown Heights, Brooklyn, NY, USA',
				'el_class'      => ''
			), $atts));
			$gmap_address = str_replace(',', '', $gmap_address);
			// We get the JSON results from this request
			$geo = @file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($gmap_address).'&sensor=false');
			// We convert the JSON to an array
			$geo = json_decode($geo, true);

			ob_start();
			?>
			<div class="wplane-gmap-element">
				<?php if(isset($title) && $title!=''): ?>
					<h3 class="widget-title"><?php echo wp_kses_post($title) ?></h3>
				<?php endif; /* ?>
				<script type="text/javascript">
			        // When the window has finished loading create our google map below
			        google.maps.event.addDomListener(window, 'load', init_lgmap);
			    
			        function init_lgmap() {
			            // Basic options for a simple Google Map
			            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
			            var mapOptions = {
			                // How zoomed in you want the map to start at (always required)
			                zoom: 11,

			                // The latitude and longitude to center the map (always required)
			                center: new google.maps.LatLng(40.6681032, -73.9447994), // New York

			                // How you would like to style the map. 
			                // This is where you would paste any style found on Snazzy Maps.
			                styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#353535"}]}]
			            };

			            // Get the HTML DOM element that will contain your map 
			            // We are using a div with id="map" seen below in the <body>
			            var mapElement = document.getElementById('map');

			            // Create the Google Map using our element and options defined above
			            var map = new google.maps.Map(mapElement, mapOptions);

			            // Let's also add a marker while we're at it
			            var marker = new google.maps.Marker({
			                position: new google.maps.LatLng(40.6681032, -73.9447994),
			                map: map
			            });
			        }
			    </script> */ ?>
				<div id="map"></div>
			</div>
			<?php
			$content = ob_get_clean();
			return $content;
		}
	}
	new Lane_Googlemap;
}
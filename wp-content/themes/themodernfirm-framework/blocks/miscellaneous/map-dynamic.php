<?php global $tmf_dynamic_map; $random_id = TMF_Text::random_string(); ?>

<div class="dynamic-map">

	<?php if (empty($tmf_dynamic_map)): ?>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyCq_KFO5Z07BQPR-2xCRBBvCYJwsemzihU"></script>		
	<?php endif ?>

	<script>
		jQuery(document).ready(function($) {
			var geocoder = new google.maps.Geocoder();
			var currCenter;
			geocoder.geocode({'address':'<?php echo rawurldecode($address) ?>'},function(result,status){
				if(status == google.maps.GeocoderStatus.OK){
					var map = new google.maps.Map(document.getElementById('dynamic-map-<?php echo $random_id ?>'),{
						center: result[0].geometry.location,
						zoom: <?php echo $zoom ?>,
					   mapTypeId: google.maps.MapTypeId.ROADMAP,
					   disableDefaultUI: true,
					   zoomControl: true,
					   zoomControlOptions: {
					      style: google.maps.ZoomControlStyle.SMALL
					    },
					   noClear:true,
					});

					// Add Alt tag on map titlesloaded
					google.maps.event.addListener(map, 'tilesloaded', function(evt){
					    jQuery(this.getDiv()).find("img").each(function(i, eimg){
					      if(!eimg.alt || eimg.alt ===""){
					         eimg.alt = "Google Map of <?php echo get_bloginfo('name') ?>’s Location";
					      }
					    });
					 });

					new google.maps.Marker({
						'map': map,
						'position': result[0].geometry.location,
					});

					currCenter = map.getCenter();

					google.maps.event.addDomListener(window, 'resize', function() {
						map.setCenter(currCenter);
					});
				}

			});
		});
	</script>

	<div id="dynamic-map-<?php echo $random_id ?>" style="width: 100%;max-width:<?php echo $width ?>px; height:<?php echo $height ?>px;"></div>

	<?php $tmf_dynamic_map = TRUE ?>
</div>


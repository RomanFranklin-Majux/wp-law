<?php global $tmf_dynamic_map; $random_id = TMF_Text::random_string(); ?>

<?php

if( isset($remove_firm_name) && 'true' == $remove_firm_name ) {
  $final_address = rawurldecode($address);
} else {
  $final_address = urlencode($name) .', '. rawurldecode($address);
}

?>

<div class="dynamic-map">

<iframe class="map-bottom" width="<?php echo $width ?>" height="<?php echo $height ?>"
  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCq_KFO5Z07BQPR-2xCRBBvCYJwsemzihU&q=<?php echo $final_address ?>&zoom=<?php echo $zoom ?>" allowfullscreen>
</iframe>
</div>
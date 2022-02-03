<?php 

$apiKeys = array(
	'AIzaSyDZttSrw3MucdICF8m1Y6ZEYd1LTC00vDk',
	'AIzaSyAQ0Jg8MM8MYHxAu-pJzrxDQigGTsWiS3Q'
);

shuffle($apiKeys);

?>

<?php $url = 'https://maps.googleapis.com/maps/api/staticmap?key='. $apiKeys[0] .'&zoom='. $zoom .'&sensor=false&markers=color:red%%7C'. $address; ?>
<div class="static-map">
	<a href="https://maps.google.com/maps?q=<?php echo $address ?>" target="_blank" title="Click to view this map on Google Maps">
		<img src="<?php echo $url ?>&size=<?php echo $width ?>x<?php echo $height ?>" data-url="<?php echo $url ?>&size=" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>" width="<?php echo $width ?>" height="<?php echo $height ?>" alt="Google Map of <?php echo get_bloginfo('name') ?>’s Location" />
	</a>
</div>
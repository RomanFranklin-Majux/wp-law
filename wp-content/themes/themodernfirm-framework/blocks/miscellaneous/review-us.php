<?php 
$service_names = array(
			'avvo'			=>	"Avvo",
			'yelp'			=>	"Yelp",
			'facebook'		=>	"Facebook",
			'linkedin'		=>	"Linked In"
			);
 ?>
<div class="review-us-links">
	<?php foreach($reviews as $review_us): ?>
	<div id="review-us-link" class="row">
		<div class="review-us-image span-4">
			<span class="<?php echo $review_us->_reivew_us_link_icon ?>"></span>
		</div>
		<div class="review-us-name span-4">
			<?php if(isset($review_us->_show_review_us_title) && $review_us->_show_review_us_title == "true"): ?>
				<?php echo (isset($review_us->_alternate_title)) ? $review_us->_alternate_title : $review_us->post_title; ?>
			<?php endif; ?>
		</div>
		<div class="review-us-link  span-16">
			<?php if($review_us->_review_us_url): ?>
				<a title="Review us on <?php echo $service_names[$review_us->_reivew_us_link_icon] ?>" href="<?php echo $review_us->_review_us_url ?>" target="_blank" class="tmf-review-us tmf-button">Click here to post your review</a>
			<?php endif; ?>
		</div>
	</div>
	<?php endforeach; ?>
</div>
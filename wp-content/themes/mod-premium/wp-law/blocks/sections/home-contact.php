<?php $section = $tmf->section('home-contact') ?>

	<div class="mobile-view">
		<div class="home-contact-info-wrapper">
			<div class="home-contact-info-container">
				<h3>Top Rated. Proven Results.</h3>
				<div class="icons-rating-wrapper">
				  <div class="icons">
					<img src="/wp-content/uploads/2021/11/path-facebook-1@1x.png" alt="Best Injury Lawyers Near Me"/>
					<img src="/wp-content/uploads/2021/11/path-google-1@1x.png" alt="Indiana Personal Injury Lawyers"/>
					<img src="/wp-content/uploads/2021/11/image-22-1@1x.png" alt="Personal Injury Lawyers Near Me"/>
					<img src="/wp-content/uploads/2021/11/image-24-1@1x.png" alt="Car Accident Attorneys Near Me"/>
				  </div>
				  <div class="star-rating-wrapper">
					<div class="star-rating">
					  <p class="rating">5.0</p>
					  <div class="stars">
						<img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Indianapolis Personal Injury Attorneys"/>
						<img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Personal Injury Lawyers"/>
						<img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Best Indianapolis Car Accident Lawyers"/>
						<img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Car Accident Attorneys"/>
						<img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Indiana Car Accident Lawyers"/>
					  </div>
					</div>
					<p class="center">Out of 477 Reviews</p>
				  </div>
				</div>
			</div>
		</div>
	</div>

	<?php $row = $tmf->row('home-contact', 1050) ?>

		<?php $row->cell(8) ?>
			<?php $tmf->module('home-contact-1')->render() ?>

		<?php $row->cell(8) ?>
			<div class="mobile-view">
				<img src="<?php echo $tmf->theme_image('contact_top_rated_attorneys_1x.png') ?>" alt="Top-Rated Attorneys" />
			</div>

			<?php $tmf->module('home-contact-2')->render() ?>

		<?php $row->cell(8) ?>
			<img src="<?php echo $tmf->theme_image('contact_top_rated_attorneys_1x.png') ?>" alt="Top-Rated Lawyers" />

	<?php $row->close() ?>

<?php $section->close() ?>
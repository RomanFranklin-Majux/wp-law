<?php $section = $tmf->section('proven-results') ?>

	<div class="section-title-wrapper">
		<div class="section-title">
			<div class="section-title-inner">
			</div>
		</div>
	</div>

	<?php $row = $tmf->row('proven-results', 1050) ?>

		<?php $row->cell(24) ?>
			<div class="desktop-view">
				<?php $tmf->module('proven-results')->render() ?>
			</div>

			<div class="mobile-view">
				<h3 class="mobile-heading">Proven Results</h3>
				<hr class="yellow"/>
				<?php get_template_part('template-parts/results-slider'); ?>
				<div class="proven-results-bottom-text">
					***Every case is unique and your results will differ. Contact us for a free case review of your circumstance.					
				</div>
			</div>

	<?php $row->close() ?>

<?php $section->close() ?>
<?php $section = $tmf->section('int-section-1') ?>

	<?php $row = $tmf->row('int-section-1', 1050) ?>

		<?php $row->cell(24) ?>
			<?php $tmf->module('int-section-1')->render() ?>
			<div id="featured-and-recognized">
				<?php $tmf->module('featured-and-recognized')->render() ?>
			</div>

	<?php $row->close() ?>

<?php $section->close() ?>
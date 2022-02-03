<?php $section = $tmf->section('testimonial-section') ?>

	<?php $row = $tmf->row('testimonial-section', 1050) ?>

		<?php $row->cell(24) ?>
			<?php $tmf->module('testimonial-section')->render() ?>

	<?php $row->close() ?>

<?php $section->close() ?>
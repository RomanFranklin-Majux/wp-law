<?php $section = $tmf->section('int-section-2') ?>

	<?php $row = $tmf->row('int-section-2', 1050) ?>

		<?php $row->cell(24) ?>
			<?php $tmf->module('int-section-2')->render() ?>

	<?php $row->close() ?>

<?php $section->close() ?>
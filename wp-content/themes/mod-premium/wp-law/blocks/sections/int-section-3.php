<?php $section = $tmf->section('int-section-3') ?>

	<?php $row = $tmf->row('int-section-3', 1050) ?>

		<?php $row->cell(12) ?>
			<?php $tmf->module('int-section-3-left')->render() ?>

		<?php $row->cell(12) ?>
			<?php $tmf->module('int-section-3-right')->render() ?>

	<?php $row->close() ?>

<?php $section->close() ?>
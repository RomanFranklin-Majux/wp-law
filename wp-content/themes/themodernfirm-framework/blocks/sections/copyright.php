<?php $section = $tmf->section('copyright') ?>

	<?php $row = $tmf->row('copyright') ?>

		<?php $row->cell(24) ?>
			<?php $tmf->module('copyright')->render() ?>

	<?php $row->close() ?>

<?php $section->close() ?>
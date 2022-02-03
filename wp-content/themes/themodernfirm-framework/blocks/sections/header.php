<?php $section = $tmf->section('header') ?>

	<?php $row = $tmf->row('header', 750) ?>

		<?php $row->cell(12) ?>
			<?php $tmf->logo() ?>

		<?php $row->cell(12) ?>
			<?php $tmf->module('header')->render() ?>

	<?php $row->close() ?>	

<?php $section->close() ?>
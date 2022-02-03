<?php $section = $tmf->section('footer') ?>

	<?php $row = $tmf->row('footer', 850) ?>

		<?php $row->cell(8) ?>
			<?php $tmf->module('footer-1')->render() ?>

		<?php $row->cell(8) ?>
			<?php $tmf->module('footer-2')->render() ?>

		<?php $row->cell(8) ?>
			<?php $tmf->module('footer-3')->render() ?>

	<?php $row->close() ?>

<?php $section->close() ?>
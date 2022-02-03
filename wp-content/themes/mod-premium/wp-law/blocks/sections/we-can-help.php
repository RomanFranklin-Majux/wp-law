<?php $section = $tmf->section('we-can-help') ?>

	<?php $row = $tmf->row('we-can-help-top', 1050) ?>

		<?php $row->cell(16) ?>
			<?php $tmf->module('we-can-help-1')->render() ?>

		<?php $row->cell(8) ?>
			<?php $tmf->module('we-can-help-2')->render() ?>

	<?php $row->close() ?>

	<?php $row = $tmf->row('we-can-help-bottom', 1050) ?>

		<?php $row->cell(24) ?>
			
			<div class="desktop-view">
				<?php $tmf->module('we-can-help-3')->render() ?>
			</div>

	<?php $row->close() ?>

<?php $section->close() ?>
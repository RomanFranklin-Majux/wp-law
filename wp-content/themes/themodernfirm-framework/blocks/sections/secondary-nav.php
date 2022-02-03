<?php if ($tmf->has_navigation('secondary')): ?>

	<?php $section = $tmf->section('secondary-nav') ?>

		<?php $row = $tmf->row('secondary-nav') ?>

			<?php $row->cell(24) ?>
				<?php $tmf->navigation('secondary')->render() ?>

		<?php $row->close() ?>

	<?php $section->close() ?>

<?php endif ?>
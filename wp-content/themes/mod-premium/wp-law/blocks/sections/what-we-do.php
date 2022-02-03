<?php $section = $tmf->section('what-we-do') ?>

	<?php $row = $tmf->row('what-we-do', 1050) ?>

		<?php $row->cell(12) ?>
			<div class="desktop-view">
				<?php $tmf->module('what-we-do-1')->render() ?>
			</div>
			<div class="mobile-view text">
				<?php $tmf->module('1763')->render() ?>
			</div>

		<?php $row->cell(12) ?>
			<?php $tmf->module('what-we-do-2')->render() ?>

	<?php $row->close() ?>

<?php $section->close() ?>
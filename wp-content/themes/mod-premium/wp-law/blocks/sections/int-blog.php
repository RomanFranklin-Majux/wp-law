<?php $section = $tmf->section('int-blog') ?>

	<?php $row = $tmf->row('int-blog', 1050) ?>

		<?php $row->cell(24) ?>
			<?php $tmf->module('int-blog')->render() ?>

	<?php $row->close() ?>

<?php $section->close() ?>
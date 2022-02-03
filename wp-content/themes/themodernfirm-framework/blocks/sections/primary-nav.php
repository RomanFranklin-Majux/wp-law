<?php if ($tmf->has_navigation('primary')): ?>
	
	<?php $section = $tmf->section('primary-nav') ?>

		<div class="menu-bar">Menu</div>

		<?php $tmf->navigation('primary')->render() ?>

	<?php $section->close() ?>

<?php endif ?>
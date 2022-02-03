<?php $section = $tmf->section('common-questions') ?>

	<?php $row = $tmf->row('common-questions', 1050) ?>

		<?php $row->cell(9) ?>
			<div class="common-questions-keith-img">
				<img src="<?php echo $tmf->theme_image('keith_1x.png') ?>" srcset="<?php echo $tmf->theme_image('keith_2x.png') ?> 2x, <?php echo $tmf->theme_image('keith_3x.png') ?> 3x" alt="Best Indiana Injury Attorneys" />
			</div>

		<?php $row->cell(15) ?>
			<?php $tmf->module('common-questions')->render() ?>

	<?php $row->close() ?>

<?php $section->close() ?>
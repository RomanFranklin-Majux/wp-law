<div id="print-header">
	
	<?php if (isset($tmf->option()->print_header)): ?>
		<div class="info">
			<?php echo $tmf->render_shortcode($tmf->option()->print_header); ?>
		</div>
	<?php endif; ?>

	<?php $tmf->print_logo() ?>

</div>
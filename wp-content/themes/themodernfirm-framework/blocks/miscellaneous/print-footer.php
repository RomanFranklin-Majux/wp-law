<div id="print-footer">
	
	<?php if (isset($tmf->option()->print_footer)): ?>
		<div class="info">
			<?php echo $tmf->render_shortcode($tmf->option()->print_footer); ?>
		</div>
	<?php endif; ?>

	<div class="print-copyright">
		Copyright © <?php echo date('Y') ?> 
		<?php echo $tmf->wp_option()->blogname ?>
	</div>

</div>
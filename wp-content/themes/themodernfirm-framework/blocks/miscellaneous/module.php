<?php //print_r($module) ?>
<div class="<?php TMF_Module::generate_module_css_classes($module) ?>">
	<?php if (isset($module->tmf->show_module_title) && $module->tmf->show_module_title == 'true'): ?>
		<h3 class="tmf-module-title">
			<?php if (isset($module->_title_link)): ?>
				<a href="<?php echo $module->_title_link ?>" />
			<?php endif ?>

				<?php echo (isset($module->_alternate_title)) ? $module->_alternate_title : $module->post_title ?>

			<?php if (isset($module->_title_link)): ?>
				</a>
			<?php endif ?>
		</h3>
	<?php endif ?>
	<div class="tmf-module-content editor-content">
		<?php echo $module->tmf->content ?>
	</div>
</div>
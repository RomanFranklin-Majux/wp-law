<?php $section = $tmf->section('attorneys-section') ?>

	<div class="section-title-wrapper">
		<div class="section-title">
			<div class="desktop-view section-title-inner">
				<h3 class="h1"><span>Your Legal Team</span></h3>
			</div>
			<div class="mobile-view">
				<h3 class="mobile-heading">Your Legal Team</h3>
				<hr class="yellow"/>
			</div>
		</div>
	</div>

    <?php $row = $tmf->row('attorneys-section', 1050) ?>

		<?php $row->cell(24) ?>
			<?php $tmf->module('attorneys-section')->render() ?>

	<?php $row->close() ?>	

<?php $section->close() ?>
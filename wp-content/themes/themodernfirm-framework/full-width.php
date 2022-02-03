<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Template Name: Full Width
 * 
 * Full width page template
 * 
 * @package TheModernFirmFramework
 * @category Templates
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
?>

<?php $tmf->block('top')->render() ?>

	<?php $section = $tmf->section('body') ?>

		<?php $row = $tmf->row('body', 850) ?>

			<?php $row->cell(24) ?>

				<?php if ($tmf->has_posts()): ?>

					<?php if ($tmf->authorize()->is_authorized()): ?>

						<?php $tmf->posts()->template('large')->render() ?>

					<?php endif ?>

				<?php endif ?>

		<?php $row->close() ?>	

	<?php $section->close() ?>

<?php $tmf->block('bottom')->render() ?>

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * The default template for the front page.
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

			<?php $row->cell(16) ?>

				<?php if ($tmf->has_posts()): ?>

					<?php $tmf->posts()->template('home')->render() ?>

				<?php endif ?>

			<?php $row->cell(8) ?>

				<?php $tmf->module('home-sidebar')->render() ?>

		<?php $row->close() ?>	

	<?php $section->close() ?>

<?php $tmf->block('bottom')->render() ?>

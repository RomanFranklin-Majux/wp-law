<?php $section = $tmf->section('body') ?>

	<?php $row = $tmf->row('body', 1050) ?>

		<?php $row->cell(16) ?>
   
			<?php $tmf->breadcrumb(array('separator' => ' › ' ))->render() ?>

			<div class="<?php echo $post->css_classes('large') ?>">

				<?php if ($post->has_title()): ?>
					<h1 id="page-title">
						<?php echo $post->title ?>
					</h1>
				<?php endif ?>

				<div class="content-container">

					<div id="page-content" class="editor-content">
						<?php echo $post->content ?>
					</div>


				</div>

				<?php $tmf->block('miscellaneous/social-buttons')->set('page', TRUE)->render() ?>

			</div>

		<?php $row->cell(8) ?>
							
			<?php $sidebar = ($tmf->request()->is_post_type('post')) ? 'blog-sidebar' : 'page-sidebar' ?>
			<?php $tmf->module($sidebar)->render() ?>

	<?php $row->close() ?>	

<?php $section->close() ?>

<?php $tmf->block('sections/int-section-3')->render() ?>
<?php $tmf->block('sections/attorneys-section')->render() ?>

<?php if ($post->latest_blog): ?>
	<?php $section = $tmf->section('int-blog') ?>

		<?php $row = $tmf->row('int-blog', 1050) ?>

			<?php $row->cell(24) ?>
				<h3><span><?php echo $post->latest_blog_title ?></span></h3>
				<div class="editor-content">
					<?php echo do_shortcode($post->latest_blog) ?>
				</div>

		<?php $row->close() ?>

	<?php $section->close() ?>
<?php endif ?>


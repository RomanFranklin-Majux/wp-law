<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Template Name: Contact
 * 
 * Contact page template
 * 
 * 
 * @package TheModernFirmFramework
 * @category Templates
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2013 The Modern Firm, LLC
 */
?>

<?php $tmf->block('top')->render() ?>

	<?php $section = $tmf->section('int-billboard') ?>

		<?php if($post->tmf->banner_image): ?>
			<?php 
			    $high_res = '';
			    $logo_path = get_attached_file($post->tmf->banner_image); 
			    $image = $tmf->image_url_from_id($post->tmf->banner_image);
			    $logo_2x = str_replace('3x', '2x', $logo_path);
			    $logo_1x = str_replace('3x', '1x', $logo_path);
			    $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
			    $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

			    $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
			?>
			<div class="int-billboard-desktop-view">
				<img src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" />
			</div>
		<?php else: ?>
			<div class="int-billboard-desktop-view">
				<img src="<?php echo $tmf->theme_image('map_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('billboard_help_without_leaving_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('billboard_help_without_leaving_3x.jpg') ?> 3x" alt="Best Personal Injury and Accident Attorneys" />
			</div>
		<?php endif ?>

		<?php if($post->tmf->mobile_banner_image): ?>
			<?php 
			    $high_res = '';
			    $logo_path = get_attached_file($post->tmf->mobile_banner_image); 
			    $image = $tmf->image_url_from_id($post->tmf->mobile_banner_image);
			    $logo_2x = str_replace('3x', '2x', $logo_path);
			    $logo_1x = str_replace('3x', '1x', $logo_path);
			    $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
			    $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

			    $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
			?>
			<div class="int-billboard-mobile-view">
				<img src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" />
			</div>
		<?php else: ?>
			<div class="int-billboard-mobile-view">
				<img src="<?php echo $tmf->theme_image('mobile_int_help_without_leaving_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('mobile_int_help_without_leaving_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('mobile_int_help_without_leaving_3x.jpg') ?> 3x" alt="Best Personal Injury and Accident Attorneys" />
			</div>
		<?php endif ?>

    <?php $alternate_title = get_post_meta(get_the_ID(), '_alternate_title', true) ?>
    <?php if($alternate_title): ?>
      <div class="int-billboard-content">
            <div class="int-billboard-content-container">
              <h1 id="page-title"><?php echo $alternate_title; ?></h1>
            </div>
        </div>
    <?php else: ?>
      <div class="int-billboard-content">
            <div class="int-billboard-content-container">
          <?php $tmf->request()->title() ?>
            </div>
        </div>
    <?php endif; ?>

	<?php $section->close() ?>

	<?php $section = $tmf->section('body') ?>

		<?php $row = $tmf->row('body', 1050) ?>

			<?php $row->cell(16) ?>

				<?php if ($tmf->has_posts()): ?>
					<?php $tmf->posts()->template('large')->render(); ?>
				<?php endif; ?>

			<?php $row->cell(8) ?>
                                   
				<?php $sidebar = ($tmf->request()->is_directory('post')) ? 'blog-sidebar' : 'page-sidebar' ?>
				<?php $tmf->module($sidebar)->render() ?>

		<?php $row->close() ?>	

	<?php $section->close() ?>

	<?php $tmf->block('sections/int-section-3')->render() ?>
	<?php $tmf->block('sections/attorneys-section')->render() ?>

	<div id="showcase-faq-section-wrapper" class="section-wrapper">
	   <div id="showcase-faq-section-container" class="section-container">
		  <div id="showcase-faq-section" class="section">
			 <div id="showcase-faq-section-row" class="row collapse-1050 ">
				<div id="showcase-faq-section-cell-1" class="cell span-24">
				   <div class="inner">
					  <!-- Desktop View Start-->
					  <div class="showcase-faq-desktop-view">
						 <div id="show-case-faqs-tab" class="resp-vtabs hor_1" style="display: block; width: 100%; margin: 0px;">
							<ul class="resp-tabs-list hor_1" style="margin-top: 3px;">
							   <li class="resp-tab-item hor_1 resp-tab-active" aria-controls="hor_1_tab_item-0" role="tab">How Do I Get Needed Medical Care?</li>
							   <li class="resp-tab-item hor_1" aria-controls="hor_1_tab_item-1" role="tab">Is Your Legal Help  Expensive?  </li>
							   <li class="resp-tab-item hor_1" aria-controls="hor_1_tab_item-2" role="tab">Is the Process Difficult?</li>
							   <li class="resp-tab-item hor_1" aria-controls="hor_1_tab_item-3" role="tab">Will I Need to Go to Court?</li>
							</ul>
							<div class="resp-tabs-container hor_1">
							   <h2 class="resp-accordion hor_1 resp-tab-active" role="tab" aria-controls="hor_1_tab_item-0" style="background: none;"><span class="resp-arrow"></span>How Do I Get Needed Medical Care?</h2>
							   <div class="editor-content resp-tab-content hor_1 resp-tab-content-active" aria-labelledby="hor_1_tab_item-0" style="display:block">
								  <div class="tab-content-cell-1">
									 <p>It can be extremely challenging to get the medical care you need following an injury.&nbsp; Failing to do so can not only prevent you from healing properly but it can also hurt your legal recovery.</p>
									 <p>Injury victims may not seek necessary medical treatment for a variety of reasons.&nbsp; They may not know of a good doctor that can help them.&nbsp; They might not have transportation to get to appointments.&nbsp; Frequently, an injury victim may not have medical insurance to pay health care providers.</p>
									 <p>We can help by recommending top-rated physicians and coordinating appointments.&nbsp; We will assist clients in getting to medical appointments if they do not have transportation.&nbsp; We also have a number of strategies that may allow you to get immediate medical care with no up-front charges, even if you do not have health insurance.&nbsp;</p>
									 <p>Do not skip critical medical care -- contact us so we can help.</p>
								  </div>
								  <div class="showcase-faq-button">
									 <a class="tmf-button" href="#tmf-popup-form">Contact Us</a>
								  </div>
							   </div>
							   <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-1"><span class="resp-arrow"></span>Is Your Legal Help  Expensive?  </h2>
							   <div class="editor-content resp-tab-content hor_1" aria-labelledby="hor_1_tab_item-1">
								  <div class="tab-content-cell-1">
									 <p>No one should be denied justice because they cannot afford a lawyer.&nbsp;</p>
									 <p>If we accept your case, you pay nothing out-of-pocket.&nbsp; It costs nothing for us to get started and we advance all expenses of your case.&nbsp; Over the years, we have advanced millions of dollars in case expenses for court filing fees, hiring expert consultants, and preparing cases.</p>
									 <p>With our Zero Fee Promise, you pay us nothing unless we are successful in recovering money for you.&nbsp; This includes all of the expenses we pay to third-parties while preparing your case.&nbsp; Put simply, you owe us nothing unless we win.</p>
								  </div>
								  <div class="showcase-faq-button">
									 <a class="tmf-button" href="#tmf-popup-form">Contact Us</a>
								  </div>
							   </div>
							   <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-2"><span class="resp-arrow"></span>Is the Process Difficult?</h2>
							   <div class="editor-content resp-tab-content hor_1" aria-labelledby="hor_1_tab_item-2">
								  <div class="tab-content-cell-1">
									 <p>Our goal is to get the best result possible with as little work from our clients as possible.&nbsp; Our legal team and staff manage all legal matters so our clients can concentrate on getting their life back together.&nbsp;</p>
									 <p>We conduct all interactions with the insurance company and their lawyers.&nbsp; We can work with you by email, telephone, text, or Zoom – depending on what’s most convenient for <strong><u>you</u></strong>.&nbsp; We can text or email you any document, and anything which requires a signature can be done electronically through a mobile phone.&nbsp;</p>
									 <p>Many times, our clients have settled their case without ever leaving home.&nbsp; &nbsp;While this isn’t possible in every case, we work tirelessly to make sure you don’t have to.</p>
								  </div>
								  <div class="showcase-faq-button">
									 <a class="tmf-button" href="#tmf-popup-form">Contact Us</a>
								  </div>
							   </div>
							   <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-3"><span class="resp-arrow"></span>Will I Need to Go to Court?</h2>
							   <div class="editor-content resp-tab-content hor_1" aria-labelledby="hor_1_tab_item-3">
								  <div class="tab-content-cell-1">
									 <p>The vast majority of cases settle without our clients setting foot inside a court room.&nbsp;</p>
									 <p>We take pride in our skills as trial lawyers and will not hesitate to take your case to trial when necessary. However, the insurance companies know our commitment to using every resource to get our clients the result they deserve.&nbsp;</p>
									 <p>Our willingness to fight for our clients at trial is one of the reasons we seldom have to.&nbsp;</p>
								  </div>
								  <div class="showcase-faq-button">
									 <a class="tmf-button" href="#tmf-popup-form">Contact Us</a>
								  </div>
							   </div>
							</div>
						 </div>
					  </div>
					  <!-- Desktop View End-->
					  <!-- Mobile View Start-->
					  <div class="showcase-faq-mobile-view">
						 <div class="showcase-faq-section-accordion smk_accordion acc_with_icon">
							<div class="accordion_in">
							   <div class="acc_head">
								  <div class="acc_icon_expand"></div>
								  <div class="title">
									 How Do I Get Needed Medical Care?								
								  </div>
							   </div>
							   <div class="acc_content" style="display: none;">
								  <div class="editor-content">
									 <p>It can be extremely challenging to get the medical care you need following an injury.&nbsp; Failing to do so can not only prevent you from healing properly but it can also hurt your legal recovery.</p>
									 <p>Injury victims may not seek necessary medical treatment for a variety of reasons.&nbsp; They may not know of a good doctor that can help them.&nbsp; They might not have transportation to get to appointments.&nbsp; Frequently, an injury victim may not have medical insurance to pay health care providers.</p>
									 <p>We can help by recommending top-rated physicians and coordinating appointments.&nbsp; We will assist clients in getting to medical appointments if they do not have transportation.&nbsp; We also have a number of strategies that may allow you to get immediate medical care with no up-front charges, even if you do not have health insurance.&nbsp;</p>
									 <p>Do not skip critical medical care -- contact us so we can help.</p>
								  </div>
								  <div class="showcase-faq-button">
									 <a class="tmf-button" href="#tmf-popup-form">Contact Us</a>
								  </div>
							   </div>
							</div>
							<div class="accordion_in">
							   <div class="acc_head">
								  <div class="acc_icon_expand"></div>
								  <div class="title">
									 Is Your Legal Help  Expensive?  								
								  </div>
							   </div>
							   <div class="acc_content" style="display: none;">
								  <div class="editor-content">
									 <p>No one should be denied justice because they cannot afford a lawyer.&nbsp;</p>
									 <p>If we accept your case, you pay nothing out-of-pocket.&nbsp; It costs nothing for us to get started and we advance all expenses of your case.&nbsp; Over the years, we have advanced millions of dollars in case expenses for court filing fees, hiring expert consultants, and preparing cases.</p>
									 <p>With our Zero Fee Promise, you pay us nothing unless we are successful in recovering money for you.&nbsp; This includes all of the expenses we pay to third-parties while preparing your case.&nbsp; Put simply, you owe us nothing unless we win.</p>
								  </div>
								  <div class="showcase-faq-button">
									 <a class="tmf-button" href="#tmf-popup-form">Contact Us</a>
								  </div>
							   </div>
							</div>
							<div class="accordion_in">
							   <div class="acc_head">
								  <div class="acc_icon_expand"></div>
								  <div class="title">
									 Is the Process Difficult?								
								  </div>
							   </div>
							   <div class="acc_content" style="display: none;">
								  <div class="editor-content">
									 <p>Our goal is to get the best result possible with as little work from our clients as possible.&nbsp; Our legal team and staff manage all legal matters so our clients can concentrate on getting their life back together.&nbsp;</p>
									 <p>We conduct all interactions with the insurance company and their lawyers.&nbsp; We can work with you by email, telephone, text, or Zoom – depending on what’s most convenient for <strong><u>you</u></strong>.&nbsp; We can text or email you any document, and anything which requires a signature can be done electronically through a mobile phone.&nbsp;</p>
									 <p>Many times, our clients have settled their case without ever leaving home.&nbsp; &nbsp;While this isn’t possible in every case, we work tirelessly to make sure you don’t have to.</p>
								  </div>
								  <div class="showcase-faq-button">
									 <a class="tmf-button" href="#tmf-popup-form">Contact Us</a>
								  </div>
							   </div>
							</div>
							<div class="accordion_in">
							   <div class="acc_head">
								  <div class="acc_icon_expand"></div>
								  <div class="title">
									 Will I Need to Go to Court?								
								  </div>
							   </div>
							   <div class="acc_content" style="display: none;">
								  <div class="editor-content">
									 <p>The vast majority of cases settle without our clients setting foot inside a court room.&nbsp;</p>
									 <p>We take pride in our skills as trial lawyers and will not hesitate to take your case to trial when necessary. However, the insurance companies know our commitment to using every resource to get our clients the result they deserve.&nbsp;</p>
									 <p>Our willingness to fight for our clients at trial is one of the reasons we seldom have to.&nbsp;</p>
								  </div>
								  <div class="showcase-faq-button">
									 <a class="tmf-button" href="#tmf-popup-form">Contact Us</a>
								  </div>
							   </div>
							</div>
						 </div>
					  </div>
					  <!-- Mobile View End-->
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>

	<div id="featured-and-recognized-wrapper" class="section-wrapper">
	   <div id="featured-and-recognized-container" class="section-container">
		  <div id="featured-and-recognized" class="section">
			 <div id="featured-and-recognized-row" class="row collapse-1050 ">
				<div id="featured-and-recognized-cell-1" class="cell span-24">
				   <div class="inner">
					  <div class="tmf-module-area tmf-single-module-area tmf-module-area-featured-and-recognized">
						 <div class="tmf-module tmf-module-941 tmf-module-featured-&amp;-recognized">
							<h3 class="tmf-module-title">
							   Featured &amp; Recognized
							</h3>
							<div class="tmf-module-content editor-content">
							   <div class="bx-wrapper" style="max-width: 1420px;">
								  <div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 135px;">
									 <div class="featured-slider" style="width: 6215%; position: relative; transition-duration: 17.8472s; transform: translate3d(-1440px, 0px, 0px); transition-timing-function: linear;">
										<div class="slide" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-738" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_usa_today_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_usa_today_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_usa_today_3x.png 3x" alt="" width="171" height="78"></div>
										<div class="slide" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-729" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_msnbc_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_msnbc_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_msnbc_3x.png 3x" alt="" width="172" height="120"></div>
										<div class="slide" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-717" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_cbs_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_cbs_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_cbs_3x.png 3x" alt="" width="165" height="91"></div>
										<div class="slide" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-732" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_mtv_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_mtv_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_mtv_3x.png 3x" alt="" width="172" height="132"></div>
										<div class="slide" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-720" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_chicago_tribune_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_chicago_tribune_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_chicago_tribune_3x.png 3x" alt="" width="171" height="103"></div>
										<div class="slide" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-735" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_region_news_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_region_news_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_region_news_3x.png 3x" alt="" width="171" height="104"></div>
										<div class="slide bx-clone" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-738" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_usa_today_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_usa_today_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_usa_today_3x.png 3x" alt="" width="171" height="78"></div>
										<div class="slide bx-clone" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-729" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_msnbc_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_msnbc_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_msnbc_3x.png 3x" alt="" width="172" height="120"></div>
										<div class="slide bx-clone" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-717" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_cbs_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_cbs_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_cbs_3x.png 3x" alt="" width="165" height="91"></div>
										<div class="slide bx-clone" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-732" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_mtv_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_mtv_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_mtv_3x.png 3x" alt="" width="172" height="132"></div>
										<div class="slide bx-clone" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-720" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_chicago_tribune_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_chicago_tribune_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_chicago_tribune_3x.png 3x" alt="" width="171" height="103"></div>
										<div class="slide bx-clone" style="float: left; list-style: none; position: relative; width: 220px; margin-right: 20px;"><img class="alignnone size-full wp-image-735" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_region_news_1x.png" srcset="https://www.wp-law.com/wp-content/uploads/2020/10/logo_region_news_2x.png 2x, https://www.wp-law.com/wp-content/uploads/2020/10/logo_region_news_3x.png 3x" alt="" width="171" height="104"></div>
									 </div>
								  </div>
							   </div>
							</div>
						 </div>
					  </div>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>

<?php $tmf->block('bottom')->render() ?>
<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * The default template for the front page.
 * 
 * @package TheModernFirmFramework
 * @category Templates
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2013 The Modern Firm, LLC
 */
?>

<?php $tmf->block('top')->render() ?>

	<?php $tmf->block('sections/home-contact')->render() ?>

	<?php $section = $tmf->section('home-body') ?>
		<div class="proven-results-mobile">
			<?php $tmf->block('sections/proven-results')->render() ?>
		</div>
		<div class="section-title-wrapper">
			<div class="section-title">
				<div class="section-title-inner">
					<h3 class="tmf-module-title help-desktop"><span>We Can Help</span></h3>
					<div class="help-mobile">
					  <h3 class="mobile-heading">How We Can Help</h3>
					  <hr class="yellow"/>
					</div>
					
				</div>
			</div>
		</div>

		<?php $row = $tmf->row('home-body', 850) ?>

			<?php $row->cell(24) ?>

				<?php if ($tmf->has_posts()): ?>
					<?php $tmf->posts()->template('home')->render() ?>
				<?php endif ?>

				<div class="we-can-help-image">
					<?php if ($post->tmf->has_primary_image()) : ?>
						<?php 
		                    $high_res = '';
		                    $logo_path = get_attached_file($post->tmf->primary_image); 
		                    $image = $tmf->image_url_from_id($post->tmf->primary_image);
		                    $logo_2x = str_replace('3x', '2x', $logo_path);
		                    $logo_1x = str_replace('3x', '1x', $logo_path);
		                    $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
		                    $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

		                    $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
		                ?>
						<img  src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" />
					<?php endif; ?>
				</div>

		<?php $row->close() ?>	

	<?php $section->close() ?>
	<div class="desktop-view">
		<?php $tmf->block('sections/we-can-help')->render() ?>
	</div>

	<div class="mobile-view">
		<div id="we-can-help" class="we-can-help-bottom-item first">
			<div class="inner">
				<div class="we-can-help-bottom-item-col-1">
					<a href="http://wplaw.local/zero-fee-promise/"><img class="alignnone wp-image-684 size-full" src="/wp-content/uploads/2020/10/logo_zero_fee_promise_1x.png" alt="Best Personal Injury Attorneys" width="196" height="137" />
					</a>
				</div>
				<div class="we-can-help-bottom-item-col-2">
					<h5>We make every client a written guarantee: we will recover for you or our work is free.</h5>
				</div>
			</div>
		</div>
	</div>

	<div class="home-desktop-proven-results">
		<?php $tmf->block('sections/proven-results')->render() ?>
	</div>

	<?php $tmf->block('sections/what-we-do')->render() ?>

  	<?php /* $tmf->block('sections/common-questions')->render() */ ?>

	<div id="reviews-slider" class="mobile-view">
		<h3 class="mobile-heading">Reviews</h3>
		<hr class="yellow"/>
		<?php get_template_part('template-parts/reviews-slider'); ?>
	</div>
		

	<?php /***** "SOME COMMON QUESTIONS" SECTION *****/ ?>
	<div id="common-questions-wrapper" class="section-wrapper">
	   <div id="common-questions-container" class="section-container">
		  <div id="common-questions" class="section">
			 <div id="common-questions-row" class="row collapse-1050 ">
				<div id="common-questions-cell-1" class="cell span-9">
				   <div class="inner">
					  <div class="common-questions-keith-img">
						 <img src="https://www.wp-law.com/wp-content/themes/mod-premium/wp-law/assets/images/keith_1x.png" srcset="https://www.wp-law.com/wp-content/themes/mod-premium/wp-law/assets/images/keith_2x.png 2x, https://www.wp-law.com/wp-content/themes/mod-premium/wp-law/assets/images/keith_3x.png 3x" alt="">
					  </div>
				   </div>
				</div>
				<div id="common-questions-cell-2" class="cell span-15">
				   <div class="inner">
					  <div class="tmf-module-area tmf-single-module-area tmf-module-area-common-questions">
						 <div class="tmf-module tmf-module-937 tmf-module-common-questions">
							<div class="tmf-module-content editor-content">
							   <h3 class="desktop-view">Some Common Questions</h3>
							   <h3 class="mobile-view mobile-heading">Some Common Questions</h3>
							   <hr class="yellow mobile-view"/>
							   <p></p>
							   <div class="tmf-post-list small smk_accordion acc_with_icon">
								  <div class="tmf-post tmf-post-1378 common-question small first-post accordion_in">
									 <div class="acc_head">
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="title"> What is my True Case Value™? </div>
									 </div>
									 <div class="acc_content" style="display: none;">
										<div class="editor-content">
										   <p>Every injury case has a true value that includes many factors an insurance company is unlikely to tell you about. We have spent decades developing our system for determining the True Case Value™ of an injury victim’s claim. We can provide a full case evaluation in minutes, free of charge.</p>
										</div>
									 </div>
								  </div>
								  <div class="tmf-post tmf-post-1380 common-question small middle-post accordion_in">
									 <div class="acc_head">
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="title"> Should I sign papers given to me by an insurance company? </div>
									 </div>
									 <div class="acc_content" style="display: none;">
										<div class="editor-content">
										   <p>Never sign any document from an insurance company without first having it reviewed by a qualified attorney. You could be giving up important legal rights. Contact us and we will review any insurance document, without any obligation.</p>
										</div>
									 </div>
								  </div>
								  <div class="tmf-post tmf-post-1382 common-question small middle-post accordion_in">
									 <div class="acc_head">
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="title"> Should I give a statement to an insurance adjuster? </div>
									 </div>
									 <div class="acc_content" style="display: none;">
										<div class="editor-content">
										   <p>Do not give a statement to an insurance adjuster without first talking to an injury lawyer. What you say could jeopardize your legal rights. In certain situations, however, refusing to give a statement could result in a loss of your right to insurance coverage. Tell us about your specific situation and we will let you know how best to proceed.</p>
										</div>
									 </div>
								  </div>
								  <div class="tmf-post tmf-post-1384 common-question small middle-post accordion_in">
									 <div class="acc_head">
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="title"> How quickly do I need to act before I lose my rights? </div>
									 </div>
									 <div class="acc_content" style="display: none;">
										<div class="editor-content">
										   <p>Nearly all injury claims have a “statute of limitations” requiring you to act or lose your rights. Depending on the nature of the claim, this could be as little as 179-days or less. Waiting too long not only risks losing important evidence, it could result in your losing your legal claim entirely.</p>
										</div>
									 </div>
								  </div>
								  <div class="tmf-post tmf-post-1386 common-question small middle-post accordion_in">
									 <div class="acc_head">
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="title"> Will I recover more if I represent myself? </div>
									 </div>
									 <div class="acc_content" style="display: none;">
										<div class="editor-content">
										   <p>Usually not. One auto insurance study found that, on average, injury victims represented by lawyers recovered <strong>3x</strong> more money than those that represented themselves – even after paying legal fees. Every case is different, though, and there <u>are</u> circumstances where it doesn’t make sense to hire a lawyer. If we don’t think you’ll recover more with a lawyer, we’ll tell you. </p>
										</div>
									 </div>
								  </div>
								  <div class="tmf-post tmf-post-1580 common-question small last-post accordion_in">
									 <div class="acc_head">
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="acc_icon_expand"></div>
										<div class="title"> What's My Case Worth? </div>
									 </div>
									 <div class="acc_content" style="display: none;">
										<div class="editor-content"> This is one of the most common questions. Although the insurance company may know the value of your case, their goal is to pay you as little as possible -- and they will not tell you what your case is really worth. Every single case is different and its value depends on many different factors, ranging from your type of injury to the state and county where you were injured. We have developed methods for evaluating a client’s True Case Value™ over decades of handling personal injury cases. We can help you determine the value of your injury claim in minutes. 
										</div>
									 </div>
								  </div>
							   </div>
							   <p></p>
								<h3 class="desktop-view">What’s your question? <a class="tmf-button" href="#tmf-popup-form">Get the Answer</a></h3>
							</div>
						 </div>
					  </div>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>

	<div class="mobile-view free-case-evaluation">
		<h3 class="mobile-heading">
		Get a Free Case Evaluation
		</h3>
		<?php echo do_shortcode( '[gravityform id="3" title="false" description="false" ajax="true"]' ); ?>
	</div>
	

	<?php $tmf->block('sections/attorneys-section')->render() ?>

	<div id="we-can-help" class="mobile-view">
	  <div class="we-can-help-top-item">
		<div class="we-can-help-top-item-col-1">
		  <img class="alignnone size-full wp-image-672" src="/wp-content/uploads/2020/10/icon_help_without_leaving_1x.png" srcset="/wp-content/uploads/2020/10/icon_help_without_leaving_2x.png 2x, /wp-content/uploads/2020/10/icon_help_without_leaving_3x.png 3x" alt="Personal Injury Lawyers" width="131" height="115" />
		</div>
		<div class="we-can-help-top-item-col-2">
		  <h3>Help Without Leaving Home</h3>
		  <p>We can take your case without you ever leaving home. Get a free case evaluation by <a href="tel:219-322-1166"><strong>phone</strong></a>, <a href="sms:12193352098">text</a>, or submitting a short <a href="#tmf-popup-form"><strong>form</strong></a>. You’ll get answers in minutes and we can start work the same day.</p>
		</div>
	  </div>
	  <div class="we-can-help-top-item">
		<div class="we-can-help-top-item-col-1">
		  <img class="alignnone size-full wp-image-675" src="/wp-content/uploads/2020/10/icon_we_fight_to_recover_1x.png" srcset="/wp-content/uploads/2020/10/icon_we_fight_to_recover_2x.png 2x, /wp-content/uploads/2020/10/icon_we_fight_to_recover_3x.png 3x" alt="" width="120" height="122" />
		</div>
		<div class="we-can-help-top-item-col-2">
		  <h3>We fight to recover more with less work from you.</h3>
		  <p>We take over the entire legal process so you can concentrate on healing. One insurance industry study found, on average, people represented by lawyers recovered 3x more than those without.</p>
		</div>
	  </div>
		<div class="we-can-help-bottom-item last">
		  <div class="inner">
			<div class="we-can-help-bottom-item-col-1">
			  <a href="tel:219-322-1166">
				<img class="alignnone wp-image-681 size-full" src="https://www.wp-law.com/wp-content/uploads/2020/10/logo_24-7_1x.png" alt="Top-Rated Injury Lawyers" width="100" height="97" />
			  </a>
			</div>
			<div class="we-can-help-bottom-item-col-2">
			  <h3>Standing with you 24/7/365</h3>
			  <p>Justice never sleeps and neither should your legal team.  Just <a href="tel:219-322-1166"><strong>call</strong></a> or <strong><a href="sms:12193352098">text</a> </strong>us 24 hours a day and you’ll get a real person ready to help.</p>
			</div>
		  </div>
		</div>
	</div>

	<div id="home-contact-bottom" class="mobile-view">
		<h3 class="mobile-heading">
			Contact Us
		</h3>
		<hr class="yellow"/>
		<div class="call-box">
			<a href="tel:+12193221166">
				<p class="call">Call 219-322-1166</p>
				<p class="small">To Get Help Right Away</p>
			</a>
		</div>
		
		
		<div class="call-btn">
			<a href="sms:+12193221166" class="btn">TEXT FOR A FREE CASE EVALUATION</a>
		</div>
	</div>

	<?php /***** SHOWCASE FAQ SECTION *****/ ?>
	<div id="showcase-faq-section-wrapper" class="desktop-view section-wrapper">
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
                           <h2 class="resp-accordion hor_1 resp-tab-active" role="tab" aria-controls="hor_1_tab_item-0" style="background: none;"><span class="resp-arrow"></span>How Do I Get Needed Medical Care?How Do I Get Needed Medical Care?</h2>
                           <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-1"><span class="resp-arrow"></span>Is Your Legal Help  Expensive?  </h2>
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
                           <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-2"><span class="resp-arrow"></span>Is Your Legal Help  Expensive?  Is the Process Difficult?</h2>
                           <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-3"><span class="resp-arrow"></span>Will I Need to Go to Court?</h2>
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
                           <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-4"><span class="resp-arrow"></span>Is the Process Difficult?</h2>
                           <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-5"><span class="resp-arrow"></span></h2>
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
                           <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-6"><span class="resp-arrow"></span>Will I Need to Go to Court?</h2>
                           <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-7"><span class="resp-arrow"></span></h2>
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

		<?php $tmf->block('sections/featured-and-recognized')->render() ?>
	
	<div id="other-resources" class="mobile-view">
		<h3 class="mobile-heading white">Other Resources</h3>
		<hr class="yellow"/>
			<div class="btns">
				<a href="/zero-fee-promise/" class="btn">Our Zero Fee Promise</a>
				<a href="/attorneys/" class="btn">Our Team</a>
				<a href="/contact-us/" class="btn btn-red">GET ANSWERS NOW</a>
			</div>
	</div>

<?php $tmf->block('bottom')->render() ?>
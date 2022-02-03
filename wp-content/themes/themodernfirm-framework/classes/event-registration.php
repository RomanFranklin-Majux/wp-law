<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_EventRegistration {

	private $post;
	private static $enabled = FALSE;


	public function __construct($post) {
		$this->post = $post;
	}


	public static function factory ($post) {
		return new TMF_EventRegistration($post);
	}


	public static function enable() {
		if (isset(TMF_PostType::$loaded_types['event'])):
			TMF_PostType::$loaded_types['event']->metaboxes['event-registration'] = array();
			self::$enabled = TRUE;
		endif;
	}


	public static function is_enabled () {
		return self::$enabled;
	}


	public function render () {
		if (self::is_enabled() && $this->post->has_registration())
			$this->html();
	}


	private function html () {
		global $tmf;
		?>
			<script src="https://www.wufoo.com/scripts/embed/form.js"></script>
			<form id="registration" class="event-registration editor-content">

				<h2>Registration For: '<?php echo $this->post->title ?>'</h2>
				
				<div class="step-1">
					<div class="attendees">
						<div class="attendee">
							<h3>Attendee #<span class="attendee-number">1</span><span class="remove">Remove</span></h3>
							<div class="field">
								<label>Registration Type</label>
								<select class="payment-option">
									<?php foreach ($this->post->registration_payment_options as $payment_option): ?>
										<option value="<?php echo $payment_option['name'] ?> ($<?php echo $payment_option['price'] ?>)" data-amount="<?php echo $payment_option['price'] ?>"><?php echo $payment_option['name'] ?> ($<?php echo $payment_option['price'] ?>)</option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="field required">
								<label>Name</label>
								<input type="text" />
							</div>
							<div class="field required">
								<label>Email</label>
								<input type="text" />
							</div>
							<div class="field required">
								<label>Phone Number</label>
								<input type="text" />
							</div>
							<div class="field required">
								<label>Business Name</label>
								<input type="text" />
							</div>

							<?php foreach ($this->post->registration_questions as $question): ?>
								<div class="field <?php if ($question['required']) echo 'required' ?>">
									<label><?php echo $question['name'] ?></label>
									<input type="text" />
								</div>
							<?php endforeach ?>
						</div>
					</div>
					
					<span id="add-attendee" class="tmf-button small">Add Another Attendee</span>
					<div class="payment-button-box">
						<span class="next-step tmf-button large" data-payment="credit">Pay via Credit Card</span>
						<span class="next-step tmf-button large" data-payment="check">Pay via Check</span>
					</div>
				</div>

				<div class="step-2">
					<h3>Registration Summary</h3>
					<div class="info">
						<div class="label">Event: </div>
						<div class="event-title"></div>
					</div>
					<div class="info">
						<div class="label">Date: </div>
						<div class="event-date"></div>
					</div>
					<div class="info">
						<div class="label">Total: </div>
						<div class="registration-total"></div>
					</div>
					<div class="info">
						<div class="label">Attendee Summary: </div>
						<div class="attendee-summary"></div>
					</div>
					<div id="wufoo-registration-form"></div>	
					<div class="payment-button-box">
						<span class="previous-step tmf-button small" data-payment="credit">Go Back</span>
						<span class="start-over tmf-button small" data-payment="credit">Start Over</span>
					</div>				
				</div>

				<div id="attendee-template" class="attendee">
					<h3>Attendee #<span class="attendee-number"></span><span class="remove">Remove</span></h3>
					<div class="field">
						<label>Registration Type</label>
						<select class="payment-option">
							<?php foreach ($this->post->registration_payment_options as $payment_option): ?>
								<option value="<?php echo $payment_option['name'] ?> ($<?php echo $payment_option['price'] ?>)" data-amount="<?php echo $payment_option['price'] ?>"><?php echo $payment_option['name'] ?> ($<?php echo $payment_option['price'] ?>)</option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="field required">
						<label>Name</label>
						<input type="text" />
					</div>
					<div class="field required">
						<label>Email</label>
						<input type="text" />
					</div>
					<div class="field required">
						<label>Phone Number</label>
						<input type="text" />
					</div>
					<div class="field required">
						<label>Business Name</label>
						<input type="text" />
					</div>

					<?php foreach ($this->post->registration_questions as $question): ?>
						<div class="field <?php if ($question['required']) echo 'required' ?>">
							<label><?php echo $question['name'] ?></label>
							<input type="text" />
						</div>
					<?php endforeach ?>
				</div>

				<script>
					jQuery(document).ready(function($) {
						var event_registration_name = '<?php echo $this->post->title ?>';
						var event_registration_date = '<?php echo $this->post->formatted_start_date() ?>';
						var credit_form = '<?php echo $tmf->option()->registration_form_credit ?>';
						var check_form = '<?php echo $tmf->option()->registration_form_check ?>';
						var event_field = '<?php echo $tmf->option()->registration_form_field_event ?>';
						var date_field = '<?php echo $tmf->option()->registration_form_field_date ?>';
						var summary_field = '<?php echo $tmf->option()->registration_form_field_summary ?>';
						var amount_field = '<?php echo $tmf->option()->registration_form_field_amount ?>';

						$('#add-attendee').on('click', function(){
							var attendee = $('#attendee-template').clone().removeAttr('id').appendTo('.event-registration .attendees');
							$('.event-registration .attendees .attendee:last-child .attendee-number').html($('.event-registration .attendees .attendee').length);
						});

						$('.next-step').on('click', function(){
							if (tmf_registration_validation()) {
								var summary = tmf_registration_summary();
								var total = tmf_registration_total();

								form = ($(this).data('payment') == 'credit') ? credit_form : check_form;

								tmf_registration_create_wufoo_form(form, total, event_registration_name, summary, event_registration_date);

								$('.step-1').hide();
								$('.step-2').show();

								$('.event-title').html(event_registration_name);
								$('.event-date').html(event_registration_date);
								$('.registration-total').html('$' + total);
								$('.attendee-summary').html(summary.replace(/(?:\r\n|\r|\n)/g, '<br />'));

								$('html, body').animate({
							        scrollTop: $("#registration").offset().top - 50
								}, 250);
							}
						});

						$('.previous-step').on('click', function(){
							$('.step-2').hide();
							$('.step-1').show();
						});

						$('.start-over').on('click', function(){
							location.reload();
						});

						$('.attendees').on('click', '.remove', function(){
							var count = 1;
							$(this).parents('.attendee').remove();
							$('.attendee').each(function(){
								$(this).find('.attendee-number').html(count);
								count++;
							});
						});

						function tmf_registration_summary () {
							var summary = '';
							var count = 1;

							$('.event-registration .attendees .attendee').each(function(){
								summary += 'Attendee ' + count + '\r';
								$(this).find('input, select').each(function(){
									var label = $(this).parent().find('label').html();
									summary += label + ': ' + $(this).val() + '\r';
								});
								summary += '\r';
								count++;
							});

							return summary;
						}

						function tmf_registration_total () {
							var total = 0;

							$('.event-registration .attendees .payment-option option:selected').each(function(){
								total += parseInt($(this).data('amount'), 10);
							});

							return parseFloat(Math.round(total * 100) / 100).toFixed(2);
						}

						function tmf_registration_validation () {
							$('.registration-error').remove();

							$('.event-registration .attendees .field.required input').attr('style', '').each(function(){
								if ($(this).val() == ''){
									$(this).css({borderColor: '#F00'});
									$(this).after('<span class="registration-error" style="display: inline-block; margin-left: 10px;color: #f00">Required</span>');
								}
							});

							if ($('.registration-error').length !== 0){
								$('.event-registration h2').after('<p class="registration-error" style="color: #F00;">Please make sure you have entered all the required fields.</p>');
								$('html, body').animate({
							        scrollTop: $("#registration").offset().top - 50
								}, 250);

								return false;
							} 

							return true;
						}

						function tmf_registration_create_wufoo_form (form_id, amount, event, summary, date){
							var wufoo_options = {
								userName: 'websitecontact',
								formHash: form_id,
								autoResize: true,
								height: '300',
								async: true,
								host: 'wufoo.com',
								header: 'hide',
								ssl: true,
								defaultValues : amount_field + '=' + encodeURIComponent(amount) + '&'+ event_field +'=' + encodeURIComponent(event) + '&'+ date_field +'=' + encodeURIComponent(date) + '&'+ summary_field +'=' + encodeURIComponent(summary)
							};

							$('#wufoo-registration-form').html('<div id="wufoo-'+ form_id +'"></div>');
							form = new WufooForm();
							form.initialize(wufoo_options);
							form.display();
						}
					});
				</script>

			</form>
		<?php
	}

}

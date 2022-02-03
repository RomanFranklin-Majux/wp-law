<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Event Registration
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_EventRegistration extends TMF_Metabox {

	protected $metabox_name		= 'event_registration';
	protected $metabox_title	= 'Event Registration Settings';


	public function before_save() {
		$extra = $this->post_data(TRUE);

		$payment_options = array();

		if (!empty($extra->_registration_payment_options)):
			foreach ($extra->_registration_payment_options as $option):
				$price = str_replace(array('$', ' ', ','), '', $option['price']);
				$payment_options[] = array(
					'name' => $option['name'],
					'price'	=> number_format((float)$price, 2, '.', '')
				);
			endforeach;
		endif;

		update_post_meta($this->post->ID, '_registration_payment_options', $payment_options);

		$registration_questions = array();

		if (!empty($extra->_registration_questions)):
			foreach ($extra->_registration_questions as $option):
				$registration_questions[] = array(
					'name' => $option['question'],
					'required'	=> ($option['required'] === '1') ? TRUE : FALSE
				);
			endforeach;
		endif;

		update_post_meta($this->post->ID, '_registration_questions', $registration_questions);

		$end_date = strtotime($extra->_registration_end_date . ' ' . $extra->_registration_end_hour . ':' . $extra->_registration_end_minute . $extra->_registration_end_ampm);

		$this->update_post_data('registration_end_date', $end_date);
	}


	public function render() {
		global $tmf;
		?>
			<h3>General Settings</h3>
			<table class="tmf-metabox">
				<tbody>
					<tr>
						<td scope="row">
							<?php $this->label('Enable Registration', 'registration_enabled') ?>
						</td>
						<td>
							<?php $this->checkbox('registration_enabled') ?>
							<?php $this->label('Enable Registration', 'registration_enabled') ?>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<?php $this->label('Registration Ends', 'registration_end_date') ?>
						</td>
						<td id="registration-end-date">
							<?php $end_date	= $this->post->_registration_end_date ? $this->post->_registration_end_date : time() + 3600; ?>
							<?php $this->text('registration_end_date', 'x-small datepicker', date('m/d/Y', $end_date), TRUE) ?>
							<?php $this->selectbox('registration_end_hour', TMF_Time::$hours, NULL, date('h', $end_date), NULL, TRUE) ?>:
							<?php $this->selectbox('registration_end_minute', TMF_Time::$minutes, NULL, date('i', $end_date), NULL, TRUE) ?>
							<?php $this->selectbox('registration_end_ampm', TMF_Time::$ampm, NULL, date('A', $end_date), NULL, TRUE) ?>
						</td>
					</tr>
				</tbody>
			</table>
			
			<br />
			<h3>Payment Options</h3>
			<div id="event-registration-payment-options">

				<?php $payment_options = get_post_meta($this->post->ID, '_registration_payment_options', TRUE) ?>
				<?php if (!empty($payment_options)): $count = 0; ?>
					<?php foreach ($payment_options as $payment_option): ?>
						<div class="payment-option" data-id="<?php echo $count ?>">
							<span class="name-label">Name</span><input type="text" class="payment-name" name="TMF_x[event_registration][_registration_payment_options][<?php echo $count ?>][name]" value="<?php echo $payment_option['name'] ?>" />
							<span class="price-label">Price</span><input type="text" class="payment-price" name="TMF_x[event_registration][_registration_payment_options][<?php echo $count ?>][price]" value="<?php echo $payment_option['price'] ?>" />
							<span class="delete">X</span>
						</div>
					<?php $count++; endforeach ?>
				<?php endif ?>
			</div>

			<span id="add-payment-option" class="button-primary" style="margin-top: 15px;">Add Payment Option</span>

			<script>
				jQuery(document).ready(function($) {
					$('#add-payment-option').on('click', function(){
						var count = ($('#event-registration-payment-options .payment-option').length === 0)  ? 0 : $('#event-registration-payment-options .payment-option:last').data('id') + 1;
						var html = [
							'<div class="payment-option" data-id="'+ count +'">',
								'<span class="name-label">Name</span><input type="text" class="payment-name" name="TMF_x[event_registration][_registration_payment_options]['+ count +'][name]" />',
								'<span class="price-label">Price</span><input type="text" class="payment-price" name="TMF_x[event_registration][_registration_payment_options]['+ count +'][price]" />',
								'<span class="delete">X</span>',
							'</div>'
						];
						$('#event-registration-payment-options').append(html.join('\n'));
					});

					$('#event-registration-payment-options').on('click', '.delete', function(){
						$(this).parent().remove();
					});
				});
			</script>
			
			<br /><br />
			<h3>Question Options</h3>
			<div id="event-registration-questions">

				<?php $registration_questions = get_post_meta($this->post->ID, '_registration_questions', TRUE) ?>
				<?php if (!empty($registration_questions)): $count = 0; ?>
					<?php foreach ($registration_questions as $question): ?>
						<div class="question-option" data-id="<?php echo $count ?>">
					<span class="question-label">Question</span><input type="text" class="question" name="TMF_x[event_registration][_registration_questions][<?php echo $count ?>][question]" value="<?php echo $question['name'] ?>" />
					<input type="hidden" name="TMF_x[event_registration][_registration_questions][<?php echo $count ?>][required]" value="0" />
					<input type="checkbox" class="question-price" name="TMF_x[event_registration][_registration_questions][<?php echo $count ?>][required]" value="1" <?php if ($question['required']) echo 'checked="checked"' ?>/><label>Required?</label>
					<span class="delete">X</span>
				</div>
					<?php $count++; endforeach ?>
				<?php endif ?>
			</div>

			<span id="add-question-option" class="button-primary" style="margin-top: 15px;">Add Question</span>

			<script>
				jQuery(document).ready(function($) {
					$('#add-question-option').on('click', function(){
						var count = ($('#event-registration-questions .question-option').length === 0) ? 0 : $('#event-registration-questions .question-option:last').data('id') + 1;
						var html = [
							'<div class="question-option" data-id="'+ count +'">',
								'<span class="question-label">Question</span><input type="text" class="question" name="TMF_x[event_registration][_registration_questions]['+ count +'][question]" />',
								'<input type="hidden" name="TMF_x[event_registration][_registration_questions]['+ count +'][required]" value="0" />',
								'<input type="checkbox" class="question-price" name="TMF_x[event_registration][_registration_questions]['+ count +'][required]" value="1" /><label>Required?</label>',
								'<span class="delete">X</span>',
							'</div>'
						];
						$('#event-registration-questions').append(html.join('\n'));
					});

					$('#event-registration-questions').on('click', '.delete', function(){
						$(this).parent().remove();
					});
				});
			</script>

		<?php
	}

}

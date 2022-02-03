<?php 
	$business_name = $tmf->wp_option()->blogname;

	if (!empty($visa) || !empty($mastercard) || !empty($discover) || !empty($american_express) || !empty($paypal)): 
?>
	<span class="payment-icons">

		<?php if (!empty($visa)): ?>
			<span class="visa" title="<?php echo $business_name ?> accepts Visa"></span>			
		<?php endif ?>

		<?php if (!empty($mastercard)): ?>
			<span class="mastercard" title="<?php echo $business_name ?> accepts Mastercard"></span>			
		<?php endif ?>

		<?php if (!empty($discover)): ?>
			<span class="discover" title="<?php echo $business_name ?> accepts Discover Card"></span>			
		<?php endif ?>

		<?php if (!empty($american_express)): ?>
			<span class="american-express" title="<?php echo $business_name ?> accepts American Express"></span>			
		<?php endif ?>

		<?php if (!empty($paypal)): ?>
			<span class="paypal" title="<?php echo $business_name ?> accepts PayPal"></span>			
		<?php endif ?>

	</span>
<?php endif ?>
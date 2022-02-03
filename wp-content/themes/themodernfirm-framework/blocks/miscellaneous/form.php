<div id="wufoo-<?php echo $formhash ?>" class="tmf-shortcode form">
	<?php if ($placeholder): ?>
		<div class="form-placeholder"><?php echo $placeholder ?></div>
	<?php else: ?>
		<div class="form-placeholder">Fill out our <a href="http://websitecontact.wufoo.com/forms/<?php echo $formhash ?>">online form</a></div>
	<?php endif ?>
</div>
<script type="text/javascript">
	var $formhash;(function(d, t) {
		var s = d.createElement(t), 
			options = {
				userName      : '<?php echo $username ?>',  
				formHash      : '<?php echo $formhash ?>',  
				autoResize    : true,
				height        : '500',
				async         : true,
				header        : 'hide',
				defaultValues : '<?php echo $default_values ?>',
				ssl           : true,
				host		  : 'wufoo.com'
			};

		s.src = ('https:' == d.location.protocol ? 'https://' : 'http://') + 'secure.wufoo.com/scripts/embed/form.js';
		s.onload = s.onreadystatechange = function() {
		var rs	= this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;
		try { $formhash = new WufooForm();$formhash.initialize(options);$formhash.display(); } catch (e) {}};
		var scr	= d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);
	})(document, 'script');
</script>
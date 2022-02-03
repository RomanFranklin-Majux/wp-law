<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * A template for a fatal error. It should be impossible to
 * see this page on a production site. 
 * 
 * @package TheModernFirmFramework
 * @category Templates
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Modern Firm Framework v<?php echo FRAMEWORK_VERSION ?></title>
	<style>

		body {
			color: #5e522c;
		}
		
		#container {
			margin: 35px;
		}

		#header {
			padding-bottom: 25px;
			border-bottom: 4px solid #b54225;
			color: #6f6237;
		}

		#framework {
			float: right;
			margin-top: 22px;
			font-size: .9em;
			text-align: right;
		}

		h2 {
			font-size: 1.3em;
			margin: 0 0 15px 0;
			text-transform: uppercase;
			font-weight: 400;
			color: #312a17;
		}

		#error {
			padding: 35px 0 100px;
			border-bottom: 4px solid #e3e1da;
		}

		#copyright {
			text-align: center;
			margin-top: 25px;
			font-size: .9em;
		}

		@media screen and (max-width: 600px) {
			#container {
				margin: 35px 0;
			}

			#error {
				padding: 35px 10px 100px;
			}
			
			#header {
				text-align: center;
			}

			#framework {
				margin-top: 5px;
				float: none;
				text-align: center;
			}
		}

	</style>
</head>
<body>
	<div id="container">
		<div id="header">
			<img id="logo" src="<?php echo FRAMEWORK_URI . IMAGES_PATH . 'logo-tmf-300x77.png' ?>">
			<div id="framework">
				Framework v<?php echo FRAMEWORK_VERSION ?><br/>
				Wordpress v<?php echo WP_VERSION ?>
			</div>
		</div>

		<div id="error">
			<h2>Fatal Error</h2>
			<div class="message">
				<p>We're sorry. A fatal error has occurred. Please try your request again later.</p>
				<p>If you continue to receive this message, please contact <a href="mailto:support@themodernfirm.com">support@themodernfirm.com</a>.</p>
			</div>
		</div>

		<div id="copyright">
			Copyright © <?php echo date('Y') ?> The Modern Firm, LLC
		</div>

	</div>
</body>
</html>

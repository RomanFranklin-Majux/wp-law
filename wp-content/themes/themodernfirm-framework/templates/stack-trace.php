<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * A stack trace template for a fatal error. This should only be shown in a 
 * development environment as it contains sensitive information.
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

		#exception {
			padding: 35px 0;
			border-bottom: 4px solid #e3e1da;
		}

		#stack-trace {
			padding: 35px 0 100px;
			border-bottom: 4px solid #e3e1da;
		}

		.trace {
			background-color: #f5f3eb;
			padding: 10px 20px;
			margin: 5px 0;
			border-left: 4px solid #b5644f;
		}

		.trace .extended {
			margin-top: 5px;
			color: #b5644f;
		}

		h2 {
			font-size: 1.3em;
			margin: 0 0 15px 0;
			text-transform: uppercase;
			font-weight: 400;
			color: #312a17;
		}

		#exception .message {
			color: #b54225;
			margin-bottom: 15px;
		}

		.args {
			margin-top: 5px;
			color: #85743e;
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
			
			#header {
				text-align: center;

			}

			#framework {
				margin-top: 5px;
				float: none;
				text-align: center;
			}

			#exception {
				padding: 35px 10px;
			}

			#stack-trace {
				padding: 35px 10px 100px 10px;
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

		<div id="exception">
			<h2><?php echo get_class($e) ?></h2>
			<div class="message"><?php echo $e->getMessage() ?></div>
			<?php echo $e->getFile() ?> [<?php echo $e->getLine() ?>]
		</div>

		<div id="stack-trace">
			<h2>Stack Trace</h2>
			<?php foreach ($e->getTrace() as $trace): ?>
				<div class="trace">
					<div class="file"><?php echo $trace['file'] ?> [<?php echo $trace['line'] ?>]</div>

					<?php if ($trace['class'] && $trace['function']): ?>
						<div class="extended class"><?php echo $trace['class'] . '::' . $trace['function'] ?></div>
						
						<?php if ($trace['args']): ?>
							<div class="args">
								<?php foreach ($trace['args'] as $key => $arg): ?>
									<div class="arg">
										<?php echo $key ?>: <?php echo $arg ?>
									</div>
								<?php endforeach ?>
							</div>
						<?php endif ?>

					<?php elseif ($trace['function']): ?>
						<div class="extended function"><?php echo $trace['function'] ?></div>
					<?php endif ?>

				</div>
			<?php endforeach ?>
		</div>

		<div id="copyright">
			Copyright © <?php echo date('Y') ?> The Modern Firm, LLC
		</div>

	</div>
</body>
</html>

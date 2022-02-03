<form id="association-member-login" method="POST">
	<?php if (!empty($_GET['redirect'])): ?>
		<input type="hidden" name="TMF[association_member_login][redirect]" value="<?php echo $_GET['redirect'] ?>">
		<div class="message error">You must login to access the requested page.</div>
	<?php endif ?>
 	
 	<?php if ($member->has_login_messages()): ?>
		<?php foreach ($member->get_login_messages() as $message): ?>
			<div class="message <?php if ($message['error']) echo 'error' ?>"><?php echo $message['text'] ?></div>
		<?php endforeach ?>
	<?php endif ?>

	<div class="member-login-row">
		<label for="member-login-email" class="top">Email Address:</label>
		<input id="member-login-email" type="text" name="TMF[association_member_login][email]" value="<?php echo $_POST['TMF']['association_member_login']['email'] ?>">
	</div>
	
	<div class="member-login-row">
		<label for="member-login-password" class="top">Password:</label>
		<input id="member-login-password" type="password" name="TMF[association_member_login][password]">
	</div>

	<div class="member-login-row submit-row">
		<input id="member-login-remember" type="checkbox" name="TMF[association_member_login][remember]" checked="checked" value="yes">
		<label for="member-login-remember">Remember Me</label>
		<input id="member-login-submit" class="tmf-button medium" name="TMF[association_member_login][submit]" type="submit" value="Login">
	</div>

	<div class="member-login-row">
		<input id="member-forgot-password" class="" name="TMF[association_member_password_reset]" type="submit" value="Send a password reset email">
	</div>
</form>
Hi<?php if (!empty($name)) echo ' ' . $name ?>,

Your password for "<?php echo $site_name ?>" has be reset. Please use the temporary password below to login and update your password.


User Name: <?php echo $email ?>

Temporary Password: <?php echo $password ?>


You can update your password by using the following link:
<?php echo $edit_url ?>
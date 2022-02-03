<div id="member-edit-messages">
	<?php if ($member->has_edit_messages()): ?>
		<?php foreach ($member->get_edit_messages() as $message): ?>
			<div class="message <?php if ($message['error']) echo 'error' ?>"><?php echo $message['text'] ?></div>
		<?php endforeach ?>
	<?php endif ?>
</div>

<form id="association-member-edit" action="" method="post" enctype="multipart/form-data">
	
	<div class="member-edit-field">
		<label>First Name:</label>
		<input type="text" value="<?php echo $member->data->first_name ?>" name="TMF[member_edit][_first_name]" />
	</div>

	<div class="member-edit-field">
		<label>Last Name:</label>
		<input type="text" value="<?php echo $member->data->last_name ?>" name="TMF[member_edit][_last_name]" />
	</div>

	<div class="member-edit-field">
		<label>Display Name:</label>
		<input type="text" value="<?php echo $member->data->display_name ?>" name="TMF[member_edit][_display_name]" />
	</div>

	<div class="member-edit-field">
		<label>Primary Phone:</label>
		<input type="text" value="<?php echo $member->data->phone_1 ?>" name="TMF[member_edit][_phone_1]" />
	</div>

	<div class="member-edit-field">
		<label>Secondary Phone:</label>
		<input type="text" value="<?php echo $member->data->phone_2 ?>" name="TMF[member_edit][_phone_2]" />
	</div>

	<div class="member-edit-field">
		<label>Fax:</label>
		<input type="text" value="<?php echo $member->data->fax ?>" name="TMF[member_edit][_fax]" />
	</div>

	<div class="member-edit-field">
		<label>Email:</label>
		<input type="text" value="<?php echo $member->data->email ?>" name="TMF[member_edit][_email]" />
		<div class="note">Changing your email will also change the email you log in with.</div>
	</div>

	<div class="member-edit-field">
		<label>Business Name:</label>
		<input type="text" value="<?php echo $member->data->business_name ?>" name="TMF[member_edit][_business_name]" />
	</div>

	<div class="member-edit-field">
		<label>Business Address:</label>
		<textarea  name="TMF[member_edit][_business_address]"><?php echo $member->data->business_address ?></textarea>
	</div>

	<div class="member-edit-field">
		<label>Business Website:</label>
		<input type="text" value="<?php echo $member->data->business_url ?>"  name="TMF[member_edit][_business_url]" />
	</div class="member-edit-field">

	<div class="member-edit-field">
		<label>Primary Professional Area:</label>
		<select id="primary-professional-area" name="TMF[member_edit][professional_areas][]">
			<option value="">-- Select a Professional Area --</option>
			<?php foreach ($professional_areas as $professional_area): ?>
				<?php if (in_array($professional_area['id'], $current_professional_areas)):
					$primary_area = $professional_area['id'];
				endif ?>

				<?php $selected = (in_array($professional_area['id'], $current_professional_areas)) ? 'selected="selected"' : '' ?>

				<option value="<?php echo $professional_area['id'] ?>" data-subareas='<?php echo json_encode($professional_area['sub_areas']) ?>' <?php echo $selected ?>><?php echo $professional_area['name'] ?></option>
			<?php endforeach ?>
		</select>
	</div>

	<div class="member-edit-field">
		<label>Secondary Professional Areas:</label>

		<div id="secondary-professional-areas">

			<?php if ($primary_area): ?>
				<?php foreach ($professional_areas[$primary_area]['sub_areas'] as $subarea): ?>
					<?php $selected = (in_array($subarea['id'], $current_professional_areas)) ? 'checked="checked"' : '' ?>
						<input id="pac-<?php echo $subarea['id'] ?>" type="checkbox" value="<?php echo $subarea['id'] ?>" name="TMF[member_edit][professional_areas][]" <?php echo $selected ?>><label for="pac-<?php echo $subarea['id'] ?>"><?php echo $subarea['name'] ?></label>
						<br />
				<?php endforeach ?>							
			<?php endif ?>
		</div>

		<script>
			jQuery('#primary-professional-area').on('change', function(){
				var subareas = jQuery(this).find(':selected').data('subareas');

				jQuery('#secondary-professional-areas').empty();

				for (var key in subareas) {
					jQuery('#secondary-professional-areas').append('<input id="pac-'+ subareas[key].id +'" type="checkbox" value="'+ subareas[key].id +'" name="TMF[member_edit][professional_areas][]"><label for="pac-'+ subareas[key].id + '">'+ subareas[key].name +'</label><br />');
				}

			})
		</script>
	</div>

	<div class="member-edit-field member-bio">
		<label>Member Bio:</label>
		<?php wp_editor($member->data->post_content, 'member-edit-member-bio', array(
			'media_buttons'		=> false,
			'drag_drop_upload'	=> false,
			'textarea_name'		=> 'TMF[member_edit][member_bio]'
		)) ?>
	</div>

	<div class="member-edit-field">
		<label>Member Image:</label>
		<?php if ($member->data->has_primary_image()): ?>
			<img class="member-image" src="<?php echo $member->data->primary_image_url ?>"  name="TMF[member_edit][member_image]" /><br />
		<?php endif; ?>
		<input type="file" name="TMF_member_edit_image"/>
		<div class="note">Image must be a JPEG or PNG no smaller than 250px by 250px.</div>

	</div>

	<br />

	<div class="member-edit-field">
		<input type="submit" class="tmf-button medium" value="Update Profile"  name="TMF[member_edit][submit]"/>
	</div>

</form>

<form id="update-password" action="" method="post">
	
	<h2>Update Password</h2>

	<div class="member-edit-field">
		<label>Password:</label>
		<input type="password" value="" name="TMF[member_password][password]" />
	</div>

	<div class="member-edit-field">
		<label>Password Repeat:</label>
		<input type="password" value="" name="TMF[member_password][password_repeat]" />
	</div>

	<br />

	<div class="member-edit-field">
		<input type="submit" class="tmf-button medium" value="Update Password"  name="TMF[member_password][submit]"/>
	</div>

</form>

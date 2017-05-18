<div class="wrap">
	<h2><?php echo __('Notification options', 'plance') ?></h2>
	<form method="post" action="?page=<?php echo Plance_MSF_Controller_Admin_Notification::page() ?>">
		<?php wp_nonce_field(Plance_MSF_Controller_Admin_Notification::page()); ?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('admin_email') ?></th>
				<td>
					<input type="text" name="admin_email" value="<?php echo esc_attr($Validate -> getData('admin_email')) ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('admin_name') ?></th>
				<td>
					<input type="text" name="admin_name" value="<?php echo esc_attr($Validate -> getData('admin_name')) ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('noreply_email') ?></th>
				<td>
					<input type="text" name="noreply_email" value="<?php echo esc_attr($Validate -> getData('noreply_email')) ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('noreply_name') ?></th>
				<td>
					<input type="text" name="noreply_name" value="<?php echo esc_attr($Validate -> getData('noreply_name')) ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('shortcode_name') ?></th>
				<td>
					<input type="text" name="shortcode_name" value="<?php echo esc_attr($Validate -> getData('shortcode_name')) ?>" /><br>
					<em>
						<small><?php echo __('Use this shortcode in your posts or pages', 'plance') ?></small>
					</em>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('message_subject') ?></th>
				<td>
					<input type="text" name="message_subject" value="<?php echo esc_attr($Validate -> getData('message_subject')) ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('message_template') ?></th>
				<td>
					<textarea style="width: 500px; height: 100px;" name="message_template"><?php echo esc_textarea($Validate -> getData('message_template')); ?></textarea>
					<p>
						<em>
							<small>
								<?php echo __('Use next pseudotag in above message:', 'plance') ?>
								<div style="margin-left: 10px">
									<?php echo __('{name} - Name', 'plance') ?><br>
									<?php echo __('{surname} - Surname', 'plance') ?><br>
									<?php echo __('{patronymic} - Patronymic', 'plance') ?><br>
									<?php echo __('{company} - Company', 'plance') ?><br>
									<?php echo __('{birthday} - Birthday', 'plance') ?><br>
									<?php echo __('{phone} - Phone', 'plance') ?><br>
									<?php echo __('{email} - Email', 'plance') ?><br>
									<?php echo __('{messenger} - Messenger', 'plance') ?><br>
									<?php echo __('{site} - Site', 'plance') ?><br>
									<?php echo __('{country} - Country', 'plance') ?><br>
									<?php echo __('{city} - City', 'plance') ?><br>
									<?php echo __('{address} - Address', 'plance') ?><br>
									<?php echo __('{credit_card} - Credit card', 'plance') ?><br>
									<?php echo __('{sum} - Sum', 'plance') ?><br>
									<?php echo __('{comment} - Comment', 'plance') ?><br>
									<?php echo __('{image} - Image', 'plance') ?><br>
									<?php echo __('{file} - File', 'plance') ?><br>
									<?php echo __('{radio} - Radio element', 'plance') ?><br>
									<?php echo __('{select} - Select element', 'plance') ?><br>
									<?php echo __('{checkbox} - Checkbox element', 'plance') ?><br>
								</div>
							</small>
						</em>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('flash_message') ?></th>
				<td>
					<textarea style="width: 500px; height: 50px;" name="flash_message"><?php echo esc_textarea($Validate -> getData('flash_message')); ?></textarea>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
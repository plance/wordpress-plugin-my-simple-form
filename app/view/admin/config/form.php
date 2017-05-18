<div class="wrap">
	<h2><?php echo __('Configure form fields', 'plance') ?></h2>
	<form method="post" action="?page=<?php echo Plance_MSF_Controller_Admin_Config::page() ?>">
		<?php wp_nonce_field(Plance_MSF_Controller_Admin_Config::page()); ?>
		<table class="form-table msa-table">
			<tr>
				<td><?php echo __('Field title', 'plance') ?></td>
				<td><?php echo __('Your title', 'plance') ?></td>
				<td><?php echo __('Show on form?', 'plance') ?></td>
				<td><?php echo __('Order on form', 'plance') ?></td>
				<td><?php echo __('Required to fill?', 'plance') ?></td>
				<td><?php echo __('Options', 'plance') ?></td>
			</tr>
			<tr>
				<th><?php echo __('Name', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'name',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Surname', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'surname',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Patronymic', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'patronymic',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Company', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'company',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Birthday', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'birthday',
				)); ?>
				<td>
					<?php echo __('Min age:', 'plance') ?> <input type="text" name="msa[birthday][min]" value="<?php echo esc_attr($data_ar['birthday']['min']) ?>" style="width: 40px" />
					<br>
					<?php echo __('Max age:', 'plance') ?> <input type="text" name="msa[birthday][max]" value="<?php echo esc_attr($data_ar['birthday']['max']) ?>" style="width: 40px" />
					<br>
					<small><i><?php echo __('Set to zero to not use an age limit', 'plance') ?></i></small>
				</td>
			</tr>
			<tr>
				<th><?php echo __('Phone', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'phone',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('E-mail', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'email',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Messenger', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'messenger',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Site', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'site',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Country', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'country',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('City', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'city',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Address', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'address',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Credit card', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'credit_card',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Sum', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'sum',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Image', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'image',
				)); ?>
				<td>
					*<?php echo __('Extensions:', 'plance') ?> <input type="text" name="msa[image][extension]" value="<?php echo esc_attr($data_ar['image']['extension']) ?>" style="width: 140px" />
				</td>
			</tr>
			<tr>
				<th><?php echo __('File', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'file',
				)); ?>
				<td>
					*<?php echo __('Extensions:', 'plance') ?> <input type="text" name="msa[file][extension]" value="<?php echo esc_attr($data_ar['file']['extension']) ?>" style="width: 140px" />
				</td>
			</tr>
			<tr>
				<th><?php echo __('Comment', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'comment',
				)); ?>
			</tr>
			<tr>
				<th><?php echo __('Radio', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'radio',
				)); ?>
				<td>
					*<?php echo __('Options:', 'plance') ?> <input type="text" name="msa[radio][list]" value="<?php echo esc_attr($data_ar['radio']['list']) ?>" style="width: 160px" />
				</td>
			</tr>
			<tr>
				<th><?php echo __('Select', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'select',
				)); ?>
				<td>
					*<?php echo __('Options:', 'plance') ?> <input type="text" name="msa[select][list]" value="<?php echo esc_attr($data_ar['select']['list']) ?>" style="width: 160px" />
				</td>
			</tr>
			<tr>
				<th><?php echo __('Checkbox', 'plance') ?></th>
				<?php echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/_partial/fields', array(
					'data_ar' => $data_ar,
					'field' => 'checkbox',
				)); ?>
			</tr>
		</table>
		<p>
			<i>* <?php echo __('Use comma for separate options', 'plance') ?></i>
		</p>
		<?php submit_button(); ?>
	</form>
</div>
<?php 
	$id = $data_ar['id'];
	$date_create = $data_ar['date_create'];
	unset($data_ar['id'], $data_ar['date_create']);
?>
<div class="wrap">
	<h2>
		<?php echo __('Users ', 'plance') ?>
	</h2>
		<table class="form-table">
			<tr>
				<th scope="row"><?php echo __('ID', 'plance') ?>:</th>
				<td><?php echo $id ?></td>
			</tr>
			<?php
				foreach ($rows_ar as $k => $a):
					switch ($k):
						case 'birthday':
						?>
							<tr>
								<th scope="row"><?php echo $a['title'] ?>:</th>
								<td><?php echo date(get_option('date_format', 'd.m.Y'), $data_ar[$k]) ?></td>
							</tr>
						<?php 							
						break;
						case 'image':
						case 'file':
							if($data_ar[$k] && is_file(PLANCE_MSF_PATH_TO_UPLOADS.$data_ar[$k])):
							?>
								<tr>
									<th scope="row"><?php echo $a['title'] ?>:</th>
									<td>
										<a href="<?php echo Plance_Registry::get('url_to_plugin').$data_ar[$k] ?>" target="_blank"><?php echo Plance_Registry::get('url_to_plugin').$data_ar[$k] ?></a>
										[<a href="?page=<?php echo Plance_MSF_Controller_Admin_User::page().'&action=file&type='.$k.'&id='.$id ?>" onclick="return confirm('<?php echo __('is Delete?', 'wsa') ?>')">x</a>]
									</td>
								</tr>
							<?php 
							endif;
						break;
						case 'checkbox':
						?>
							<tr>
								<th scope="row"><?php echo $a['title'] ?>:</th>
								<td><?php echo $data_ar[$k] ? __('Yes', 'plance') : __('No', 'plance') ?></td>
							</tr>
						<?php 
						break;
						default:
						?>
							<tr>
								<th scope="row"><?php echo $a['title'] ?>:</th>
								<td><?php echo $data_ar[$k] ?></td>
							</tr>
						<?php 
						break;
					endswitch;
				endforeach; 
				?>
			<tr>
				<th scope="row"><?php echo __('Date create', 'plance') ?>:</th>
				<td>
					<?php echo date(get_option('date_format', 'd.m.Y').' '.get_option('time_format', 'H:i'), $date_create) ?>
				</td>
			</tr>
		</table>
</div>
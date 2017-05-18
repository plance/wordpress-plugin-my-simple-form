<?php
	if(isset($_POST['__plance_msf_form']) && $Validate -> isErrors())
	{
		Plance_Flash::instance() -> show('error', $Validate -> getErrors());
	}
	Plance_Flash::instance() -> showMessage();
	
	$is_label_show	= array('checkbox', 'birthday_day', 'birthday_month', 'birthday_year');
	$is_birthday	= false;
?>
<form method="post" class="plance-msa-form" enctype="multipart/form-data" action="//<?php echo Plance_Request::currentURL(); ?>">
	<input type="hidden" name="__plance_msf_form" value="true">
	<?php foreach($fields_ar as $a): ?>
	<p>
		<?php if(in_array($a['field'], $is_label_show, true) == false): ?>
		<label for="<?php echo $a['name'] ?>"><?php echo $Validate -> getLabel($a['name']) ?></label><br>
		<?php endif;?>
		<?php
			switch ($a['field']):
				case 'birthday_day':
				case 'birthday_month':
				case 'birthday_year':
					if($is_birthday == true):
						continue;
					endif;
					$is_birthday = true;
					?>
					<label><?php echo $a['title'] ?></label><br>
					<select name="msf_birthday_day" class="r-msf_birthday_day r-select">
						<option value="0"><?php echo __('- day -', 'plance') ?></option>
						<?php for($i = 1; $i <= 31; $i++): ?>
						<option value="<?php echo $i?>" <?php echo selected($i, $Validate -> getData('msf_birthday_day'))?>><?php echo $i?></option>
						<?php endfor;?>
					</select>
					<select name="msf_birthday_month" class="r-msf_birthday_month r-select">
						<option value="0"><?php echo __('- month -', 'plance') ?></option>
						<?php for($i = 1; $i <= 12; $i++): ?>
						<option value="<?php echo $i?>" <?php echo selected($i, $Validate -> getData('msf_birthday_month'))?>><?php echo $i?></option>
						<?php endfor;?>
					</select>
					<select name="msf_birthday_year" class="r-msf_birthday_year r-select">
						<option value="0"><?php echo __('- year -', 'plance') ?></option>
						<?php for($i = date('Y') + 10; $i >= date('Y') - 80; $i--): ?>
						<option value="<?php echo $i?>" <?php echo selected($i, $Validate -> getData('msf_birthday_year'))?>><?php echo $i?></option>
						<?php endfor;?>
					</select>
					<?php
				break;
				case 'file':
				case 'image':
					?>
						<input type="file" class="r-field r-<?php echo $a['field'] ?>" id="<?php echo $a['name'] ?>" name="<?php echo $a['name'] ?>" />
					<?php if($a['rules']['extension'] == true): ?>
						<br><small><?php echo str_replace(',', ', ', $a['rules']['extension']) ?></small>
					<?php
					endif;
				break;
				case 'select':
						$list_ar = explode(',', $a['rules']['list']);
					?>
					<select class="r-<?php echo $a['field'] ?>" id="<?php echo $a['name'] ?>" name="<?php echo $a['name'] ?>">
					<?php foreach($list_ar as $id => $title): ?>
						<option value="<?php echo $id?>" <?php echo selected($id, $Validate -> getData($a['name']))?>><?php echo $title ?></option>
					<?php endforeach; ?>
					<select>	
					<?php
				break;
				case 'checkbox':
					?>
						<input type="checkbox" class="r-<?php echo $a['field'] ?>" id="<?php echo $a['name'] ?>" value="<?php echo $id?>" name="<?php echo $a['name'] ?>" <?php echo checked($id, $Validate -> getData($a['name']))?> />
						<label for="<?php echo $a['name'] ?>"><?php echo $Validate -> getLabel($a['name']) ?></label>
					<?php
				break;
				case 'radio':
						$list_ar = explode(',', $a['rules']['list']);
					?>
						<input type="hidden" id="<?php echo $a['name'] ?>" value="0" name="<?php echo $a['name'] ?>" /> 
					<?php foreach($list_ar as $id => $title): ?>
						<input type="radio" class="r-<?php echo $a['field'] ?>" id="<?php echo $a['name'].$id ?>" value="<?php echo $id?>" name="<?php echo $a['name'] ?>" <?php echo checked($id, $Validate -> getData($a['name']))?> /> 
						<label for="<?php echo $a['name'].$id ?>"><?php echo $title?></label> <br>
					<?php
						endforeach;
				break;
				case 'comment':
					?>
						<textarea class="r-field r-<?php echo $a['field'] ?>" id="<?php echo $a['name'] ?>" name="<?php echo $a['name'] ?>"><?php echo esc_attr($Validate -> getData($a['name'])) ?></textarea>
					<?php
				break;
				default :
					?>
						<input type="text" class="r-field r-<?php echo $a['field'] ?>" id="<?php echo $a['name'] ?>" name="<?php echo $a['name'] ?>" value="<?php echo esc_attr($Validate -> getData($a['name'])) ?>" />
					<?php
				break;
			endswitch;
		?>
	</p>						
		<?php endforeach; ?>
	<p>
		<input name="submit" type="submit" class="submit" value="<?php echo __('Send', 'plance') ?>">
	</p>
</form>
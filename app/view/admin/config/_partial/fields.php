<td><input type="text" name="msa[<?php echo $field ?>][title]" value="<?php echo esc_attr($data_ar[$field]['title']) ?>" /></td>
<td>
	<input type="hidden" name="msa[<?php echo $field ?>][show]" value="0" />
	<input type="checkbox" name="msa[<?php echo $field ?>][show]" value="1" <?php echo checked(1, $data_ar[$field]['show'])?> />
</td>
<td><input type="text" name="msa[<?php echo $field ?>][order]" value="<?php echo esc_attr($data_ar[$field]['order']) ?>" style="width: 40px" /></td>
<td>
	<input type="hidden" name="msa[<?php echo $field ?>][required]" value="0" />
	<input type="checkbox" name="msa[<?php echo $field ?>][required]" value="1" <?php echo checked(1, $data_ar[$field]['required'])?> />
</td>
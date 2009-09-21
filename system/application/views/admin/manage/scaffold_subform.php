<tr class="delimiter">
	<td colspan="2">&nbsp;</th>
</tr>

<?php foreach($subForm['items'] as $item) { ?>
<tr>
	<th><?php echo ucfirst($item['name']); ?>:</th>
	<td><input type="text" name="<?php echo $item['input_name']; ?>" value="<?php echo $item['value']; ?>" /></td>
</tr>
<?php } ?>

<tr class="delimiter">
	<input type="hidden" name="three_link_table" value="<?php echo $subForm['linkTable']; ?>" />
	<input type="hidden" name="subForm" value="true" />
	<td colspan="2">&nbsp;</th>
</tr>
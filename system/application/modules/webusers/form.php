<?php
	function createLine($label, $name, $value) {
		echo '
			<tr>
				<th><label for="'.$name.'">'.$label.':</th>
				<td><input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" /></td>
			</tr>
		';
	}
?>
<form method="post" action="<?php echo moduleCreateLink(array('webusers')); ?>">
	<table>
	<?php
		createLine('Name', 'name', $details['name']);
		createLine('Address', 'address', $details['address']);
		createLine('Postal code', 'postalcode', $details['postalcode']);
		createLine('City', 'city', $details['city']);
		createLine('Country', 'country', $details['country']);
		createLine('Telephone', 'telephone', $details['telephone']);
		createLine('Mobile', 'mobile', $details['mobile']);
		createLine('E-mail address', 'email', $details['email']);
	?>
		<tr class="delimiter">
			<td colspan="2">&nbsp;</td>
		</tr>
	<?php
		createLine('Username', 'username', $details['username']);
		$blocked = $details['blocked'] == 1 ? ' checked="checked" ' : '';
	?>
		<tr>
			<th><label for="password">Password:</th>
			<td><input type="password" name="password" id="password" /> <em>Leave these two fields blank if you wish not to change the password</em></td>
		</tr>
		<tr>
			<th><label for="password2">Repeat password:</th>
			<td><input type="password" name="password2" id="password2" /></td>
		</tr>
		<tr class="delimiter">
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th><label for="blocked">Blocked:</th>
			<td><input type="checkbox" name="blocked" id="blocked" <?php echo $blocked; ?> /></td>
		</tr>
		<tr class="delimiter">
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<input type="hidden" name="id" value="<?php echo $details['id']; ?>" />
				<input type="submit" value="Save user" name="save" />
			</td>
		</tr>	
	</table>
</form>

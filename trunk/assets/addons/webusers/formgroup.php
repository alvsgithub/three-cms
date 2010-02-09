<form method="post" action="<?php echo $this->createLink(array('webusers')); ?>">
	<table>
		<tr>
			<th><label for="name">Name:</label></th>
			<td><input type="text" name="name" id="name" /></td>
		</tr>
		<tr class="delimiter">
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<input type="hidden" name="id" value="<?php echo $details['id']; ?>" />
				<input type="hidden" name="group" value="true" />
				<input type="submit" value="Save group" name="save" />
			</td>
		</tr>	
	</table>
</form>

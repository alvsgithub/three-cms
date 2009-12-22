<?php
	// The content of this file is placed in between the content-part and the save button
	// On the add/edit content page.
	//
	// Available parameters:
	//
	// $lang				: Code Igniters language object
	// $contentData			: The contentData object, containing all data of this Content Object
	// $templates			: The templates that are available for this content object
	// $title				: The title of this page
	// $allowedTemplates	: The templates that are allowed for this user rank
	// $settings			: The settings-array
	// $modules				: The array with the modules
	
	if($this->db->table_exists('webusers')) {
	
		$allowedGroups = array();
		if($contentData['id']==0) {
			// This is new content:
			$allChecked = ' checked="checked" ';
		} else {
			// This is existing content:
			// See which user groups are allowed to see this content, 0 means all
			$query = $this->db->select('id_group');
			$query = $this->db->where('id_content', $contentData['id']);
			$query = $this->db->get('webusers_content_group');
			if($query->num_rows==0) {
				$allChecked = ' checked="checked" ';
			} else {
				// There are restrictions:
				$allChecked = '';
				foreach($query->result() as $result) {
					array_push($allowedGroups, $result->id_group);
				}
			}
		}
	?>
	<tr>
		<th>Visible for webuser groups:</th>
		<td>
			<input type="checkbox" name="webusers_all" <?php echo $allChecked; ?> /> <strong>All users can view this page</strong><br />
			<?php
				// Get all groups:
				$this->db->select('id,name');
				$this->db->order_by('name', 'asc');
				$query = $this->db->get('webusers_groups');
				foreach($query->result() as $result) {
					$checked = in_array($result->id, $allowedGroups) ? ' checked="checked" ' : '';
					echo '
						<input type="checkbox" name="webusers_'.$result->id.'" '.$checked.' /> '.$result->name.'<br />
					';
				}
			?>
			<script type="text/javascript">
				// jQuery script:
				$(function(){				
					$("input[name=webusers_all]").change(function(){
						if(!$(this).attr("checked")) {
							$("input[name^=webusers_]").removeAttr("disabled");						
						} else {
							$("input[name^=webusers_]").not($(this)).attr("disabled", "disabled");
						}
					});				
					$("input[name!=webusers_all]").change(function(){
						if($(this).attr("checked")) {
							$("input[name=webusers_all]").removeAttr("checked");
						} else {
							// See if there are other checkboxes that are checked
							var otherChecked = false;
							$("input[name!=webusers_all]").each(function(){
								if($(this).attr("checked")) {
									otherChecked = true;
								}
							});
							if(!otherChecked) {
								$("input[name=webusers_all]").attr("checked", "checked");
							}
						}					
					});
				});
			</script>
		</td>
	</tr>

<?php
	}
?>
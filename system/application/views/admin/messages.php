<?php
	if(count($messages) > 0) {
		echo '
			<div id="messages">
				<ul>';
		foreach($messages as $message) {
			echo '<li class="'.$message['type'].'">'.$message['message'].'</li>';
		}
		echo '
				</ul>
			</div>';
	}
?>
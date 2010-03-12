<div id="content">
	<div id="innerContent">
		<h1>Dashboard</h1>
		<?php
			$left  = $dashboard['left'];
			$right = $dashboard['right'];
		?>
		<div id="dashboard">
			<div class="left">
				<?php
					foreach($left as $item) {
						include('item.php');
					}
				?>
			</div>
			<div class="right">
				<?php
					foreach($right as $item) {
						include('item.php');						
					}
				?>
			</div>
		</div>
	</div>
</div>
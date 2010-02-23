<html>
	<head>
		<title>New order on the website</title>
	</head>
	<body>
		<p>There is a new order placed on the website.</p>
		<h3><strong>Order details:</strong></h3>
		<table>
			<tr>
				<th>Product Code</th>
				<th>Product Name</th>
				<th>Qty.</th>
				<th>Unit Price</th>
				<th>Total</th>
			</tr>
			<?php
				foreach($cart as $item) {
					echo '
						<tr>
							<td>'.$item['options']['code'].'</td>
							<td>'.$item['name'].'</td>
							<td>'.$item['qty'].'</td>
							<td>&euro; '.$item['price'].'</td>
							<td>&euro; '.number_format($item['subtotal'], 2, ',', '.').'</td>
						</tr>
					';
				}
			?>
			<tr>
				<td colspan="4" style="text-align: right;">
					<strong>Total price:</strong>
				</td>
				<td>
					<strong>&euro; <?php echo number_format($this->total(), 2, ',', '.'); ?></strong>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<strong>Order notes:</strong><br /><br />
					<?php echo $data['order_notes']; ?>
				</td>
			</tr>
		</table>
		<h3>Client details:</h3>
		<table>
			<?php
				foreach($clientDetails as $key=>$value) {			
					echo '
						<tr>
							<th>'.ucfirst($key).':</th>
							<td>'.$value.'</td>
						</tr>
					';
				}
			?>	
		</table>
	</body>
</html>
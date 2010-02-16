<?php
/*
	Cart v0.1
	---------------------------------------------------------------------------
	Author:		Giel Berkers
	Website:	www.gielberkers.com
	---------------------------------------------------------------------------
	This addon makes use of Code Igniters Cart-library to create a simple
	shopping cart addon.
	
	Usage:
	
	To add a product to the cart, use a form with certain hidden fields:
	
	<form method="post" action="">
		Quantity: <input name="cart[qty]" type="text" value="1" size="3" />		
		<input type="hidden" name="cart[id]" value="{$idContent}" />
		<!-- $name and $price could be fields of your dataobject: -->
		<input type="hidden" name="cart[name]" value="{$name}" />
		<input type="hidden" name="cart[price]" value="{$price}" />
		<input type="submit" name="cart[add]" value="Add to cart" />
		<!-- Add specific product options like this: -->
		<input type="hidden" name="cart[options][code]" value="{$code}" />
		<select name="cart[options][size]">
			<option value="S">Small</option>
			<option value="M">Medium</option>
			<option value="L">Large</option>
		</select>
	</form>
	
	To destroy (empty) your cart you can use a form:
	
	<form method="post" action="">
		<input type="submit" name="cart[destroy]" value="Empty cart" />	
	</form>
	
	Or a function:
	
	{$cart->destroy()}
	
	Other functions:
	
	{$cart->totalItems()}		Returns the total amount of items in your cart
	{$cart->total()}			Returns the total amount of your cart
	{$cart->getCart()}			Gets the content of your cart
	
*/

class Cart extends AddonBaseModel
{
	var $cart;
	
	/**
	 * Initialize
	 */
	function init()
	{
		@session_start();
		$this->frontEnd = true;
	}
	
	/**
	 * This function tells Three CMS on which hook a function needs to be called
	 */
	function getHooks()
	{
		// Since this addon only does something on the frontend, there are no hooks:
		$hooks = array(
			array(
				'hook'=>'LoadPage',
				'callback'=>'loadUtilities'
			),
			array(
				'hook'=>'PreRenderPage',
				'callback'=>'preRender'
			)
		);
		return $hooks;
	}
	
	// Load the Code Igniter shopping cart and stuff:
	function loadUtilities($context)
	{
		// Load the CI-cart library:
		$context['page']->load->library('cart');
		// Make a reference to the cart-object, since it will not be automaticly
		// coupled this this Addon-Object:
		$this->cart = $context['page']->cart;
	}
	
	// Check for POST-data
	function preRender($context)
	{
		if(isset($_POST['cart'])) {
			$data = $this->input->post('cart');
			if(isset($data['add'])) {
				// Add product to the cart:
				// Check if the item already exists, if so, perform an update:
				$update = false;
				foreach($this->cart->contents() as $row) {
					if($row['id']==$data['id']) {
						$update = true;
						$this->cart->update(array('rowid'=>$row['rowid'], 'qty'=>$row['qty'] + $data['qty']));
					}
				}
				if(!$update) {
					// No update performed, insert as a new item:
					$this->cart->insert($data);
				}
			} elseif(isset($data['update'])) {
				// Update cart	
				if(isset($_POST['cart']['update_qty'])) {
					foreach($_POST['cart']['update_qty'] as $rowid=>$value) {						
						$this->cart->update(array('rowid'=>$rowid, 'qty'=>$value));
					}
				}
			} elseif(isset($data['remove'])) {
				// Remove from cart
				if(isset($_POST['cart']['remove_id'])) {
					foreach($_POST['cart']['remove_id'] as $rowid=>$value) {						
						$this->cart->update(array('rowid'=>$rowid, 'qty'=>0));
					}
				}
			} elseif(isset($data['destroy'])) {
				// Destroy (empty) the cart:
				$this->destroy();
			}
			
		}
	}
	
	
	
	//// Frontend functions:
	
	/**
	 * Get the shopping cart
	 * @return	array	A 2-dimensional array with the content of the shopping cart
	 */
	function getCart()
	{
		return $this->cart->contents();
	}
	
	/**
	 * Get the total amount of products in the cart:
	 * @return	int		The total amount products
	 */
	function totalItems()
	{
		$quantity = 0;
		foreach($this->getCart() as $item) {
			$quantity += $item['qty'];
		}
		return $quantity;
	}
	
	/**
	 * Get the total amount of the cart:
	 * @return	number	The total amount of the cart
	 */
	function total()
	{
		return $this->cart->total();
	}
	
	/**
	 * Destroy (empty) your cart:
	 */
	function destroy()
	{
		$this->cart->destroy();
	}
}
?>
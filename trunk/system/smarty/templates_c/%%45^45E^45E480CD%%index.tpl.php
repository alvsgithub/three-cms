<?php /* Smarty version 2.6.26, created on 2009-09-17 15:06:32
         compiled from index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $this->_tpl_vars['title']; ?>
</title>
	</head>
	<body>
		<h1><?php echo $this->_tpl_vars['header']; ?>
</h1>
		<p><?php echo $this->_tpl_vars['content']; ?>
</p>
				<hr />
		<?php $_from = $this->_tpl_vars['dataObject']->children(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['obj']):
?>
			<?php echo $this->_tpl_vars['obj']->render(); ?>

		<?php endforeach; endif; unset($_from); ?>
		<hr />
	</body>
</html>
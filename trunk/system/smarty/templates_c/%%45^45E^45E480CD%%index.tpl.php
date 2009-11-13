<?php /* Smarty version 2.6.26, created on 2009-11-13 16:52:19
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index.tpl', 25, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $this->_tpl_vars['title']; ?>
</title>
		<link rel="stylesheet" type="text/css" media="screen" href="site/css/screen.css" />
	</head>
	<body>
		<div id="body">
			<div id="top">
				<h1><?php echo $this->_tpl_vars['title']; ?>
</h1>
			</div>
			<div id="navigation">
								<ul>
				<?php $_from = $this->_tpl_vars['dataObject']->children(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
					<li><a href="#"><?php echo $this->_tpl_vars['child']->get('header'); ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
				</ul>
			</div>
			<div id="content">
				<h1><?php echo $this->_tpl_vars['header']; ?>
</h1>
				<p><?php echo $this->_tpl_vars['content']; ?>
</p>
			</div>
			<div id="footer">
				<p>&copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
 || Powered by Three CMS</p>
			</div>
		</div>
			</body>
</html>
<?php /* Smarty version 2.6.26, created on 2010-02-08 18:10:28
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index.tpl', 24, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</head>
	<body>
		<div id="body">
			<div id="top">
				<h1><?php echo $this->_tpl_vars['title']; ?>
</h1>
			</div>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "navigation.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<div id="content">
				<?php if ($this->_tpl_vars['this']->get('published') == '1'): ?>
					<div class="breadCrumbs">
						<?php echo $this->_tpl_vars['breadCrumbs']->generate($this->_tpl_vars['this']->idContent); ?>

					</div>
					<h1><?php echo $this->_tpl_vars['header']; ?>
</h1>
					<p><?php echo $this->_tpl_vars['content']; ?>
</p>
				<?php else: ?>
					<p>This page is not yet published!</p>
				<?php endif; ?>
			</div>
			<div id="footer">
				<p>&copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
 | Powered by Three CMS</p>
			</div>
		</div>
	</body>
</html>
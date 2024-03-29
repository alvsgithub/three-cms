<?php /* Smarty version 2.6.26, created on 2010-04-06 18:11:51
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index.tpl', 29, false),)), $this); ?>
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
						<?php echo $this->_tpl_vars['breadcrumbs']->generate($this->_tpl_vars['this']->idContent); ?>

					</div>
					<h1><?php echo $this->_tpl_vars['header']; ?>
</h1>
					<p><?php echo $this->_tpl_vars['content']; ?>
</p>
				<?php else: ?>
					<p>This page is not yet published!</p>
				<?php endif; ?>
				<h2>Tree:</h2>				
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "tree.tpl", 'smarty_include_vars' => array('id' => '0')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<h2>Random page:</h2>
				<?php $this->assign('page', $this->_tpl_vars['randompage']->fromTemplate(5,$this->_tpl_vars['this']->idLanguage)); ?>
				<?php echo $this->_tpl_vars['page']->render(); ?>

			</div>
			<div id="footer">
				<p>&copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
 | Powered by Three CMS</p>
			</div>
		</div>
	</body>
</html>
<?php /* Smarty version 2.6.26, created on 2009-09-25 12:27:44
         compiled from block.tpl */ ?>
<div class="block">
	<h2><?php echo $this->_tpl_vars['header']; ?>
</h2>
	<p><?php echo $this->_tpl_vars['content']; ?>
</p>
	<?php $this->assign('parent', $this->_tpl_vars['dataObject']->getParent()); ?>
	Parent: <?php echo $this->_tpl_vars['parent']->get('header'); ?>

</div>
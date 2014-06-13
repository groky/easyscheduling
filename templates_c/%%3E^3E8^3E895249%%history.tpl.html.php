<?php /* Smarty version 2.6.26, created on 2010-07-07 16:09:41
         compiled from history.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'history.tpl.html', 20, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<br />
<h4><?php echo $this->_tpl_vars['title']; ?>
</h4>

<table class="body-table">
<thead>
<tr>
	<th>Event Name</th>
	<th>Description</th>
	<th>Contact</th>
</tr>
</thead>
<tbody>
<?php $this->assign('i', ((is_array($_tmp=@$this->_tpl_vars['i'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
<?php $_from = $this->_tpl_vars['old_events']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['event']):
?>
	<?php if ($this->_tpl_vars['i']%2 == 0): ?>
		<tr class="alternate">
	<?php else: ?>
		<tr>
	<?php endif; ?>
		<td><?php echo $this->_tpl_vars['event']['event_name']; ?>
</td>
		<td><?php echo $this->_tpl_vars['event']['description']; ?>
</td>
		<td><?php echo $this->_tpl_vars['event']['contact_person']; ?>
</td>
	</tr>
	<?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
<?php endforeach; endif; unset($_from); ?>
</tbody>
</table>
</body>
</html>
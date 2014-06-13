<?php /* Smarty version 2.6.26, created on 2010-07-15 15:07:43
         compiled from view_all_responders.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'view_all_responders.tpl.html', 13, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
</head>
<body>
    <h4>People who responded to <strong><?php echo $this->_tpl_vars['event']['event_name']; ?>
</strong></h4>
    <p><?php echo $this->_tpl_vars['event']['description']; ?>
</p>
<br/>
<table class="body-table">

	<?php $this->assign('i', ((is_array($_tmp=@$this->_tpl_vars['i'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $_from = $this->_tpl_vars['responders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['r']):
?>

	<tr
	<?php if ($this->_tpl_vars['i']%2 == 0): ?>
		 class="alternate"
	<?php endif; ?>
	>
		<td>
		<img class="emptylogo" src="images/minilogoblue.jpg"></img>
			&nbsp;<?php echo $this->_tpl_vars['r']['first_name']; ?>
</td>
		<td><?php echo $this->_tpl_vars['r']['last_name']; ?>
</td>
	</tr>

	<?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
	<?php endforeach; endif; unset($_from); ?>
</table>
</body>
<p style="position:relative; left:570px;"><a href="?page_name=r_p&id=<?php echo $this->_tpl_vars['event']['id']; ?>
&multi=<?php echo $this->_tpl_vars['event']['multi_day']; ?>
"> &lt; &nbsp; Go Back to previous list</a></p>
</html>
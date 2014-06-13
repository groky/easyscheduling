<?php /* Smarty version 2.6.26, created on 2010-07-07 16:00:43
         compiled from persons_choice.tpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>EasyScheduling - People from an Option</title>
</head>
<body>
<h3><?php echo $this->_tpl_vars['event']; ?>
</h3>
<h4>The <?php echo $this->_tpl_vars['count']; ?>
 guest(s) who selected <span class="easy"><?php echo $this->_tpl_vars['location']; ?>
 &nbsp;on &nbsp;<?php echo $this->_tpl_vars['start']; ?>
 &nbsp;@ &nbsp;<?php echo $this->_tpl_vars['start_time']; ?>
 to &nbsp;<?php echo $this->_tpl_vars['end']; ?>
 &nbsp;<?php echo $this->_tpl_vars['end_time']; ?>
</span></h4>

	<ul>
	<?php $_from = $this->_tpl_vars['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['person']):
?>
		<li><?php echo $this->_tpl_vars['person']['first_name']; ?>
 <?php echo $this->_tpl_vars['person']['last_name']; ?>
</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
</body>
</html>
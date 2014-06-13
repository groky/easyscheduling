<?php /* Smarty version 2.6.26, created on 2010-07-15 14:18:27
         compiled from poll_result.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'poll_result.tpl.html', 34, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>EasyScheduling - Respondent Results</title>
<script type="text/javascript">
	<?php echo '
	function changeIcon(arg, id){
         //alert("getting ready to change the icon");
         if(arg==1){
        	 //document.getElementById(id).src="";
             document.getElementById(id).src = "images/minilogoblue.jpg";
         }
         else{
        	//document.getElementById(id).src="";
          	document.getElementById(id).src = "images/MiniEmptylogoblue.jpg";
         }
      }
	'; ?>

</script>
</head>
<body>
    <h4>Options Provided for <strong><?php echo $this->_tpl_vars['event']['event_name']; ?>
</strong></h4>
    <p><?php echo $this->_tpl_vars['event']['description']; ?>
</p>
<br/>

	<table class="body-table">
	<tr>
		<td><a href="?page_name=r_v&id=<?php echo $this->_tpl_vars['event']['id']; ?>
">View All Responders</a><br/></td>
	<tr>
	<tr>
		<td><br/></td>
	<tr>
	<?php $this->assign('i', ((is_array($_tmp=@$this->_tpl_vars['i'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $_from = $this->_tpl_vars['choices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>

	<tr
		onmouseover="changeIcon(1, 'edge-tick<?php echo $this->_tpl_vars['i']; ?>
');"
		onmouseout="changeIcon(0, 'edge-tick<?php echo $this->_tpl_vars['i']; ?>
');"
	<?php if ($this->_tpl_vars['i']%2 == 0): ?>
		 class="alternate"
	<?php endif; ?>
	>
		<td>
		<img
			id="edge-tick<?php echo $this->_tpl_vars['i']; ?>
" 
			class="emptylogo" 
			src="images/MiniEmptylogoblue.jpg"
			onmouseover="ShowContent('floating-div'); getResponders(<?php echo $this->_tpl_vars['option']['option_id']; ?>
); return true;" 
			onmouseout="HideContent('floating-div'); return true;"></img>
			&nbsp;<?php echo $this->_tpl_vars['option']['location']; ?>
</td>
		<td><?php echo $this->_tpl_vars['option']['o_start']; ?>
</td>
		<td><?php echo $this->_tpl_vars['option']['start_time']; ?>
</td>
		<?php if ($this->_tpl_vars['option']['o_end']): ?>
			<td><?php echo $this->_tpl_vars['option']['end_date']; ?>
</td>
		<?php endif; ?>
		
		<td><?php echo $this->_tpl_vars['option']['end_time']; ?>
</td>
		<td><a title="<?php echo $this->_tpl_vars['option']['count']; ?>
 selector(s)" href="?page_name=w_o&id=<?php echo $this->_tpl_vars['option']['option_id']; ?>
&loc=<?php echo $this->_tpl_vars['option']['location']; ?>
&s=<?php echo $this->_tpl_vars['option']['o_start']; ?>
&st=<?php echo $this->_tpl_vars['option']['start_time']; ?>
&e=<?php echo $this->_tpl_vars['option']['o_end']; ?>
&et=<?php echo $this->_tpl_vars['option']['end_time']; ?>
&count=<?php echo $this->_tpl_vars['option']['count']; ?>
&event=<?php echo $this->_tpl_vars['event']['event_name']; ?>
"><?php echo $this->_tpl_vars['option']['count']; ?>
</a></td>
	</tr>

	<?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
	<?php endforeach; endif; unset($_from); ?>
	</table>
	
	<!-- the floating div that shows the people-->
<div id="floating-div" ></div>
</body>
</html>
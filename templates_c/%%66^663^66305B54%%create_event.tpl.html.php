<?php /* Smarty version 2.6.26, created on 2010-07-19 15:14:12
         compiled from create_event.tpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<form method="post" action="?" enctype="multipart/form-data"
	name="event_form" />
<table class="body-table" border="0">
	<tr>
		<td colspan="3">
		<h4>Create your <span class="easy">event</span>/meeting</h4>
		</td>
	</tr>
	<tr>
		<td valign="top"><label><span class="easy">event</span>/meeting name</label></td>
		<td colspan="2"><input class="name-of-meeting" type="text"
			name="event_name" value="<?php echo $this->_tpl_vars['event']['event_name']; ?>
" /></td>
	</tr>
	<tr>
		<td valign="top"><label>Organiser</label></td>
		<td colspan="2"><input type="text" name="contact_person" id="org_contact"
			value="<?php echo $this->_tpl_vars['event']['contact_person']; ?>
" />&nbsp;<img
			src="./images/question.jpg" onclick="javascript:loadOrganiser('<?php echo $this->_tpl_vars['event']['contact_person']; ?>
');"
			title="Load the default name"></img></td>
	</tr>
	<tr>
		<td valign="top"><label>Description (500 Characters Maximum)</label></td>
		<td colspan="3"><textarea cols="50" rows="3" name="event_description"><?php echo $this->_tpl_vars['event']['description']; ?>
</textarea></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<!--this is where the timetable went!-->
	<tr>
		<td valign="top"><label>Multiple Day Event</label></td>
		<td><label>Yes</label><input type="radio" name="multi" value="yes"
		<?php if ($this->_tpl_vars['event']['multi_day'] == 1): ?>
		checked
		<?php endif; ?>
		 /> <label>No</label><input type="radio" name="multi" value="no"			
		<?php if ($this->_tpl_vars['event']['multi_day'] == 0): ?>
		checked
		<?php endif; ?>
		 />
		 </td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td colspan="2" align="right"><input type="submit"
			value=<?php if ($this->_tpl_vars['event']['id']): ?>
					"update event"
					<?php else: ?> 
					"create event"
					<?php endif; ?>
			name="create_event" /></td>
	</tr>
</table>
<input type="hidden" name="org_id" value="<?php echo $this->_tpl_vars['org_id']; ?>
" />
<input type="hidden" name="page_name" value="c_e" /> <input
	type="hidden" name="id" value="<?php echo $this->_tpl_vars['event_id']; ?>
" /></form>


<script type="text/javascript">
<?php echo '
	function loadOrganiser(val){
		document.getElementById("org_contact").value=val;
	}
'; ?>

</script>
</body>
</html>
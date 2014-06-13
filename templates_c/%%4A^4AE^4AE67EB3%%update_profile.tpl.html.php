<?php /* Smarty version 2.6.26, created on 2010-07-06 09:28:13
         compiled from update_profile.tpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>EasyScheduling - Update Profile</title>
</head>
<body>
<h4><?php echo $this->_tpl_vars['title']; ?>
</h4>
<form action="?" method="post" enctype="multipart/form-data">
<table class="form-table">
	<tr>
		<td><h4>Personal Information</h4></td>
	</tr>
	<tr>
		<td><label>Name</label></td>
		<td><input type="text" value="<?php echo $this->_tpl_vars['info']['first_name']; ?>
" name="info[name]"/></td>
	</tr>
	<tr>
		<td><label>Last/Family Name</label></td>
		<td><input type="text" value="<?php echo $this->_tpl_vars['info']['last_name']; ?>
" name="info[surname]" /></td>
	</tr>
	<tr>
		<td><label>Email &nbsp; <p class="small-blue">(Changing this will change your login)</p></label></td>
		<td><input type="text" value="<?php echo $this->_tpl_vars['info']['email']; ?>
" name="info[email]" id="email-box" /></td>
	</tr>
	
	<tr>
		<td><label>Organisation Name</label></td>
		<td><input type="text" value="<?php echo $this->_tpl_vars['org_name']; ?>
" name="info[organisation]" /></td>
	</tr>
	<tr>
		<td><label>&nbsp;</label></td>
		<td><input type="submit" value="update" name="update" /></td>
	</tr>	
	<tr>
		<td><h4>Password Information</h4></td>
		<td>Update your password information <a href="?page_name=p_p">here</a></td>
	</tr>	
</table>
<input type="hidden" name="page_name" value="u_d" />
</form>
</body>
</html>
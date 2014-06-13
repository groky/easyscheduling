<?php

	$change = get_request_var('change', false);
	$password = get_request_var('password', "");
	$re_password = get_request_var('re-password', "");
	
	if(!user_is_logged_in()){
		show_page("l_o");
	}
	
	if($change!==false){
		validate($password, $re_password);
		if(strlen($errors)>0){
			error($errors);
		}
		else{
			update_user_password(get_email_from_session(), $password);
			echo("Your password has been successfully changed");
			sleep(2);
			show_page("l_e");
		}
	}
	
	
	
	function validate($password, $re_password){
		global $errors;
		
		if(strlen($password)<1){
			$errors = $errors . "* Please provide a password.<br />";
		}
		
		if($password!=$re_password){
			$errors = $errors . "* Your passwords do not match.";
		}
	}

?>

<form method="post" action="?" enctype="multipart/form-data">
<table class="form-table" border="0">
	<tr>
		<td>
		<h4>Update Password</h4>
		</td>
	</tr>

	<tr>
		<td><label>New Password</label></td>
		<td><input type="password" name="password" /></td>

	</tr>
	<tr>
		<td><label>Re-type Password</label></td>
		<td><input type="password" name="re-password" /></td>
	</tr>

	<tr>
		<td></td>
		<td><input type="submit" value="change" name="change" /></td>
	</tr>

</table>
<input type="hidden" name="page_name" value="p_p" /></form>

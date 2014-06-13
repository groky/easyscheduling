<?php

require_once('./classes/profile.php');
require_once('./classes/image_upload.php');

$validate = true;

if(user_is_logged_in()){
	logout("page_name=c_o");
	//show_page("c_o");
}

$create = get_request_var("create", false);

$first_name = get_request_var("first_name", "");
$last_name = get_request_var("last_name", "");
$org_name = get_request_var("org_name", "");

$logo = 'logo';

$email = get_request_var("email", "");
$password = get_request_var("pass", "");
$re_password = get_request_var("rpass", "");

$tac = get_request_var("tac","");

if($create!==false){

	if(validate($tac, $first_name, $last_name, $password, $re_password, $email, $validate)){
		if(!check_exists($email)){//exists
			//alert($email);
			$created = create_profile($first_name,$last_name,$org_name,$email,
			$logo, sha1($password));
			//upload_file($logo, "?page_name=c_o");
			//upload($logo);

			if($created){
				do_session_login($email, $password);
				show_page ("c_e");
			}
			else{
				//$errors = ;
				error("* Could not create your session. Please try again...");
			}

		}//if check_exists
		else{
			$errors = "A profile associated to this email already exists.<br />
                    Either create a profile using a different email or request an email for the password.";
			error($errors);
		}
	}//validate
	else{
		error($errors);
	}

}//create
 
function validate($tac, $first_name, $last_name, $password, $re_password, $email ,$validate){
	global $errors;
	
	if(strlen($tac)<1){
		$errors = $errors . "* Your profile cannot be created. Please accept the Terms and Conditions <br />";
		$validate = false;
	}
	
	if(!is_string($first_name) || strlen(trim($first_name))<1 || ctype_digit($first_name)){
		$errors = $errors . "* A firstname is required <br />";
		$validate = false;
	}

	if(!is_string($last_name) || strlen($last_name)<1 || ctype_digit($last_name)){
		$errors = $errors . "* A lastname is required <br />";
		$validate = false;
	}

	if(check_email($email)!=1){
		$errors = $errors . "* A valid email address is required <br />";
		$validate = false;
	}

	if($password!=$re_password || $password=="" || strlen($password)<1){
		$errors = $errors . "* A valid password & password confirmation are required <br />";
		$validate = false;
	}

	return $validate;
}
?>


<form method="post" action="?" enctype="multipart/form-data"
	name="create_profile">
<table class="form-table">
	<tr>
		<td colspan="2">
		<h4>Create a new profile</h4>
		<div class="profile-reason">You need to create an organizer profile before you can create an <span
			class="easy">event</span>/meeting. <br/>This profile (login) will enable
		you to update the event details and retrieve the results.<br/>
		<br/>
		</div>
		</td>
	</tr>
	<tr>
		<td><label>First name</label></td>
		<td><input type="text" name="first_name" value="<?php echo($first_name); ?>" /></td>
	</tr>
	<tr>
		<td><label>Last name</label></td>
		<td><input type="text" name="last_name"
			value="<?php echo $last_name; ?>" /></td>
	</tr>
	<tr>
		<td><label>Organisation name</label></td>
		<td><input type="text" name="org_name"
			value="<?php echo $org_name; ?>" /></td>
	</tr>
	<!--<tr>
      <td><label>Upload your logo</label></td>
      <td><input type="file" name="logo"  value="<?php //echo $logo; ?>"/></td>
    </tr>!-->
	<tr>
		<td><label>Email</label></td>
		<td><input type="text" name="email" value="<?php echo $email; ?>" id="email-box" /></td>
	</tr>
	<tr>
		<td><label>Password</label></td>
		<td><input type="password" name="pass"
			value="<?php echo $password; ?>" /></td>
	</tr>
	<tr>
		<td><label>Confirm your password</label></td>
		<td><input type="password" name="rpass"
			value="<?php echo $re_password; ?>" /></td>
	</tr>
	
	<tr>
		<td><label>Accept Terms and Conditions</label></td>
		<td><input type="checkbox" name="tac"
			<?php echo($tac=='on' ? " checked='yes'" : ""); ?> /></td>
	</tr>
	
	<tr>
		<td></td>
		<td><input type="submit" value="create profile" name="create"></input></td>
	</tr>

	<!--<input type="text" name="testinput" />
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'create_profile',
		// input name
		'controlname': 'testinput'
	});

	</script>   !-->
</table>
<input type="hidden" name="page_name" value="c_o" />
</form>

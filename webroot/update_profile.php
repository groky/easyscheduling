<?php

if(!user_is_logged_in()){
  	$contact_error="* You must be logged in to complete your request. <br />";
  	$contact_error=$contact_error . "Please Log in or Register on the Home page";
    show_page("l_o&contactuserror=".$contact_error);
 }
 
 require_once('./classes/profile.php');
 
 $update = get_request_var('update', false);
 
 $info=get_request_var('info', false);
 
 //print_r($_SESSION['ES_USER']);
 
 if($update!==false){
 	//validate the variables
 	if(validate($info['name'], $info['surname'], $info['email'])){
 		//update the information
 		update_profile(get_org_id(), $info);
 		update_session($info);
 		//goto a success page
 		show_page('p&title=Update Profile&reason=personal profile update');
 	}
 	else{
 		error($errors);
 	}
 	//update the information
 }
 
 
 $smarty->assign('org_name', get_org_name_from_id());
 $smarty->assign('info', $_SESSION['ES_USER']);
 $smarty->assign('title',"Update your Profile");
 $smarty->display('update_profile.tpl.html');
  
 
 function validate($name, $surname, $email){
	global $errors;
	 
	$validate = true;
	 
	if(!is_string($name) || strlen(trim($name))<1 || ctype_digit($name)){
		$errors = $errors . "* A firstname is required <br />";
		$validate = false;
	}

	if(!is_string($surname) || strlen($surname)<1 || ctype_digit($surname)){
		$errors = $errors . "* A lastname is required <br />";
		$validate = false;
	}

	if(check_email($email)!=1){
		$errors = $errors . "* A valid email address is required <br />";
		$validate = false;
	}

	return $validate; 	
 }
 
?>
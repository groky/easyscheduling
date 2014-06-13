<?php
  $login = get_request_var("login", false);
  $email = get_request_var("email", false);
  $password = get_request_var("password", false);
  
  $validate = true;
  
  $contact_error = get_request_var("contactuserror", "");
  error($contact_error);
  
  //print_r('<pre>' . var_dump($_REQUEST) .  '</pre>');
  if(user_is_logged_in()){
    show_page("h_p");
  }
  else{
  	if($login!==false){
  		//alert('pressed');
      if(validate($email, $password, $validate)){
       	//print("<script>alert('starting it!');</script>");
       	do_session_login($email, $password);
        if(!user_is_logged_in()){
          $errors = "* Incorrect email/password combination. Try again...";
          error($errors);
        }
        else{
          show_page("h_p");
        }
      }
      else{
        error($errors);
      }
    }
  }

  $smarty->assign('email', $email);
  $smarty->display('login.tpl.html');
  
  /**
   * validate the fields
   * @param $email
   * @param $password
   * @param $validate
   */
  function validate($email, $password, $validate){
    global $errors;
    
    if(check_email($email)!=1){
      $errors = $errors . "* A valid email address is required <br />";
      $validate = false;
    }
    if(strlen($password)<1 || $password==""){
      $errors = $errors . "* A password is required";
      $validate = false;
    }
    
    
    return $validate;
  }
?>



<?php

require_once("db.php");
require_once("login.php");
include('./classes/pear/Mail.php');
include('./classes/filter/class.inputfilter.php');
require_once('config/mail_conf.php');

define('CONFIG_FILE', "config/pages.ini");
define('SHORT_DATE', "d-m-Y");
define('LONG_DATE', "D, d M Y");

include('config/local.php');
//include('config/prod.php');


function get_request_var($name, $default = null)
{
	//    Check if the specified var exists
	if(!array_key_exists($name, $_REQUEST))
	{
		if($default !== null)
		return $default;
		else
		throw new Exception("Missing parameter: {$name}", 100);
	}

	else
	{
		$magic_quotes = get_magic_quotes_gpc();
		 
		$data = $_REQUEST[$name];
		$result = $default;

		if(is_array($data))
		{
			$result = array();
			 
			foreach($data as $key => $value)
			{
				if($magic_quotes != 0) {
					//$value = stripslashes($value);
					$value = stripslashes_recursive($value);
				}

				$result[$key] = $value;
			}
		}

		else
		{
			if($magic_quotes != 0) {
				//$data = stripslashes($data);
				$data = stripslashes_recursive($data);
			}

			$result = $data;
		}
		
		//then cleanse the value of all malicious tags
		
		return process($result);
	}
}

function stripslashes_recursive($value) {
	return is_array($value) ? array_map('stripslashes_recursive', $value) : stripslashes($value);
}

function load_ini_file(){
	$ini_array = parse_ini_file(CONFIG_FILE);
	return $ini_array;
}

function alert($arg){
	print("<script>alert(\"".$arg."\"); </script>");
}

function check_email($email){
	$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
	$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
	$atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c'.
        '\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
	$quoted_pair = '\\x5c[\\x00-\\x7f]';
	$domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
	$quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
	$domain_ref = $atom;
	$sub_domain = "($domain_ref|$domain_literal)";
	$word = "($atom|$quoted_string)";
	$domain = "$sub_domain(\\x2e$sub_domain)*";
	$local_part = "$word(\\x2e$word)*";
	$addr_spec = "$local_part\\x40$domain";
	 
	return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
}

/**
 *check the user's credentials and create the necessary reference data
 */
function do_session_login($email, $password){

	$user_info = array();
	
	$user_info = login($email, $password);

	$logged_in=false;
	//print('<pre>' . var_dump($user_info) . '</pre>');
	if(isset($user_info[1])){
		if($user_info[1]["logged_in"]==true){
			create_user_cookie($user_info, $email);
			$logged_in = true;
		}
		//alert("logged in!");
	}

}
/**
 * creates the error messages at the top of the body section
 */
function error($errorString){
	print("<p class='error'> $errorString</p>");
}

function update_session($info){
	$_SESSION['ES_USER']['first_name'] = $info['name'];
	$_SESSION['ES_USER']['last_name'] = $info['surname'];
	$_SESSION['ES_USER']['email'] = $info['email'];
}

function create_user_cookie($info, $email){
	/*$expire = time() + 60 * 60 * 24; //the cookie will expire in 1 day
	$str_cookie_val = "first_name=" . $info[0]['first_name'] .
                      "@ last_name=" . $info[0]['last_name'] .
                      "@ organisation_id=" . $info[0]['organisation_id'];
	$path = "/";
	$domain = "easyscheduling.com.au";
	$http = false;
	//alert($str_cookie_val);*/
	$session = array();
	$session['first_name'] = $info[0]['first_name'];
	$session['last_name'] = $info[0]['last_name'];
	$session['organisation_id'] = $info[0]['organisation_id'];
	$session['email'] = $email;
	$_SESSION["ES_USER"] = $session;
	/*$val = setcookie("ES_USER", $str_cookie_val, $expire, $path, $domain, $http);

	if($val==true){
		alert('it worked!');
	}
	else{
		alert('we failed');
	}
	print_r($info);*/
}

function get_name_from_cookie(){
	
	$session = $_SESSION['ES_USER'];
	$first_name = $session['first_name'];
	$last_name = $session['last_name'];
	
	/*$vals = $_COOKIE['ES_USER'];
	$vals = explode("@", $vals);

	$val = explode("=",$vals[0]);
	$first_name = $val[1];

	$val = explode("=", $vals[1]);
	$last_name = $val[1];*/

	return $first_name . " " . $last_name;

}

function get_first_name(){
	return $_SESSION['ES_USER']['first_name'];
}

function get_email_from_session(){
	return $_SESSION['ES_USER']['email'];
}

function get_org_id(){
	/*$vals = $_COOKIE['ES_USER'];
	$vals = explode("@", $vals);

	$val = explode("=", $vals[2]);*/
	
	$org_id = $_SESSION['ES_USER']['organisation_id'];
	
	//return $val[1];
	return $org_id;
}

function user_is_logged_in(){
	$logged_in = false;
	//alert("checking...");
	//print_r($_COOKIE);
	//alert("okay... trying cookie...");
	if(isset($_SESSION['ES_USER'])){
		$logged_in = true;
		//alert("checked");
	}
	/*if(isset($_COOKIE['ES_USER'])){
		$logged_in = true;
		alert("checked");
	}*/
	
	return $logged_in;
}

function logout($location=""){
	//setcookie("es_user", "", time()-3600);
	session_destroy();
	header("Location: ?$location");
	//show_page($location);
}

function show_page($page){

	$page_name = PAGE . "?page_name=$page";
	
	print("<script>");
	print("self.location='". $page_name . "';");
	print("</script>");

}

function get_date($format, $unix_timestamp){
	return date($format, $unix_timestamp);
}


function get_ipx() {
	$length=52;
	$vowels = 'aeiuoAEUOI';
	$consonants = 'bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ1234567890!-$';
	 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

function sendMail( $link, $email, $event_info){

	$subject = "Link for ". $event_info['event_name'];

	$body = "Hi " . get_name_from_cookie() . ",
	
Thank you for using easyscheduling.com.au.

The link you've requested follows.

$link

Send this link to all the participants. They will be able to view the schedule you have created and submit their responses.

Kind regards,
EasyScheduling Team";

    $headers = array ('From' => FROM_EMAIL,
      'To' => $email,
      'Subject' => $subject,
      'Reply-To' => FROM_EMAIL);
    /*$smtp = Mail::factory('smtp',
    array ('host' => HOST,
        'auth' => true,
        'username' => USERNAME,
        'password' => PASSWORD,
        'port'=> PORT));*/
    
    send($email, $headers, $body);
    /*$smtp = Mail::factory('mail');

    $mail = $smtp->send($email, $headers, $body);

    if (PEAR::isError($mail)) {
    	error( $mail->getMessage() );
    }*/
}

function do_email_from_contact($subject, $body){
	$headers= array('From'=> get_email_from_session(),
					'To'=> USERNAME,
					'Subject'=>$subject);
	/**
	 * @TODO
	 * write the information to the database
	 */
	
	send(USERNAME, $headers, $body);
}

function send($email, $headers, $body){
    $smtp = Mail::factory('mail');

    $mail = $smtp->send($email, $headers, $body);

    if (PEAR::isError($mail)) {
    	error( $mail->getMessage() );
    }
}

function process($val){
	$validator = new InputFilter();
	
	return $validator->process($val);

}

function generate_pw() {
	$length=10;
	$vowels = 'aeiuoAEUOI';
	$consonants = 'bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ1234567890!-$';
	 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

function update_user_password($email, $password){
	update_password($email, $password);
}

function send_mail_to_organiser($toemail, $event, $member_name){
	$subject = "EasyScheduling: " . $event['event_name'] . " - acceptor";
	$headers= array('From'=> FROM_EMAIL,
					'To'=> $toemail,
					'Subject'=>$subject);
	$body="Hi,
	
$member_name has posted a response to the upcoming event.

Kind Regards,
EasyScheduling Team
www.easyscheduling.com.au";

send($toemail, $headers, $body);

}

function send_pw_email($name, $email){
	
	$subject = "Forgotten Password Request";
	$headers= array('From'=> FROM_EMAIL,
					'To'=> $email,
					'Subject'=>$subject);

	
	if(check_valid_user($name, $email)){
		$password = generate_pw();
		update_password($email, $password);
		
		
		$body = "Thank you,
		
Your new password is: $password.

Kind Regards,
EasyScheduling Team
www.easyscheduling.com.au";
		
		send($email, $headers, $body);
	}
}

function get_org_name_from_id(){
 return get_org_name(get_org_id());	
}

?>
<?php
session_start();

require_once('./classes/config/smarty.php');
include ("./classes/functions.php");
//error_reporting(null);

$errors = "";
$page_names = load_ini_file();

$page_name = get_request_var("page_name", false);
$logout = get_request_var("logout", false);

if($logout==1){
	logout();
}

$user_logged_in = true;
if(!user_is_logged_in()){
	$user_logged_in = false;
}

/**
 * load the header/login bar
 */
ob_start();

if($user_logged_in){
	//alert("winner!");
	include("./webroot/show_login.php");
	//include ("./webroot/menu.php");
}
else{
	include("./webroot/not_logged_in.php");
}

$top_menu = ob_get_contents();
ob_end_clean();

/**
 * start the loading of the contents
 */
ob_start();

if($page_name!==false && $page_name!='main'){
	//print_r($page_name);
} else {
	if($user_logged_in){
		$page_name='h_p';
	}else{
		$page_name='main';
	}
}
//print_r($page_name);
$page = $page_names[$page_name];
//print_r($page);
include($page);
 
$contents = ob_get_contents();
ob_end_clean();

/**
 * load the details into the template
 */
$smarty->assign('top_menu', $top_menu);
$smarty->assign('contents', $contents);
$smarty->display('index.tpl.html');
?>

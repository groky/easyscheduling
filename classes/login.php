<?php
function login($email, $password){
	global $conn;

	$logged_in = false;

	$sql = "select m.first_name, m.last_name, i.organisation_id from member m, organiser i, organisation o where
            m.id = i.member_id and
            o.id = i.organisation_id and 
            o.email='$email' and o.`password` ='". sha1($password) . "';";

	//alert("made the login string...");

	$qh = mysql_query($sql, $conn);
	//echo($qh);
	//mysql_error();

	if(mysql_error()){
		alert('there was an error.');
	}

	$user_info = array();
	while($line = mysql_fetch_assoc($qh)){
		$user_info[] = $line;
	}

	//print(mysql_stat());
	//print('<pre>' . var_dump($info) . '</pre>');

	if(count($user_info)<1){
		$logged_in = false;
	}
	else{
		$logged_in = true;
	}
	$user_info[] = array("logged_in" => $logged_in);

	//print('<pre>' . var_dump($user_info) . '</pre>');

	return $user_info;
}

function check_valid_user($name, $email){
	global $conn;
	
	$valid = false;
	
	$sql = "select m.last_name from member m, organiser i, organisation o where
            m.id = i.member_id and
            o.id = i.organisation_id and 
            o.email='$email' and m.last_name ='$name';";

	//alert("made the login string...");

	$qh = mysql_query($sql, $conn);
	
	if(count(mysql_fetch_array($qh))>0){
		$valid = true;
	}
	
	return $valid;
}

function update_password($email, $password){
	global $conn;
	
	$sql = "update organisation o set o.`password`='" . sha1($password) . "' where o.email='$email';";
	//echo($sql);
	
	mysql_query($sql,$conn);
}

function get_org_name($org_id){
	global $conn;
	
	$sql = "select org_name from organisation where id=$org_id;";
	
	$qh = mysql_query($sql, $conn);
	
	$array = mysql_fetch_array($qh);
	return $array[0];
}
?>
<?php

$dbhost = 'localhost';
$dbuser = 'kgrovers_easy';
$dbpass = 'easysche';
/*
//easyscheduling on crazy domains
$dbuser = 'easysche_easysch';
$dbpass = '34sy';
*/
//$dbuser = 'root';
//$dbpass = 'root';

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
$dbname = 'kgrovers_easy';
//$dbname = 'easyschedule';
//$dbname='easysche_easyschedule';
mysql_select_db($dbname);



/*$s = "select * from member";

echo(var_dump($conn));

$qh = mysql_query($s, $conn);
$sa = array();

while($line = mysql_fetch_assoc($qh)){
	$sa[]=$line;
}

print_r('<pre>'. var_dump($sa) . '</pre>');*/

?>

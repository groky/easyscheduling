<?php
  function create_profile($first_name,$last_name,$org_name,$email,
                            $logo, $password){

    //create the member
    $member_id = insert_member($first_name, $last_name);
    
    //create the organisation
    $org_id = insert_org($org_name, $email, $password,$logo);    
    
    //create the link between the organiser and the member
    insert_organiser($member_id, $org_id);

    
    return true;
    
  }
  
  /**
   * update the profile information here
   * @param $org_id
   * @param $info
   */
  function update_profile($org_id, $info){
  	global $conn;
  	
  	//update the organisation information
  	$sql = "Update organisation set email='". $info['email'] ."', org_name='" .  
  			$info['organisation'] . "' where id=$org_id;";
  	
  	mysql_query($sql, $conn);
  	
  	$sql = "Select member_id from organiser where organisation_id=$org_id";
  	
  	$qh = mysql_query($sql, $conn);
  	
  	//get the member_id
  	$member = mysql_fetch_array($qh);
  	$member_id=$member['member_id'];
  	
  	//update the member information
  	$sql = "Update member set first_name='".$info['name']."', last_name='".$info['surname']."' where id=$member_id;";
  	
  	mysql_query($sql);
  }
  
  function insert_member($first_name, $last_name){
    global $conn;
    
    $first_name = mysql_real_escape_string($first_name);
    $last_name = mysql_real_escape_string($last_name);
                    
    $query = "Insert into member (first_name, last_name) values ('$first_name', '$last_name');";
    
    $qh = mysql_query($query, $conn);
    
    if(mysql_error($conn)){
      trigger_error(mysql_error($conn));
    }
    $member_id = mysql_insert_id($conn);
    
    return $member_id;  
  }
  
  function insert_org($org_name, $email, $password, $logo){
    global $conn;
    
    $org_name = mysql_real_escape_string($org_name);
    
    if(strlen($logo<1)){
      $logo = null;
    }
    
    $query = "Insert into organisation (org_name, email, `password`, logo) values " .
              "('$org_name', '$email', '$password', null);";
    
    //print($query);
     
    $qh = mysql_query($query, $conn);

    if(mysql_error($conn)){
      trigger_error(mysql_error($conn));
    }
    
    $org_id = mysql_insert_id($conn);
    
    return $org_id;
  }
  
  function insert_organiser($member_id, $org_id){
    global $conn;
    
    $query = "Insert into organiser (member_id, organisation_id) values ($member_id, $org_id);";

    $qh = mysql_query($query, $conn);
    
    if(mysql_error($conn)){
      trigger_error(mysql_error($conn));
    }
    
    return true;
  
  }
  
  function check_exists($email){
    global $conn;
    
    $exists = false;
    $sql = "select email from organisation where email='$email'";
    //print($sql);
    //alert($sql);
    
    $qh = mysql_query($sql, $conn);
    
    if($line = mysql_fetch_assoc($qh)){
      if(isset($line['email'])){
        if($line['email']==$email){
          $exists = true;
        }
      }
    }
    
    return $exists;
  }

  function create_member_link($member_id, $reference){
    global $conn;
    
    $sql = "Insert into member_link (member_id, reference) values (
            $member_id, '$reference');";
            
    mysql_query($sql, $conn);
            
  }
  
  function is_member($reference, $name, $surname){
    global $conn;
    
    $exists = false;
    $options = array();
    $result = array();
    $member_id = "";
    
    $sql = "select member_id from member_link where reference='$reference'";
    
    $qh = mysql_query($sql, $conn);
    if($qh!=0 || $qh!=false){
      while($row = mysql_fetch_assoc($qh)){
        //echo("<pre>".print_r($row). "</pre><br />");
        if(!is_bool($row)){
          $sql_member = "Select first_name, last_name from member where id=".$row['member_id']. ";";
          
          $handle = mysql_query($sql_member, $conn);
          if($line = mysql_fetch_assoc($handle)){
            if(!is_bool($line)){
              if(strtoupper($line['first_name'])==strtoupper($name) && strtoupper($line['last_name'])==strtoupper($surname)){
                $member_id = $row['member_id'];
                $exists = true;
              }
            }
          }
        }
      }
    }
    
    if($exists){
      $sql = "select option_id from member_option where member_id=$member_id;";
      $qh = mysql_query($sql, $conn);
      while($row = mysql_fetch_assoc($qh)){
        $options[] = $row['option_id'];
      }
    }
    
    $result['exists'] = $exists;
    $result['member_id'] = $member_id;
    $result['options'] = $options;
    
    return $result;
  }
?>
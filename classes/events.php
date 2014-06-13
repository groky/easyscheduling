<?php
function create_event($name, $organiser, $description, $multi, $action){
	global $conn;

	$name = mysql_real_escape_string($name);
	$organiser = mysql_real_escape_string($organiser);
	$description = mysql_real_escape_string($description);

	$sql = "Insert into event (event_name, description, organisation_id, multi_day, contact_person, action)
          values ('$name', '$description', " . get_org_id() ." ,$multi , '$organiser', $action); ";

	$qh = mysql_query($sql, $conn);

	return mysql_insert_id($conn);

}

function update_event($name, $organiser, $description, $multi, $action, $event_id){
	global $conn;

	$name = mysql_real_escape_string($name);
	$organiser = mysql_real_escape_string($organiser);
	$description = mysql_real_escape_string($description);

	$sql = "Update event set event_name='$name', description='$description', organisation_id=".
	get_org_id() . ", multi_day=$multi, contact_person='$organiser', action=$action where id=$event_id;";

	mysql_query($sql, $conn);
}

function get_events($org_id){
	global $conn;

	$sql = "Select * from event where organisation_id = $org_id and deleted <> 1";

	$qh = mysql_query($sql, $conn);

	$events = array();

	if($qh!=false){
		while ($line=mysql_fetch_assoc($qh)){
			$events[] = $line;
		}
	}

	//print("<pre>". var_dump($events) . "</pre>");
	return $events;

}

function get_all_events($org_id){
	global $conn;

	$sql = "Select * from event where organisation_id = $org_id and deleted = 1";

	$qh = mysql_query($sql, $conn);

	$events = array();

	if($qh!=false){
		while ($line=mysql_fetch_assoc($qh)){
			$events[] = $line;
		}
	}

	//print("<pre>". var_dump($events) . "</pre>");
	return $events;

}

function get_event($id, $org_id){
	global $conn;

	$sql = "Select * from event where id=$id and organisation_id=$org_id";

	$qh = mysql_query($sql, $conn);
	$row = array();
	if($qh){
		$row = mysql_fetch_assoc($qh);
	}
	/*while($line=){
	 $row = $line;
	 }*/

	return $row;

}

function get_event_from_id($id){
	global $conn;

	$sql = "Select * from event where id=$id;";

	$qh = mysql_query($sql, $conn);
	$row = array();
	if($qh){
		$row = mysql_fetch_assoc($qh);
	}
	/*while($line=){
	 $row = $line;
	 }*/

	return $row;
}

function get_event_name($event_id, $org_id){
	$event = get_event($event_id, $org_id);
	return $event['event_name'];
}


function create_timetable($timetable, $event_id){
	global $conn;

	foreach($timetable as $row){
		$start_date = strlen($row['start'])<1? "null" : strtotime($row['start']);
		$start_time = strlen($row['start_time'])<1 ? "null" : strtotime($row['start_time']);
		$end_time =   strlen($row['end_time'])<1 ? "null" : strtotime($row['end_time']);
		$option_id = strlen($row['option_id'])>0 ? $row['option_id'] : 0;

		/*Sometimes there is no end date - one-day events*/
		if(array_key_exists('end', $row)){
			$end_date = strlen($row['end'])<1 ? "null" : strtotime($row['end']);
		}
		else{
			$end_date = "null";
		}

		$location = mysql_real_escape_string(strlen($row['location'])<1 ? "null" : $row['location']);

		
		//echo("Option_id = $option_id");
		//check if the row already exists
		$sql_check = "Select id from event_option where id=$option_id;";
		$qh = mysql_query($sql_check, $conn);
		$update = mysql_num_rows($qh)>0;
		
		if($update){//then this is an update
			update_timetable_row($start_date, $end_date, $start_time, $end_time, $location, $option_id);
		}
		else{
			insert_timetable_row($start_date, $end_date, $start_time, $end_time, $location, $event_id);
		}
	}

	//mysql_query($sql, $conn);
}

function insert_timetable_row($start_date, $end_date, $start_time, $end_time, $location, $event_id){
	global $conn;
	$sql = "insert into event_option (o_start, o_end, start_time, end_time, event_id)
              values";
	$sql_loc = "insert into location (location, options_id) values";
	//print_r($row);

	if($start_date!="null"){
		$sql = $sql . " ($start_date, $end_date, $start_time, $end_time, $event_id);";

		mysql_query($sql, $conn);

		if($location!="null"){
			$options_id = mysql_insert_id($conn);
			$sql_loc = $sql_loc . " ('$location', $options_id);";
			//alert($sql_loc);
			mysql_query($sql_loc, $conn);
		}
	}
}


function update_timetable_row($start_date, $end_date, $start_time, $end_time, $location, $option_id){
	global $conn;

	if($location=="null"){
		$delete = "delete from event_option where id=$option_id;";
		mysql_query($delete, $conn);

		$delete = "Delete from location where options_id=$option_id;";
		mysql_query($delete, $conn);

		$delete ="Delete from member_option where option_id=$option_id;";
		mysql_query($delete, $conn);

	}
	else{
		$sql = "Update event_option set o_start=$start_date, o_end=$end_date, start_time=$start_time, end_time=$end_time
						where id=$option_id;";
		mysql_query($sql, $conn);

		$sql_loc = "Update location set location='$location' where options_id=$option_id;";
		mysql_query($sql_loc, $conn);
	}
}

function get_timetable_count($event_id){
	global $conn;

	$sql = "Select id from event_option where event_id=$event_id order by id";
	$qh = mysql_query($sql, $conn);

	$count=0;

	while(mysql_fetch_array($qh)){
		$count++;
	}

	return $count ;
}

function get_timetable($event_id, $date_format){
	global $conn;

	//$date_format = "d-m-Y";
	//$date_format = "D, d M Y";
	$time_format = "g:i A";

	$sql = "Select * from event_option where event_id=$event_id order by id";
	$qh = mysql_query($sql, $conn);

	$timetable = array();
	while($line = mysql_fetch_assoc($qh)){
		$temp = array();

		$temp['start'] = get_date($date_format, $line['o_start']);

		if(strlen($line['o_end'])>0){
			$temp['end'] = get_date($date_format, $line['o_end']);
		}
		else{
			$temp['end'] = "";
		}

		$temp['start_time'] = get_date($time_format, $line['start_time']);

		$temp['end_time'] = get_date($time_format,$line['end_time']);

		$temp['option_id'] = $line['id'];
			
		$locale = get_location($line['id']);
		if(count($locale)>0){
			$temp['location'] = $locale['location'];
		}
		else{
			$temp['location'] = null;
		}

		$timetable[] = $temp;

	}

	$count = count($timetable);
	if ($count<=7){
		$diff = 7-$count;
		while($diff>0){
			$diff--;
			$temp = array();
			$temp['start'] = null;
			$temp['end'] = null;
			$temp['start_time'] = null;
			$temp['end_time'] = null;
			$temp['location'] = null;
			$temp['option_id'] = null;
			$timetable[] = $temp;
		}
	}

	//echo("<pre>". print_r($timetable)."</pre>");
	return $timetable;
}

function get_location($option_id){
	global $conn;
	$sql = "Select * from location where options_id=$option_id;";
	$qh = mysql_query($sql, $conn);
	return mysql_fetch_assoc($qh);
}

function event_has_ipx($event_id){
	global $conn;

	$exist = false;

	$sql = "Select * from link where event_id=$event_id";
	$qh = mysql_query($sql, $conn);

	while($line=mysql_fetch_assoc($qh)){
		if(!is_bool($line)){
			$exist = true;
		}
	}

	return $exist;
}


function get_member_email($event_id){
	global $conn;

	$sql = "select email from organisation, event
          where
          event.organisation_id = organisation.id and
          event.id = $event_id;";

	$qh = mysql_query($sql, $conn);

	$email = mysql_fetch_assoc($qh);

	return $email['email'];
}


function create_link($event_id, $link ,$ipx){
	global $conn;

	$sql = "Insert into link (event_id, link, reference) values ($event_id, '" . mysql_real_escape_string($link) . "','" . mysql_real_escape_string($ipx) . "');" ;

	//print($sql);

	mysql_query($sql, $conn);
}

function get_link($event_id){
	global $conn;

	$sql = "Select * from link where event_id=$event_id";
	$qh = mysql_query($sql, $conn);

	$link = mysql_fetch_assoc($qh);

	return $link;
}

function create_member_choice($member_id, $option_ids){
	global $conn;

	foreach($option_ids as $key=>$option_id ){
		$sql = "Insert into member_option (member_id, option_id)
            values ($member_id, $option_id);";
		mysql_query($sql, $conn);
	}

}

function remove_old_choices($member_id){
	global $conn;

	$sql = "Delete from member_option where member_id=$member_id;";

	mysql_query($sql, $conn);
}

function event_has_poll_results($event_id){
	global $conn;

	$exists = false;

	$sql = "select member_id from member_link, link
          where
          member_link.reference = link.reference and
          link.event_id=$event_id;";
	$qh = mysql_query($sql, $conn);

	if($qh){
		while($row = mysql_fetch_array($qh)){
			if(!is_bool($row)){
				$exists = true;
			}
		}
	}
	return $exists;
}

function is_multi_day_event($event_id){
	global $conn;

	$sql = "Select multi_day from event where id=$event_id;";
	$qh = mysql_query($sql, $conn);

	$row = mysql_fetch_array($qh);
	if($row[0]==0){
		return false; //not multi-day event
	}
	else{
		return false; //multi-day event
	}

}

function get_poll_result_list($event_id){
	global $conn;
	/*$sql = "select m.id, m.first_name, m.last_name, mo.option_id
	 from member m, member_option mo, link l, member_link ml
	 where
	 ml.reference = l.reference and
	 ml.member_id = mo.member_id and
	 m.id = mo.member_id and
	 l.event_id = $event_id;";*/
	$time_format = "g:i A";
	$multiday = is_multi_day_event($event_id);

	$sql = "select m.first_name, m.last_name, mo.option_id,
		eo.o_start, eo.start_time, eo.end_time,";

	if($multiday){
		$sql = $sql . " eo.o_end, ";
	}

	$sql = $sql .	" lc.location
		from member m, member_option mo, link l, member_link ml, event_option eo, location lc
		where
		ml.reference = l.reference and
		ml.member_id = mo.member_id and
		m.id = mo.member_id and
		eo.id = mo.option_id and
		lc.options_id = eo.id and
		l.event_id = $event_id order by mo.option_id;";

	$qh = mysql_query($sql, $conn);

	$first = 0;
	$check = 0;
	$counter=0;
	$results = array();
	$line = array();
	if($qh){
		while($row = mysql_fetch_assoc($qh)){

			$first = $row['option_id'];
			if($first!=$check){
				if($check!=0){
					$line['count'] = $counter;
					$results[] = $line;
					$line = array();
					$counter = 0;
				}
				$line['option_id'] = $first;
				$line['location'] = $row['location'];
				$line['o_start'] = get_date(LONG_DATE, $row['o_start']);
				if($multiday){
					$row['o_end'] = get_date(LONG_DATE, $row['o_end']);
				}
				$line['start_time'] = get_date($time_format, $row['start_time']);
				$line['end_time'] = get_date($time_format, $row['end_time']);
				$check = $first;
			}
			$counter++;
		}
		$line['count'] = $counter;
		$results[] = $line;
	}

	//echo('<pre>'.print_r($results) . '</pre>');

	return $results;
}

/**
 * Removes all the old choices
 * @param $event_id
 */
function remove_link($event_id){
	global $conn;

	$link="";

	$sql = "select distinct ml.member_id, ml.reference
	from member_link ml, link l where ml.reference = l.reference and l.event_id = $event_id;";

	$qh = mysql_query($sql, $conn);

	if(count(mysql_fetch_array($qh))>0){

		while($row=mysql_fetch_assoc($qh)){
			$link = $row['reference'];
			$sql = "Delete from member_option where member_id=" . $row['member_id'] . ";";
			mysql_query($sql, $conn);
		}

		$sql = "Delete from member_link where reference='$link';";

		mysql_query($sql, $conn);
	}
}

function delete_event($event_id){
	global $conn;

	$sql = "UPDATE event set deleted=1 where id=$event_id";

	mysql_query($sql, $conn);

}

function get_members_per_selection($option_id){
	global $conn;

	$sql = "select first_name, last_name from member_option, member
			where 
			member_option.member_id=member.id and
			member_option.option_id =$option_id;";

	$qh = mysql_query($sql, $conn);

	$people = array();
	while($row = mysql_fetch_assoc($qh)){
		$people[] = $row;
	}

	return $people;
}

/**
 * the amount of people who have responded
 * @param $event_id
 */
function get_poll_count($event_id){
	global $conn;

	$sql = "select member_id from member_link, link
          where
          member_link.reference = link.reference and
          link.event_id=$event_id;";
	$qh = mysql_query($sql, $conn);

	$counter = 0;
	if($qh){
		while($row=mysql_fetch_array($qh)){
			$counter++;
		}
	}

	return $counter;
}

function get_all_responders($event_id){
	global $conn;

	$sql = "select distinct m.*
			from member m, member_option mo 
			left join event_option e on e.id = mo.option_id 
			where e.event_id=$event_id
			and m.id = mo.member_id;";

	$qh = mysql_query($sql, $conn);

	$results = array();
	while($row=mysql_fetch_assoc($qh)){
		$results[] = $row;
	}

	return $results;
}

function get_action($action){
	$actions = array();
	$actions[0] = "Please select the BEST option for you";
	$actions[1] = "Please select ALL the options when you are available";
	$actions[2] = "Please select ALL the options when you are NOT available";
	
	foreach($actions as $key=>$val){
		if($key==$action){
			return $val;
		}
	}
	
}
?>
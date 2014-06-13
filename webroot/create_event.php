<?php
include("./classes/events.php");

$create_event = get_request_var("create_event", false);

$name = get_request_var("event_name", "");
$description = get_request_var("event_description", "");
$organiser = get_request_var("contact_person", "");
$action = get_request_var("action", "");
$multi = get_request_var("multi", "");


$event_id = get_request_var("id", false);

$validate = true;

//check if the user is logged in
if(!user_is_logged_in()){
	show_page("l_o");
}

/*if(strlen($organiser)<1){
	$organiser = get_name_from_cookie();
}*/

if ($create_event!==false){
	//get the relevant information and create the event
	//validate the required fields

	if(!validate($name, $organiser, $multi, $validate)){
		error($errors);
	}
	else{
		$multi=="yes" ? $multi=1 : $multi=0;
		//check if there was an id passed in....
		if($event_id===false || strlen($event_id)<1){
			//create the event in the database
			create_event($name, $organiser, $description, $multi, $action);
		}else{
			update_event($name, $organiser, $description, $multi, $action,$event_id);

		}

		//after the event is created, show the list page
		show_page("l_e");
	}
}
//check if the id has been passed in
else{
	$event_data = get_event($event_id, get_org_id());
	if(count($event_data)>0){
		$name = $event_data["event_name"];
		$description = $event_data["description"];
		$organiser = $event_data["contact_person"];
		$multi = $event_data["multi_day"];
		$action = $event_data["action"];
	}
	//alert($multi);
}


function validate($name, $organiser, $multi, $validate){
	global $errors;

	//alert($name);
	if(!is_string($name) || strlen($name)<1){
		$errors = $errors . "* An event name is required <br />";
		$validate = false;
	}

	if(!ctype_alnum($organiser) && strlen($organiser)<1){
		$errors = $errors . "* The organiser (person responsible for this event) is required <br />";
		$validate = false;
	}

	if(!ctype_alpha($multi) || ctype_space($multi)){
		$errors = $errors . "* Select whether or not this is a multiple day event <br />";
		$validate = false;
	}

	return $validate;
}

?>


<form method="post" action="?" enctype="multipart/form-data"
	name="event_form" />
<table class="body-table" border="0">
	<tr>
		<td colspan="3">
		<h4>Create your <span class="easy">event</span>/meeting</h4>
		</td>
	</tr>
	<tr>
		<td valign="top"><label><span class="easy">event</span>/meeting name</label></td>
		<td colspan="2"><input class="name-of-meeting" type="text"
			name="event_name" value="<?php echo($name); ?>" /></td>
	</tr>
	<tr>
		<td valign="top"><label>Organiser</label></td>
		<td colspan="2"><input type="text" name="contact_person" id="org_contact"
			value="<?php echo($organiser); ?>" />&nbsp;<img
			src="./images/question.jpg" onclick="javascript:loadOrganiser('<?php echo(addslashes(get_name_from_cookie())); ?>');"
			title="Load the default name"></img></td>
	</tr>
	<tr>
		<td valign="top"><label>Description (500 Characters Maximum)</label></td>
		<td colspan="3"><textarea cols="50" rows="3" name="event_description"><?php echo($description); ?></textarea></td>
	</tr>
	<tr>
		<td colspan="3">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td valign="top">What should the responders choose?</td>
		<td colspan="3">
			<input type="radio" name="action" value="0" <?php echo( $action==0? 'checked':''); ?>>
			BEST SINGLE option <br /><br />
			<input type="radio" name="action" value="1" <?php echo( $action==1? 'checked':''); ?>>
			ALL options when available<br /><br />
			<input type="radio" name="action" value="2" <?php echo( $action==2? 'checked':''); ?>>
			Options when NOT available<br />
		</td>
	</tr>
	
	<tr>
		<td colspan="3">
			&nbsp;
		</td>
	</tr>
	
	<tr>
		<td valign="top"><label>Multiple Day Event</label></td>
		<td>
			<input type="radio" name="multi" value="yes" <?php echo($multi==1?'checked': ''); ?> /><label>Yes</label>
			&nbsp; 
			<input type="radio" name="multi" value="no"<?php echo($multi==0?'checked': ''); ?> /><label>No</label>
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td colspan="2" align="right"><input type="submit"
			value="<?php echo($event_id!==false && strlen($event_id)>0 ? "update event" : "create event"); ?>"
			name="create_event" /></td>
	</tr>
</table>
<input type="hidden" name="org_id" value="<?php echo(get_org_id()); ?>" />
<input type="hidden" name="page_name" value="c_e" /> <input
	type="hidden" name="id" value="<?php echo($event_id); ?>" /></form>


<script type="text/javascript">
	function loadOrganiser(val){
		document.getElementById("org_contact").value=val;
	}
</script>

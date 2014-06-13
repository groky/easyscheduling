<?php
require_once("./classes/events.php");

if(!user_is_logged_in()){
	show_page("l_o");
}

$events = get_events(get_org_id());
//print("<pre>" . var_dump($events) . "</pre>");
//print("<pre>" . var_dump($events) . "</pre>");

if(count($events)<1){
	show_page("c_e");
}
else{

	?>
<script type="text/javascript">
	function changeIcon(arg, id){
         //alert("getting ready to change the icon");
         if(arg==1){
        	 //document.getElementById(id).src="";
             document.getElementById(id).src = "images/minilogoblue.jpg";
         }
         else{
        	//document.getElementById(id).src="";
          	document.getElementById(id).src = "images/MiniEmptylogoblue.jpg";
         }
      }
</script>

<img
	src="./images/create_event.jpg" alt="new event" id="new-event"></img>
<a href="?page_name=c_e"> Create Event</a>

<table class="body-table" id="event-list">
	<thead>
		<tr>
			<th>Event Name</th>
			<th>Organiser</th>
			<th>Multi-day</th>
		</tr>
	</thead>

	<tbody>
	<?php
	//print("<pre>" . var_dump($events) . "</pre>");
	for($i=0;$i<count($events); $i++) {
		$event = $events[$i];
		$polls_exist = event_has_poll_results($event['id']);
		//alert($polls_exists);
		//print("<pre>" . var_dump($event) . "</pre>");
		?>
		<tr class="<?php echo($i%2>0? '': 'alternate'); ?>"
			onmouseover="javascript:changeIcon(1, 'icon<?php echo($i); ?>'); ShowContent('floating-div'); getEventInfo(<?php echo($event['id'])?>); return true;"
			onmouseout="javascript:changeIcon(0, 'icon<?php echo($i); ?>');HideContent('floating-div'); return true;">
			<td><img src="images/MiniEmptylogoblue.jpg"
				id="icon<?php echo($i); ?>"><?php echo($event["event_name"]); ?></td>
			<td><?php echo($event["contact_person"]); ?></td>
			<td><?php echo($event["multi_day"]==0 ? "no" : "yes"); ?></td>
			<td id="event_list"><a
				class="home" 
				href="?page_name=c_e&id=<?php echo ($event['id']); ?>"><img
				src="./images/edit.jpeg" alt="edit event"
				title="Edit <?php echo($event['event_name']); ?>'s event details"
				id="event-list"></img></a></td>
			<td id="event_list"><a
				class="home" 
				href="?page_name=t_t&id=<?php echo ($event['id']); ?>&multi=<?php echo($event["multi_day"]); ?>"><img
				src="./images/cal.gif" alt="view timetable"
				title="Edit Timetable for <?php echo($event['event_name']); ?>"
				id="event-list"></img></a></td>
				
		<!-- if there is no timetable information, don't give the chance to send the link-->	
		<?php  if(get_timetable_count($event['id'])>0){ ?>
			<td id="event_list"><a
				class="home" 
				href="?page_name=e_n&id=<?php echo ($event['id']); ?>&multi=<?php echo($event["multi_day"]); ?>"><img
				src="./images/email.jpeg" alt="create link"
				title="Create link to <?php echo($event['event_name']); ?>'s poll page"
				id="event-list"></img></a></td>
			<?php } ?>
		<!-- //end if -->
		
		<!-- if there are no results from the links emailed to pollers, don't show the option -->
				<?php if($polls_exist){ ?>
			<td id="event_list"><a
				class="home" 
				href="?page_name=r_p&id=<?php echo ($event['id']); ?>&multi=<?php echo($event["multi_day"]); ?>"><img
				src="./images/result.jpeg" alt="view result"
				title="See <?php echo($event['event_name']); ?>'s poll result page"
				id="event-list"></img></a></td>
				<?php } ?>
		<!-- //end if -->
		
			<td id="event_list"><a class="home" href="javascript:showLayer();createMessage('<?php echo(addslashes($event['event_name'])); ?>', <?php echo($event['id']); ?>);"><img
				src="./images/recycle-bin.jpg" alt="delete"
				title="Delete <?php echo($event['event_name']); ?> from list"
				id="event-list"></img></a></td>

		</tr>
		<?php } ?>
	</tbody>

</table>
<div id="floating-div"></div>

		<?php } 
//require_once('warning.php');
?>


<script type="text/javascript">

function getBrowserHeight() {
    var intH = 0;
    var intW = 0;
   
    if(typeof window.innerWidth  == 'number' ) {
       intH = window.innerHeight;
       intW = window.innerWidth;
    } 
    else if(document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        intH = document.documentElement.clientHeight;
        intW = document.documentElement.clientWidth;
    }
    else if(document.body && (document.body.clientWidth || document.body.clientHeight)) {
        intH = document.body.clientHeight;
        intW = document.body.clientWidth;
    }

    return { width: parseInt(intW), height: parseInt(intH) };
}  

function setLayerPosition() {
    var shadow = document.getElementById("shadow");
    //var question = document.getElementById("question");

    var bws = getBrowserHeight();
    shadow.style.width = bws.width + "px";
    shadow.style.height = bws.height + "px";

    //question.style.left = parseInt((bws.width - 350) / 2);
    //question.style.top = parseInt((bws.height - 200) / 2);

    shadow = null;
    //question = null;
}

function createMessage(event, id){
	var warning = "<p>Are you sure you want to delete <br /><br />";
	warning = warning + event + "?</p>";
	//alert(event);
	var input = "<form class=\"form_message\" enctype=\"multipart/form-data\" action=\"?page_name=e_d&id=";
	input = input + id + "\" method=\"post\"><input type=\"submit\" value=\"delete\" />";
	input = input + "</form><br />";	
	//alert(input);
	document.getElementById("warning").innerHTML = warning + input;
}

function showLayer() {
    setLayerPosition();

    var shadow = document.getElementById("shadow");
    var warn = document.getElementById("warn");

    shadow.style.display = "block"; 
	if (document.getElementById)
	{
		warn.style.display = "block";
		warn.style.visibility = "visible";
	
	}
	else if (document.all)
	{
		document.all["warn"].style.display = "block";
		document.all["warn"].style.visibility = "visible";
	
	}
	else if (document.layers)
	{
		document.layers["warn"].style.display = "block";
		document.layers["warn"].style.visibility = "visible";
	}

    shadow = null;
    warn = null;             
}

function hideLayer() {
    var shadow = document.getElementById("shadow");
    var warn = document.getElementById("warn");

    shadow.style.display = "none"; 
    warn.style.display = "none";

    shadow = null;
    warn = null; 
}

window.onresize = setLayerPosition;

</script>

<style>
div.topbox {
	/*position:absolute;*/	
	border: 2px solid blue;
	background-color: #fff;
	padding: 1px;
	filter: alpha(opacity = 85);
	opacity: 0.95;
	-moz-opacity: 0.95;
	/*font-family: verdana;*/
	letter-spacing: 0px;
	width: 600px;
	color: black;

	margin-left:auto;
	margin-right:auto;
 	
        /*top:0px;
        left:0px;*/
        display:none;
        z-Index:1001;
        text-align:center;
        vertical-align:middle;

}

div.topbox h1 {
	/*margin: 0px;*/
	padding: 10px 0px 0px 10px;
	font-size: 18px;
	font-weight: 700;
}

div.topbox p {
	/*margin: 0px;*/
	padding: 5px 10px 10px 15px;
	/*font-size: 12px;*/
	font-weight: 700;
}

div.topbox p a {
	color: #f90;
}

div.opaqueLayer {
	display: none;
	position: absolute;
	top: 0px;
	left: 0px;
	opacity: 0.6;
	filter: alpha(opacity = 60);
	background-color: #fff;
	z-Index: 1000;
}

form.form_message{
	position:relative;
	top:10px;
}

div.warning_logo{
	position:absolute;
	background: url(images/logoblue.jpg) no-repeat top left;
	width:70px;
	height:70px;
}
</style>


<div id="shadow" class="opaqueLayer"></div>
<div id="warn"
	style="display: block; position: absolute; top: 100px; left: 100px; visibility: hidden;"
	class="topbox">

<div
	style="background-color: blue; padding: 5px; text-align: right; font-size: 12px; font-weight: 700;"><a
	href="#" onclick="javascript:hideLayer();return false;"
	style="text-decoration: none; color: #fff;">cancel</a></div>
<div class="warning_logo">
</div>
<div id=warning>
</div>

<div
	style="background-color: blue; padding: 5px; text-align: right; font-size: 12px; font-weight: 700;"><a
	href="#" onclick="javascript:hideLayer();return false;"
	style="text-decoration: none; color: #fff;">close</a></div>

</div>


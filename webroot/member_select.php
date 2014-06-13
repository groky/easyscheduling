<?php
  include('./classes/events.php');
  include('./classes/profile.php');
  
  $errors = "";
  $validated = true;
  
  $ipx = get_request_var("ipx", false);
  $event_id = get_request_var("id", false);
  $create_poll = get_request_var("create_poll", false);
  
  $event = get_event_from_id($event_id);
  $timetable = get_timetable($event_id, LONG_DATE);
  
  $selection = null;
  $name = "";
  $surname= "";
  
  if($create_poll!==false){
    $selection = get_request_var("selection", false);
    $name = get_request_var("m_name", false);
    $surname = get_request_var("m_surname");

    //echo("<pre>".print_r($selection)."</pre>");
    
    //if this item already exists
    
    validate($name, $surname, $selection);
    $member_id=0;
    if($validated){
      //create the items in the database
      $result = is_member($ipx, $name, $surname);
      
      //echo("<pre>".print_r($result)."</pre>");
      $member_exists = $result['exists'];
      $member_id = $result['member_id'];
      if($member_exists){
        //delete the old member_options record
        remove_old_choices($member_id);
      }
      else{
        $member_id = insert_member($name, $surname);
        create_member_link($member_id, $ipx);
      }
      //create the current choice
      create_member_choice($member_id, $selection);
      
      //then send the mail to the organiser
      send_mail_to_organiser(get_member_email($event_id), $event, $name . " " . $surname);
      
      //and go to thank you page
      show_page("t_y");
    }
    else{
      error($errors);
    }
    
  }
  
  function validate($name, $surname, $selected){
    global $errors, $validated;
    
    if(strlen($name)<1 || !is_string($name)){
      $validated = false;
      $errors = $errors . "* Please provide your <strong>first name</strong> <br/>";
    }
    if(strlen($surname)<1 || !is_string($surname)){
      $validated = false;
      $errors = $errors . "* Please provide your <strong>surname</strong> <br/>";
    }
    
    //alert(count($selected));
    $watcher=false;
    if(!is_bool($selected)){
      $keys = array_keys($selected);
      //echo("<pre>".print_r($keys)."</pre>");
      for($y=0;$y<count($keys);$y++){
        //alert($y);
        $val = $keys[$y];
        if(array_key_exists($val, $selected)){
          //alert("Watcher is true... " . $watcher);
          $watcher=true;
          break;
        }
      }
    }
    
    //alert($watcher);
    
    if (!$watcher){
      $validated = false;
      $errors = $errors . "* You will need to select one of the options provided <br/>";
    }
  }
?>
<h3><?php echo ($event['event_name']); ?></h3>
<p><?php echo($event['description']); ?>. 
	<br />
	<br />
	<?php echo(get_action($event['action'])); ?>.</p>
<br />
<form method="post" action="?" enctype="multipart/form-data">
  <table class="">
    <tr>
      <td class="time-table"><label>name</label></td>
      <td class="time-table"><input type="text" name="m_name" value="<?php echo($name); ?>"/></td>
    </tr>
    <tr>
      <td class="time-table"><label>surname</label></td>
      <td class="time-table"><input type="text" name="m_surname" value="<?php echo($surname); ?>"/></td>
    </tr>
    <tr>
      <td class="spacer">&nbsp;</td>
    </tr>

    <tr>
      <td class="option-title">Start</td>
      <td class="option-title">End</td>
      <td class="option-title">Location</td>
    </tr>
    <?php for($option=0;$option<count($timetable);$option++){ 
              $row = $timetable[$option];
              if(strlen($row['start'])>1){
    ?>
      <tr class="<?php echo($option%2>0? '': 'alternate'); ?>">
        <td class="time-table">
        <?php 
          
            echo($row['start'] . " @ " . $row['start_time']);
         
        ?>
        </td>
        <td class="time-table">
        <?php
          if(strlen($row['end'])<1){
            echo($row['end_time']);
          }
          else{
            echo($row['end'] . " @ " . $row['end_time']); 
          }
        ?>
        </td>
        
        <td class="time-table">
          <?php echo($row['location']); ?>
        </td>
        <td class="time-table">
          <input type="checkbox" name="selection[<?php echo($option); ?>]" value="<?php echo($row['option_id']); ?>" <?php if(!is_bool($selection) && !is_null($selection)){if(array_key_exists($option, $selection)){if($selection[$option]==$row['option_id']){echo('checked');}}} ?>
          />
        </td>
      </tr>
    <?php }} ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><input type=submit name="create_poll" value="submit choice" /></td>
    </tr>
  </table>
  <input type="hidden" name="page_name" value="m_s" />
  <input type="hidden" name="id" value="<?php echo($event_id); ?>" />
  <input type="hidden" name="ipx" value="<?php echo($ipx); ?>" />
</form>
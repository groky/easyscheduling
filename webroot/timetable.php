<?php
  include('./classes/events.php');
  include('./webroot/time.php');
  
  $errors = "";
  $valid = true;
  $current_event = false;
  
  $create_times = get_request_var('create_times', false);
  $event_id = get_request_var('id', false);
  $multi = get_request_var('multi', false);
  
  $timetable = get_request_var('tt', false);
  
  if(!user_is_logged_in()){
    show_page("l_o");
  }
  
  if($create_times!==false){
    //echo('<pre>'. print_r($timetable) . '</pre>');
    $timetable = createTimeTableArray($timetable, $multi);
    validate($timetable, $multi);
    if(!$valid){
      error($errors);
    }
    else{
    //create the items in the database
      //echo('<pre>'. print_r($timetable) . '</pre>');
      create_timetable($timetable, $event_id, $multi);
      show_page('l_e');
    }
  }else{
  
    $timetable = get_timetable($event_id, SHORT_DATE);
    //
    if(count($timetable)>0){
      $test = $timetable[0];
      if(strlen($test['start'])>0){
        $current_event = true;
      }
    }
  }
  
  /**
   * turn the table into useful array - for validation and
   * database use
  */
  function createTimeTableArray($timetable, $multi){
    $temp_array = array();
    $temp = array();
    $x = 0;
    
    $y = $multi==1 ? 6 : 5; //orginally 4:3 - this gives the amount of columns to check
    
    foreach($timetable as $key=>$val){
      $y--;
      //load the string in as the value for the name/value pair.
      $temp[substr($key, 0, strlen($key)-2)] = $val;
      //$temp[] = array(substr($key, 0, strlen($key)-2) => $val);

      if($y==0){
        $temp_array[] = $temp;
        $temp = array();
        $y = $multi==1 ? 6 : 5;
        $x++;
      }

    }
    
    //$temp_array[] = $temp;
    //echo ('<pre>' .print_r($temp_array) . '</pre><br/>');
    return $temp_array;
  }
  
  
  function validate($times, $multi){
      for($row=0;$row<count($times);$row++){
        $row_array = $times[$row];
        validate_row($row_array, $multi, $row+1);
      }
  }
  
  function validate_row($row_array, $multi, $row_number){
    global $errors, $valid;
    
    $today = strtotime(date('d-M-Y'));
    
    $start_date = $row_array['start'];
    $start_time = $row_array['start_time'];
    $end_time = $row_array['end_time'];
    $end_date = $multi==1 ? $row_array['end'] : null;
    $location = $row_array['location'];
    
    $is_end_date_null = $end_date==null ? true : false;
    /*
    * check to see if the start date is before the end date for multi
    * check that the start time is after the end time if the 
    *
    */
    if(strlen($start_date)<1 && strlen($start_time)<1 && strlen($end_time)<1 && strlen($end_date)<1){
      return;
    }
    
    //alert($today);
    $start_date = strtotime($start_date);
    
    $start_time = strtotime($start_time);
    $end_time = strtotime($end_time);
    
    //start must be after today
    if($start_date<=$today){
      $valid = false;
      $errors = $errors . "* The start date must be after today on <strong>ROW $row_number</strong>. <br/>";
    }
    
    //if there is an end date, ensure it is after the start date
    if(!$is_end_date_null){
      //alert($start_date);
      $end_date = strtotime($end_date);
      //check if they have an end_date with the start date
      //alert(strlen($end_date));

      //alert($end_date);
      if($end_date<$start_date){
        $valid = false;
        $errors = $errors."* Ensure the end date is after the start date on <strong>ROW $row_number</strong><br/>";
      }
      
      if($end_date==$start_date){
        if(!validateStartEndTime($start_time, $end_time)){
          $valid = false;
          $errors = $errors . "* Ensure your end time is after the start time on <strong>ROW $row_number</strong><br/>";
        }
      }
    }
    else{
      if($multi==1){
        if(strlen($start_date)>1 && strlen($end_date)<1){
          $valid = false;
          $errors = $errors . "* An end date is required on <strong>ROW $row_number</strong><br />";
        }
      }
      
      if(!validateStartEndTime($start_time, $end_time)){
        $valid = false;
        $errors = $errors . "* Ensure your end time is after the start time on <strong>ROW $row_number</strong><br/>";
      }
      
    }
    
    //check if the date was added
    if(strlen($start_date)>0 && strlen($start_time)>0 && strlen($end_time)>0 && strlen($location)<1){
      $valid = false;
      $errors = $errors . "* Please add a location for <strong>ROW $row_number</strong><br/>";    
    }
    
  }
  
  function validateStartEndTime($start_time, $end_time){
    if($end_time<=$start_time){
      return false;
    }
    
    return true;
  }
?>
  <h4><?php echo (get_event_name($event_id, get_org_id())); ?></h4>
    <script type="text/javascript">
	function createCalendarControl(form_name, control_name){
    new tcal ({
      // form name
      'formname': form_name,
      // input name
      'controlname': control_name
    });
	}
	</script>
    <!-- the table !-->
    <form action="?" enctype="multipart/form-data" name="event_form" method="post"/>
    <table class="time-table-position">
    <tr>
      <td>&nbsp;</td>
      <td class="option-title">Start Date</td>
      <td class="option-title"> Start Time</td>
      <td class="option-title">End Time</td>
      <?php if($multi==1) { ?>
      <td class="option-title">End Date</td>
      <?php } ?>
      <td class="option-title">Location</td>
    </tr>
    <?php for($i=0;$i<7;$i++) {
      if($timetable!==false && count($timetable)>0){
        $table_row = $timetable[$i];
        $s_date = $table_row['start'];
        $e_date = $multi==1?$table_row['end']:null;
        $s_time = $table_row['start_time'];
        $e_time = $table_row['end_time'];
        $location = $table_row['location'];
        $option_id = $table_row['option_id'];
      }
      else{
        $s_date = null;
        $e_date = null;
        $s_time = null;
        $e_time = null;
        $location = null;
        $option_id = null;
      }
      
    ?>
      <tr class="time-table-line">
        <td class="time-table"><?php echo $i+1; ?></td>
        <td class="time-table">
          <input class="date-box" type="text" name="tt[start_<?php echo $i+1; ?>]" id="start_<?php echo $i+1; ?>" value="<?php echo($s_date); ?>" readonly />
          <script>javascript:createCalendarControl('event_form', 'tt[start_<?php echo $i+1; ?>]');</script>
        </td>
        <td class="time-table">
          <?php create_time_control('start', $i+1, $s_time); ?>
        </td>
        <td class="time-table">
          <?php create_time_control('end', $i+1, $e_time); ?>
        </td>
        <?php if ($multi==1) { ?>
        <td class="time-table">
          <input class="date-box" type="text" name="tt[end_<?php echo $i+1; ?>]" id="end_<?php echo $i+1; ?>" value="<?php echo($e_date); ?>" readonly />
          <script>javascript:createCalendarControl('event_form', 'tt[end_<?php echo $i+1; ?>]');</script>
        </td>
        <?php } ?>
        <td>
          <input type="text" name="tt[location_<?php echo $i+1; ?>]" id="[location_<?php echo $i+1; ?>]" value="<?php echo($location); ?>" />
          <input type="hidden" name="tt[option_id_<? echo $i+1; ?>]" value="<?php echo($option_id); ?>" />
        </td>
      </tr>
    <?php }?>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php if ($multi==1) { ?><td></td><?php } ?>
      <td><input type="submit" name="create_times" value="<?php echo($current_event ? "update times" : "create times"); ?>" /></td>
    </tr>
    </table>
    <input type="hidden" value="t_t" name="page_name" />
    <input type="hidden" value="<?php echo($multi); ?>" name="multi" />
    <input type="hidden" value="<?php echo($event_id); ?>" name="id"/>    
    </form>
    <!--end of the table !-->
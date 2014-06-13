<?php
  $val = get_request_var("event_type", false);
  if($val!==false){
    if($val=="single"){
?>    
    
    <?php for($i=0;$i<7;$i++) {?>
      <tr>
        <!--<td></td>!-->
      </tr>
      <tr>
        <td><label>Option <?php echo $i+1; ?></label></td>
        <td><label>Start</label>&nbsp;<input class="date-box" type="text" name="start_<?php echo $i+1; ?>" id="start_<?php echo $i+1; ?>"/>
        <script>javascript:createCalendarControl('event_form', 'start_<?php echo $i+1; ?>');</script></td>
        <td><label>End</label>&nbsp;<input class="date-box" type="text" name="end_<?php echo $i+1; ?>" id="end_<?php echo $i+1; ?>" />
        <script>javascript:createCalendarControl('event_form', 'end_<?php echo $i+1; ?>');</script></td>
      </tr>
    <?php }?>

      
<?php
    }
    else{
    ?>
     <?php for($i=0;$i<7;$i++) {?>
      <tr>
        <!--<td></td>!-->
      </tr>
      <tr>
        <td><label>Option <?php echo $i+1; ?></label></td>
        <td><label>Start</label>&nbsp;<input class="date-box" type="text" name="start_<?php echo $i+1; ?>" id="start_<?php echo $i+1; ?>"/>
        <script>javascript:createCalendarControl('event_form', 'start_<?php echo $i+1; ?>');</script></td>
        <td><label>End</label>&nbsp;<input class="date-box" type="text" name="end_<?php echo $i+1; ?>" id="end_<?php echo $i+1; ?>" />
        <script>javascript:createCalendarControl('event_form', 'end_<?php echo $i+1; ?>');</script></td>
      </tr>
    <?php }?>
    <?php
    }
  }; //if
?>

      <tr>
        <td><input type="hidden" name="org_id" value="<?php echo(get_org_id()); ?>" /></td>
        <td><input type="hidden" name="page_name" value="c_e" /></td>
        <td colspan="2" align="right"><input type="submit" value="create_event" /></td>
      </tr>
<?php
  $start_end;
  $option;
  $time;
  define('TIME', "_time_");
  define('CLOCK', "_clock_");
  
  function create_time_control($var1, $var2, $t = null){
    global $start_end, $option;
    
    $start_end = $var1;
    $option = $var2;
    $time = $t;
  
?>
<script type="text/javascript">
  $(document).ready (function(){
    $("#<?php echo($start_end . CLOCK . $option); ?>").clockpick({
      starthour : 0,
      endhour : 23,
      valuefield: '<?php echo('tt['.$start_end . TIME . $option . ']'); ?>',
      showminutes : true
    }, callBackFor_<?php echo($start_end . TIME . $option); ?>
    ); 
  });
  
  function callBackFor_<?php echo($start_end . TIME . $option); ?>(){
    //alert("creating!");
  }
</script>

<input type="text" maxlength="5" id="<?php echo($start_end . TIME . $option); ?>" name="tt[<?php echo($start_end . TIME . $option); ?>]" class="date-box" value="<?php echo($time); ?>" readonly />
<img src="./images/clock.jpeg" alt="select time" id="<?php echo($start_end . CLOCK . $option); ?>"></img>

<?php
}
?>
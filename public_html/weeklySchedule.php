<?php

  $openHours = array_fill(0, 6, array_fill(0, 11, 0));

  $jsonSched = $_GET['sched'];
  $sched = json_decode($jsonSched);
  $type = $_GET['type'];

  echo draw_schedule($sched, $type);
  
  /* draws a schedule, using any previous information that needs to be included and specifying the type of these inputs*/
  function draw_schedule($currentSchedule = null, $inputType = 0){

    $closed = -1;
    $open = 0;
    $preferred = 1;
    $busy = 2;

    if($currentSchedule == null):
      $currentSchedule = $openHours;
    endif;

    // link to the correct CSS
    $schedGrid =  '<link rel="stylesheet" href="./CSS/weeklySchedule.css">';
    $schedGrid .=  '<script src="./AdminPages/adminForm.js"></script>';

    $schedGrid .=  '<h6 style = "display: none" id = "holder" value = "'.$jsonSched.'"></h6>';

    /* draw table */
    $schedGrid .= ' <div id = "schedule" style="width: 60%">';
    $schedGrid .= '<table cellpadding="0" cellspacing="0" class="schedule" style="width:800px">';

    /* table headings */
    $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
    $schedGrid .=  '<tr class="schedule-row">
        <td class="schedule-day-head" style = "border-left: 1px solid #999"></td>';

    $schedGrid .= '<td class="schedule-day-head">'.implode('</td><td class="schedule-day-head">',$headings).'</td></tr>';

    /* days and hours vars now ... */
    $hours_per_day = 11;
    $days_in_this_week = 1;
    $day_counter = 0;

    // iterates through the rows
    for($curr_hour = 0; $curr_hour <= $hours_per_day; $curr_hour++):
      
      $schedGrid .= '<tr class="schedule-row">';

      // iterates through the days
      for($curr_day = 0; $curr_day < 7; $curr_day++):

        // properly format time based on standard time practices
        if($curr_day == 0):
          $unit = 'am';
          $hour = 9 + $curr_hour;

          if($hour >= 12):
            
            if($hour > 12):
              $hour -= 12;
            endif;
            
            $unit = 'pm';

          endif;

          $schedGrid .= '<td class="shift-time"> <p>'.$hour.':00 '.$unit.' </p></td>';

        else:

          $onclick = '';
          
          if ($currentSchedule[$curr_day - 1][$curr_hour] == $inputType): 
            $onclick= 'saveTimes('.$inputType.','.$curr_day.','.$curr_hour.')';

          endif;
          
          if($currentSchedule[$curr_day - 1][$curr_hour] === $closed):
            $schedGrid .= '<td class="closed-shift" id = "'.$curr_day.'-'.$curr_hour.'" onclick = "'.$onclick.'"></td>';  

          elseif($currentSchedule[$curr_day - 1][$curr_hour] === $busy):
            $schedGrid .= '<td class="busy-shift" id = "'.$curr_day.'-'.$curr_hour.'" onclick = "'.$onclick.'"></td>';  

          elseif($currentSchedule[$curr_day - 1][$curr_hour] === $preferred):
            $schedGrid .= '<td class="preferred-shift" id = "'.$curr_day.'-'.$curr_hour.'" onclick = "'.$onclick.'"></td>';  

          else:
            
            // each hour block will have an ID based on the day and hour (in military representation) at which it is located
            $schedGrid.='<td class="open-shift" id = "'.$curr_day.'-'.$curr_hour.'" onclick= "saveTimes('.$inputType.','.$curr_day.','.$curr_hour.')"></td>';   
            
          endif;
        
        endif;

      endfor;
        
      $schedGrid .= '</tr>';

    endfor;

    /* final row */
    $schedGrid .= '</tr>';

    /* end the table */
    $schedGrid .= '</table>';

    $schedGrid .= '</div>';

    $schedGrid .=  '<script> setSchedule('.json_encode($currentSchedule).');</script>';
    
    /* all done, return result */
    return $schedGrid;
  }
?>
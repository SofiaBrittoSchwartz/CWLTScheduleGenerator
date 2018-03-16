<script src = "./AdminPages/adminForm.js"></script>

<?php

  $openHours = array_fill(0, 6, array_fill(0, 11, 0));

  $schedule = $openHours;

  $sched = json_decode($_GET['sched']);
  $type = $_GET['type'];

  echo "schedule: ".$sched;
  echo nl2br("\n".$type);
  echo draw_schedule($sched, $type);
  
  /* draws a schedule, using any previous information that needs to be included and specifying the type of thes*/
  function draw_schedule($currentSchedule = null, $inputType = 0){

    $closed = -1;
    $open = 0;
    $prefered = 1;
    $busy = 2;

    // if($currentSchedule === null):
    //   $currentSchedule = $openHours;
    // endif;

    echo nl2br("\ncurrentSchedule:".$currentSchedule);
    // echo "isArray: ".is_array($currentSchedule);

    // link to the correct CSS
    echo '<link rel="stylesheet" href="./CSS/weeklySchedule.css">';

    /* draw table */
    $schedGrid = ' <div id = "schedule" style="width: 60%">';
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
      
      $schedGrid.= '<tr class="schedule-row">';

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

          $schedGrid.='<td class="shift-time"> <p>'.$hour.':00 '.$unit.' </p></td>';

        else:
          // echo nl2br("\nvalue: ".$currentSchedule[$curr_day][$curr_hour]);
          echo "closed: " .$closed;

          if($currentSchedule[$curr_day - 1][$curr_hour] === $closed):
            
            echo nl2br("\nclosedValue: ".$currentSchedule[$curr_day - 1][$curr_hour]);
            $schedGrid.='<td class="closed-shift" id = "'.$curr_day.'-'.$curr_hour.'"></td>';  

          elseif($currentSchedule[$curr_day - 1][$curr_hour] === $busy):
            
            echo nl2br("\nbusyValue: ".(string)$currentSchedule[$curr_day - 1][$curr_hour]);
            $schedGrid.='<td class="busy-shift" id = "'.$curr_day.'-'.$curr_hour.'"></td>';  

          elseif($currentSchedule[$curr_day - 1][$curr_hour] === $prefered):
            $schedGrid.='<td class="prefered-shift" id = "'.$curr_day.'-'.$curr_hour.'"></td>';             
          else:
            
            echo nl2br("\ndefaultValue: ".(string)$currentSchedule[$curr_day - 1][$curr_hour]);
            
            // each hour block will have an ID based on the day and hour (in military representation) at which it is located
            $schedGrid.='<td class="open-shift" id = "'.$curr_day.'-'.$curr_hour.'" onclick= "saveTimes('.$inputType.','.$curr_day.','.$curr_hour.')"></td>';   
          endif;
        
        endif;

      endfor;
        
      $schedGrid.= '</tr>';

    endfor;

    /* final row */
    $schedGrid.= '</tr>';

    /* end the table */
    $schedGrid.= '</table>';

    $schedGrid.= '</div>';
    
    /* all done, return result */
    return $schedGrid;
  }
?>
<style>
  /* schedule */
  table.schedule { border-left:1px solid #999; }
  
  tr.schedule-row {}
  
  td.schedule-day { 
    min-height:80px; 
    font-size:11px; 
    position:relative; 
    height: 40px; 
  } * html div.schedule-day { height:40px; }
  
  td.schedule-day:hover { background:#eceff5; }
  
  td.schedule-day-np  { 
    background:#eee; 
    min-height:80px; 
    position:relative; 
    height: 100px;
  } * html div.schedule-day-np { height:100px; }
  
  td.schedule-day-head { 
    background:#ccc; 
    font-weight:bold; 
    text-align:center; 
    width:100px; 
    padding:5px; 
    border-bottom:1px solid #999; 
    border-top:1px solid #999; 
    border-right:1px solid #999; 
  }

  div.day-number { 
    padding:5px; 
    color:#000;
    font-size: 15;
    font: initial;
    float:right; 
    margin-top: -38%;
    margin-right: -1%; 
    width:20px; 
    text-align:center;
  }

  /* shared */
  td.schedule-day, td.schedule-day-np { 
    width:100px; 
    padding:5px; 
    border-bottom:1px solid #999; 
    border-right:1px solid #999; 
  }

  p {
    text-align: center;
    font-size: 16;
  }
</style>

<html>
  <?php
    echo draw_schedule(1,2018);
    
    /* draws a schedule */
    function draw_schedule($month,$year){

      /* draw table */
      $schedule = ' <div id = "schedule" style="width: 60%">';
      $schedule .= '<table cellpadding="0" cellspacing="0" class="schedule" style="width:800px">';

      /* table headings */
      // TODO: change Saturday to Sunday
      $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
      $schedule .=  '<tr class="schedule-row">
          <td class="schedule-day-head" style = "border-left: 1px solid #999"></td>';

      $schedule .= '<td class="schedule-day-head">'.implode('</td><td class="schedule-day-head">',$headings).'</td></tr>';

      /* days and weeks vars now ... */
      $hours_per_day = 12;
      $days_in_this_week = 1;
      $day_counter = 0;
      $dates_array = array();

      /* row for week one */
      $schedule.= '<tr class="schedule-row">';

      // iterates through the rows
      for($curr_hour = 0; $curr_hour <= $hours_per_day; $curr_hour++):
        
        $schedule.= '<tr class="schedule-row">';

        // iterates through the days
        for($curr_day = 0; $curr_day < 7; $curr_day++):

          if($curr_day == 0):
            $unit = 'am';
            $hour = 9 + $curr_hour;

            if($hour >= 12):
              
              if($hour > 12):
                $hour -= 12;
              endif;
              
              $unit = 'pm';

            endif;

            $schedule.='<td class="schedule-day"> <p>'.$hour.':00 '.$unit.' </p></td>';

          else:
            $schedule.='<td class="schedule-day"></td>';    
          endif;

        endfor;
          
        $schedule.= '</tr>';

      endfor;

      /* final row */
      $schedule.= '</tr>';

      /* end the table */
      $schedule.= '</table>';

      $schedule.= '</div>';
      
      /* all done, return result */
      return $schedule;
    }
  ?>
</html>
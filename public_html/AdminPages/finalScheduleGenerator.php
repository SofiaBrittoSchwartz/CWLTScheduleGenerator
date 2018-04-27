<?php

  // $openHours = array_fill(0, 6, array_fill(0, 11, 0));
	$fileName = "../../Algorithm/Algorithm/testOutput.json";
	$file = fopen($fileName, "r");
	$data = fread($file, filesize($fileName));

	$sched = json_decode($data);
	print_r($sched[0]->tutors);


	echo draw_schedule($sched);

	/* draws a schedule, using any previous information that needs to be included and specifying the type of these inputs*/
	function draw_schedule($currentSchedule)
	{
		echo $currentSchedule;

		// link to the correct CSS
		$schedGrid =  '<link rel="stylesheet" href="../CSS/weeklySchedule.css">';
		// $schedGrid .=  '<script src="./AdminPages/adminForm.js"></script>';

		/* draw table */
		$schedGrid .= ' <div id = "schedule" style="width: 60%">';
		$schedGrid .= '<table cellpadding="0" cellspacing="0" class="schedule" style="width:800px">';

		/* table headings */
		$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
		$schedGrid .=  '<tr class="schedule-row"> <td class = "schedule-day-head" style = "border-left: 1px solid #999"></td>';

		$schedGrid .= '<td class="schedule-day-head">'.implode('</td><td class="schedule-day-head">',$headings).'</td></tr>';

		/* days and hours vars now ... */
		$hours_per_day = 12;
		$days_in_this_week = 1;
		$day_counter = 0;
		$iterator = 0;

		// iterates through the rows
		for($curr_hour = 0; $curr_hour <= $hours_per_day; $curr_hour++):

			$schedGrid .= '<tr class="schedule-row">';

			// iterates through the days
			for($curr_day = 0; $curr_day < 7; $curr_day++):

				// properly format time based on standard time practices
				if($curr_day == 0):
					
					$unit = 'am';
					$hour = 8 + $curr_hour;

					if($hour >= 12):

						if($hour > 12):
							$hour -= 12;
						endif;

					$unit = 'pm';

					endif;

					$schedGrid .= '<td class="shift-time"> <p>'.$hour.':00 '.$unit.' </p></td>';

				else:

					$tutorList = $currentSchedule[$iterator]->tutors;
					echo "HERE".$tutorList;
					$schedGrid .= '<td class="open-shift" id = "'.$curr_day.'-'.$curr_hour.'"> '.implode("<br>", $tutorList).'</td>';
					$iterator++;
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
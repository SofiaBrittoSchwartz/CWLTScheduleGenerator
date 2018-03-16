/**
 * An object representation of a 1 hour shift. If a tutor is working for multiple hours in a row, this will be represented as multiple shifts.
 * @author Sam Berling
 *
 */
public class Shift implements Comparable<Shift>{
	protected Day day; //day of the shift
	protected int time;//start time of the shift. 
	
	public Shift(Day day, int time){
		this.day = day;
		this.time = time;
	}
	
	/**
	 * This method determines whether or not this shift is adjacent to (i.e. either immediately precedes or succeeds) the input shift 
	 * @param shift the shift we are comparing to
	 * @return
	 */
	public boolean adjacentTo(Shift shift){
		if(day.compareTo(shift.day)!=0){ //if they are on different days
			return false;
		}
		return (time-shift.time == 1 || time-shift.time == -1);
	}
	
	public boolean firstShiftOfDay(){
		return (time==day.getFirstAppointment());
	}
	
	public boolean lastShiftOfDay(){
		return (time==day.getLastAppointment());
	}
	
	public String toString(){
		return "("+day+" at "+time+")";
	}

	@Override
	public int compareTo(Shift shift) {
		int sameDay = day.compareTo(shift.day);
		if(sameDay>0){
			return 1;
		}
		else if(sameDay<0){
			return -1;
		}
		else{ //sameDay == 0
			if(time > shift.time){
				return 2;
			}
			else if(time < shift.time){
				return -2;
			}
			else{ //time==shift.time
				return 0;
			}
		}
	}
}

/**
 * An object representation of a 1 hour shift. If a tutor is working for multiple hours in a row, this will be represented as multiple shifts.
 * @author Sam Berling
 *
 */
public class Shift {
	protected Day day; //day of the shift
	protected int time;//start time of the shift. 
	
	public Shift(Day day, int time){
		this.day = day;
		this.time = time;
	}
	
	public String toString(){
		return day+" at "+time;
	}
}

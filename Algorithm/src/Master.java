import java.util.ArrayList;
import java.util.HashMap;


public class Master {
	private HashMap<Shift, ArrayList<Tutor>> availabilityMap; //Maps a shift to a list of tutors available during that time
	private HashMap<Tutor, ArrayList<Shift>> assignmentMap; //Maps a tutor to a list of Shifts assigned to that tutor.
	private ArrayList<Tutor> tutors; //Master list of all tutors
	private ArrayList<Shift> shifts; //Master list of all shifts
	
	public Master(){
		shifts = new ArrayList<Shift>();
		tutors = new ArrayList<Tutor>();
		availabilityMap = new HashMap<Shift, ArrayList<Tutor>>();
		assignmentMap = new HashMap<Tutor, ArrayList<Shift>>();
		generateShifts();
	}

	private void generateShifts() {
		for(Day day : Day.values()){ //for each day in the week
			for(int i = day.getFirstAppointment(); i < day.getLastAppointment(); i++){ //for each shift in the day
				Shift shift = new Shift(day, i); //create the shift
				shifts.add(shift); //add it to the list of shifts
			}
		}
	}
	
	private void blackOutShift(Day day, int time){
		Shift toRemove = null;
		for(Shift shift : shifts){
			if(shift.day == day && shift.time == time){
				toRemove = shift;
				break;
			}
			else if(shift.day.compareTo(day)>0){ //if we get past the day of the shift we're trying to remove, we know it doesn't exist and we can break
				break;
			}
		}
		shifts.remove(toRemove);
	}
	
	public static void main(String[] args){
		Master m = new Master();
		for(Shift shift : m.shifts){
			System.out.println(shift);
		}
		m.blackOutShift(Day.Monday, 12);
	}
}

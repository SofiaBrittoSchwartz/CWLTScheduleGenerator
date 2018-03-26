import java.util.ArrayList;

public class Tutor implements Comparable<Tutor>{
	protected String studentName;
	protected String studentID; //unique identifying name for this tutor. Will likely be their email address prefix
	protected ArrayList<Shift> availableShifts;
	protected ArrayList<Shift> assignedShifts;
	protected int numShiftsNeeded; //the number of shifts this tutor is allowed to work, decrements as they are assigned shifts
	//2D array for final schedule
	private double availabilityRatio;
	
	public Tutor(String id){
		this.studentID = id;
		numShiftsNeeded = 6;
		assignedShifts = new ArrayList<Shift>();
		availableShifts = new ArrayList<Shift>();
		availabilityRatio = availableShifts.size() / numShiftsNeeded; //should start the ratio off at 0
	}
	
	public String toString(){
		return studentID;
	}
	
	public double calculateAvailabilityRatio(){
		if(numShiftsNeeded > 0){
			availabilityRatio = (Math.round(100.0*(availableShifts.size() / ((double) numShiftsNeeded))))/100.0;
		}
		else{
			availabilityRatio = 0; //if numShiftsNeeded = 0, then availabilityRatio will be Double.MAX_VALUE from the division, so we set it to 0 because this tutor is no longer available
		}
		return availabilityRatio;
	}

	@Override
	public int compareTo(Tutor t) {
		return (int)(calculateAvailabilityRatio()*10 - t.calculateAvailabilityRatio()*10); //multiply by 10 as to not lose precision
	}
}

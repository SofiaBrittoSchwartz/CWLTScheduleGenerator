import java.util.ArrayList;

public class Tutor {
	protected String studentName;
	protected String studentID; //unique identifying name for this tutor. Will likely be their email address prefix
	protected ArrayList<Shift> availableShifts;
	protected ArrayList<Shift> assignedShifts;
	protected int numShifts; //the number of shifts this tutor is allowed to work, decrements as they are assigned shifts
	
	public Tutor(String id){
		this.studentID = id;
		numShifts = 6;
		assignedShifts = new ArrayList<Shift>();
		availableShifts = new ArrayList<Shift>();
	}
	public String toString(){
		return studentID;
	}
}

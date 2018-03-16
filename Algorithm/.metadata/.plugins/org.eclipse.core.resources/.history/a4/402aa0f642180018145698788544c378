import java.util.ArrayList;

public class Tutor {
//	private String firstName;
//	private String lastName;
	protected String id; //unique identifying name for this tutor. Will likely be their email address prefix
	protected ArrayList<Shift> availableShifts;
	protected ArrayList<Shift> assignedShifts;
	protected int numShifts; //the number of shifts this tutor is allowed to work
	
	public Tutor(String id){
		this.id = id;
		numShifts = 6;
		assignedShifts = new ArrayList<Shift>();
		availableShifts = new ArrayList<Shift>();
	}
	public String toString(){
		return id;
	}
}

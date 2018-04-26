import java.util.ArrayList;
import java.util.Collections;
import java.util.HashSet;

import com.google.gson.annotations.Expose;

public class Tutor implements Comparable<Tutor>{
	protected String studentName;
	protected ArrayList<Shift> availableShifts;
	protected int numShiftsNeeded; //the number of shifts this tutor is allowed to work, decrements as they are assigned shifts
	private double availabilityRatio;
	protected double tempScore; //used for adjusting scores for specific shifts
	protected boolean isVeteran;
	protected ArrayList<Shift> assignedShifts;
	protected HashSet<String> subjects;

	@Expose
	protected String studentID; //unique identifying name for this tutor. Will likely be their email address prefix

	public Tutor(String id){
		isVeteran = false;
		this.studentID = id;
		numShiftsNeeded = 6;
		subjects = new HashSet<String>();
		assignedShifts = new ArrayList<Shift>();
		availableShifts = new ArrayList<Shift>();
		availabilityRatio = availableShifts.size() / numShiftsNeeded; //should start the ratio off at 0
		tempScore = 0;
	}
	
	public Tutor(TutorJSON tj){
		isVeteran = tj.veteran;
		studentID = tj.studentID;
		numShiftsNeeded = tj.numHours;
		subjects = new HashSet<String>();
		subjects.addAll(tj.position);
		studentName = tj.name;
		//TO DO: get tj.scheduleInfo, and handle availableShifts, preferred Shifts
		// availability Ratio
		//temp score
		//assignedShift
	}

	public String toString(){
		//		return studentID + subjects;
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

	public double getScore(){
		if(tempScore != 0){
			return tempScore;
		}
		else{
			return calculateAvailabilityRatio();
		}
	}

	@Override
	public int compareTo(Tutor t) {
		return (int)(getScore()*10 - t.getScore()*10); //multiply by 10 as to not lose precision
	}

	protected void sortAssignedShifts(){ //bubble sort because why not
		for(int j = assignedShifts.size()-1; j > 0; j--){//decrementing last index
			for(int i = 0; i < j; i++){
				Shift s = assignedShifts.get(i);
				Shift next = assignedShifts.get(i+1);
				if(s.compareTime(next)>0){
					Collections.swap(assignedShifts, i, i+1);
				}
			}
		}
	}

	protected boolean worksDaytimeShift(){//returns whether this tutor works at least 1 shift during the day
		for(Shift s : assignedShifts){
			if(s.time<17) return true;
		}
		return false;
	}

	protected boolean isWritingAdvisor(){
		return subjects.contains("Writing Advisor");
	}

	public void setNumShiftsNeeded(int num){
		numShiftsNeeded = num;
	}
}

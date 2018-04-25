import java.util.ArrayList;

public class TutorJSON {
	protected String name;
	protected String studentID;
	protected ArrayList<String> position;
	protected int numHours;
	protected boolean veteran;
	protected ArrayList<ArrayList<Integer>> scheduleInfo;
	
	public String toString(){
		return "("+name +", "+studentID+", "+position+", "+numHours+", "+scheduleInfo+", "+veteran+")";
	}
}
import java.util.ArrayList;

public class TutorListJSON {
	protected ArrayList<TutorJSON> tutors;
	

	public String toString(){
		String s = "";
		for(TutorJSON t : tutors){
			s+=t+"\n";
		}
		return s;
	}
}

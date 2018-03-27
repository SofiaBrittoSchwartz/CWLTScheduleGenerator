import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.PriorityQueue;
import java.util.Scanner;



public class Master {
	protected HashMap<Shift, ArrayList<Tutor>> availabilityMap; //Maps a shift to a list of tutors available during that time. Preliminary data structure that holds this information before we can score the tutors and shifts and put the 
	protected ArrayList<Tutor> tutors; //Master list of all tutors
	protected ArrayList<Shift> shifts; //unordered master list of all shifts
	protected PriorityQueue<Shift> shiftQ; //master list of all shifts ordered by their score

	protected static boolean DEBUG = true; //variable that turns on(true)/off(false) print statements. I left this as *not* final so that I can selectively print some things and not others when debugging
	protected static final int MIN_LENGTH = 2; //minimum number of consecutive hours a tutor is required to work
	protected static final int MAX_LENGTH = 3; //maximum number of consecutive hours a tutor is allowed to work

	private int minCount = 0; //used to count how many shifts have min number of tutors
	private int maxCount = 0; //used to count how many shifts have max number of Tutors 

	public Master(){
		shifts = new ArrayList<Shift>();
		tutors = new ArrayList<Tutor>();
		shiftQ = new PriorityQueue<Shift>();
		availabilityMap = new HashMap<Shift, ArrayList<Tutor>>();
		createShiftList();
	}

	public void readFile() throws FileNotFoundException{
		String fileName = "Fall2017Availability.csv";
		Scanner sc = new Scanner(new File(fileName));
		String firstLine = sc.nextLine();
		Scanner fl = new Scanner(firstLine); //this first line of the csv tells us which shifts are changing in the format of D-T (e.g. 3-14 represents Wednesday at 2pm)
		fl.useDelimiter(",+");
		fl.next(); //don't care about id tag
		int shiftIndex = 0; //this serves as an index when trekking through our list of Shifts
		ArrayList<Shift> shiftsToModify = new ArrayList<Shift>(); //this is a list of the shifts we'll be modifying based on the input file. It will contain, in order, the shifts the CSV represents


		processAllShifts(fl, shiftIndex, shiftsToModify);
		processAllTutors(sc, shiftsToModify);

		for(Shift s : shifts){
			s.availableTutors.addAll(availabilityMap.get(s));
			s.calculateScore();
			println(s+": "+s.calculateScore());
		}
		shiftQ.addAll(shifts);
	}

	public void generateSchedule(){ //this is all messed up. don't look at it yet
		while(shiftsNeedTutors()){//first we make sure every shift that can have the Minimum number of tutors, has the mininimum number of tutors
			Shift shift = shiftQ.poll();
			if(shift.day==Day.Sunday && shift.time==13){
				print();
			}
			if(shift.calculateScore() > 0 && shift.hasAvailableTutors() && !shift.hasMin()){
				while(!shift.hasMin()){
					Tutor tutor = shift.availableTutors.poll();
					if(tutor.studentID.equalsIgnoreCase("bwitter")){
						print();
					}
					assignShift(shift, tutor);
					assignConsecutiveShift(shift, tutor);
				}
				shiftQ.add(shift);
			}
		}
		while(numTutorHours() > 0){ //now we fill the shifts until the tutors don't have any more hours to work
			Shift shift = shiftQ.poll();
			if(shift.calculateScore() > 0 && shift.hasAvailableTutors()){
				Tutor tutor = shift.availableTutors.poll();
				if(tutor.studentID.equalsIgnoreCase("bwitter")){
					print();
				}
				assignShift(shift, tutor);
				assignConsecutiveShift(shift, tutor);
				shiftQ.add(shift);
			}
		}
	}

	private boolean consecutiveCheck(){ //after the schedule has been generated, this method checks if each tutor is working consecutive shifts (rather than single shifts), returning true if every tutor has no single shifts
		for(Tutor t : tutors){
			boolean[] checked = new boolean[t.assignedShifts.size()];
			boolean failed = false;//if the tutor has multiple single shifts, we don't want to print them twice
			for(int i = 0; i < t.assignedShifts.size(); i++){ 
				Shift s = t.assignedShifts.get(i);
				if(!checked[i]){
					Shift next = nextShift(s);
					Shift prev = previousShift(s);
					if(next!=null){
						if(t.assignedShifts.contains(next)){
							checked[i] = true;
							checked[t.assignedShifts.indexOf(next)] = true;
						}
					}
					if(prev!=null){
						if(t.assignedShifts.contains(prev)){
							checked[i] = true;
							checked[t.assignedShifts.indexOf(prev)] = true;
						}
					}
				}
			}
			for(boolean c : checked){
				if(!c && !failed){
					failed = true; //dont want to print multiple times for one person
					println(t +": "+t.assignedShifts);
					//					return false; //comment out this line if you want this method to print all the tutors who work single hours
				}
			}
		}
		//		println(true);
		return true;
	}

	private boolean worksConsecutiveShift(Shift shift, Tutor tutor){ //determines whether or not a Tutor is working a shift that is adjacent to this one
		Shift next = nextShift(shift);
		Shift prev = previousShift(shift);
		if(next != null){
			if(tutor.assignedShifts.contains(next)){
				return true;
			}
		}
		if(prev != null){
			if(tutor.assignedShifts.contains(prev)){
				return true;
			}
		}
		return false;
	}

	private int numShiftsAdjacent(Tutor tutor, Shift shift){//returns the length of the run that would be created if this shift were assigned to this tutor (-1)
		Shift next = nextShift(shift);
		Shift prev = previousShift(shift);
		int numNexts = 0;
		while(next != null && tutor.assignedShifts.contains(next)){
			numNexts++;
			next = nextShift(next);
		}
		int numPrevs = 0;
		while(prev != null && tutor.assignedShifts.contains(prev)){
			numPrevs++;
			prev = previousShift(prev);
		}
		//		if(numNexts > numPrevs) {
		//			return numNexts;
		//		}
		//		else{
		//			return numPrevs;
		//		}
		return numPrevs+numNexts;
	}

	private int numConsecutiveShifts(Tutor t){
		int[] adjacents = new int[t.assignedShifts.size()];
		int max = 0;
		for(int i = 0; i < adjacents.length; i++){
			adjacents[i] = numShiftsAdjacent(t, t.assignedShifts.get(i));
			if(adjacents[i] > max){
				max = adjacents[i];
			}
		}
		return max+1;
	}

	private Shift previousShift(Shift shift){//returns the shift immediately before this one or null if it's the first shift of the day or after a break
		if(!shift.firstShiftOfDay()){
			Shift prev = shifts.get(shifts.indexOf(shift)-1);
			if(prev.adjacentTo(shift)){
				return prev;
			}
		}
		return null;
	}

	private Shift nextShift(Shift shift){//returns the shift immediately after this one or null if it's the last shift of the day or before a break
		if(!shift.lastShiftOfDay()){
			Shift next = shifts.get(shifts.indexOf(shift)+1);
			if(next.adjacentTo(shift)){
				return next;
			}
		}
		return null;
	}

	private boolean assignShift(Shift shift, Tutor tutor) { //assigns a tutor to a shift, returning true on success or false if it cannot assign this tutor to this shift
		if(numShiftsAdjacent(tutor, shift) < MAX_LENGTH && tutor.numShiftsNeeded>0){ //we don't want to add to this shift unless it won't create a run of 3 or more
			shift.assignedTutors.add(tutor);
			tutor.numShiftsNeeded--;
			tutor.assignedShifts.add(shift);
			purge(tutor);
			refreshScores(shift, tutor);
			return true;
		}
		return false;
	}

	private boolean assignConsecutiveShift(Shift shift, Tutor tutor){
		if(!worksConsecutiveShift(shift, tutor)){
			boolean consecutiveAssigned = false;
			Shift previous = previousShift(shift);
			Shift next = nextShift(shift);
			if(previous != null){
				if(previous.availableTutors.contains(tutor) && !previous.assignedTutors.contains(tutor)){//if the tutor can work the previous shift but hasn't been assigned to it yet, do
					if(assignShift(previous, tutor)) consecutiveAssigned = true;
					previous.availableTutors.remove(tutor); //need to remove the tutor because it won't get removed otherwise
				}
			}
			if(next !=null && !consecutiveAssigned){//same deal, but we don't want to assign another shift if we already did above
				if(next.availableTutors.contains(tutor) && !next.assignedTutors.contains(tutor)){
					if(assignShift(next, tutor)) consecutiveAssigned = true;
					next.availableTutors.remove(tutor); //need to remove the tutor because it won't get removed otherwise
				}

			}
			int run = numConsecutiveShifts(tutor);
			if(!consecutiveAssigned && numConsecutiveShifts(tutor)>MIN_LENGTH && tutor.numShiftsNeeded==0){//if we failed to assign a consecutive shift on the last shift and we have an extra long run, then we can move things around
				//find the beginning or end of the run and unassign it,
				unassignTutor(findEndOfRun(tutor, run), tutor);
				//then unassign this most recent shift too
				unassignTutor(shift, tutor);
			}
			else if(!consecutiveAssigned && tutor.numShiftsNeeded>0){//otherwise, if we still have time to spare, try getting rid of this one anyway.
				unassignTutor(shift, tutor);
			}
			return consecutiveAssigned;
		}
		return true;
	}

	private Shift findEndOfRun(Tutor tutor, int run) {//this method returns the least constrained Shift in a run of shifts of a given length. e.g. if sberling had a 3-hour run of shifts, this method would look at the first and last hour of that run and return the one with a higher score
		Shift[] ends = new Shift[2];
		for(Shift s : tutor.assignedShifts){
			if(numShiftsAdjacent(tutor,s) == run-1){ //if this is true, then s is part of the run
				if(!tutor.assignedShifts.contains(previousShift(s))){//if it doesn't contain the previous shift, then this is the beginning of the run
					ends[0]=s;
				}
				if(!tutor.assignedShifts.contains(nextShift(s))){
					ends[1]=s;
				}
			}
		}
		if(ends[0].calculateScore() > ends[1].calculateScore()){
			return ends[0];
		}
		return ends[1];
	}

	private void unassignTutor(Shift shift, Tutor tutor) { 
		if(tutor.studentID.equalsIgnoreCase("zbranch")){
			print();
		}
		shift.assignedTutors.remove(tutor);
		tutor.assignedShifts.remove(shift);
		if(!shift.availableTutors.contains(tutor)) shift.availableTutors.add(tutor);
		unpurge(tutor);
		tutor.numShiftsNeeded++;
		refreshScores(shift, tutor);
	}

	private void unpurge(Tutor tutor) {
		if(tutor.numShiftsNeeded<=0){//if the tutor was booked (i.e. previously purged)
			for(Shift s : tutor.availableShifts){ //unpurge
				if(!s.availableTutors.contains(tutor) && !tutor.assignedShifts.contains(s)) s.availableTutors.add(tutor);
			}
		}
	}

	private void refreshScores(Shift shift, Tutor tutor) {//refreshes the given tutor and shift scores and all shifts that have that tutor in their availability map, reheapifying where necessary 
		tutor.calculateAvailabilityRatio();
		for(Shift s : tutor.availableShifts){//refresh all shifts that had this tutor in its availableTutor queue
			if(s.availableTutors.contains(tutor)){
				s.reheapify();
				s.calculateScore();
			}
		}
		shift.calculateScore();
		shift.reheapify();
	}

	private void purge(Tutor tutor) { //removes all tutors that no longer have hours to work     
		if(tutor.numShiftsNeeded <= 0){
			for(Shift s : tutor.availableShifts){
				s.availableTutors.remove(tutor);
			}
		}
	}


	//possible make this local variable
	private int numTutorHours(){//calculates the total number of hours left to assign. i.e. if every tutor had 4 hours left and there were 40 tutors, this method would return 160
		int total = 0;
		for(Tutor t : tutors){
			total += t.numShiftsNeeded;
		}
		return total;
	}

	private boolean shiftsNeedTutors(){//runs through all the shifts and figures out if there is a shift that still needs tutors
		for(Shift shift : shifts){
			if(!shift.hasMin() && shift.availableTutors.size() >= Shift.MIN_TUTORS){
				return true;
			}
		}
		return false;
	}

	private void createShiftList() { 
		for(Day day : Day.values()){ //for each day in the week
			for(int i = day.getFirstAppointment(); i <= day.getLastAppointment() && i>=0; i++){ //for each shift in the day
				Shift shift = new Shift(day, i); //create the shift
				shifts.add(shift); //add it to the list of shifts
				availabilityMap.put(shift, new ArrayList<Tutor>());
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

	private void processAllShifts(Scanner fl, int shiftIndex, ArrayList<Shift> shiftsToModify) {
		while(fl.hasNext()){
			String shift = fl.next();
			println("LOOKING AT " + shift);
			println("----------");
			String[] dayTime = shift.split("-");
			int day = Integer.parseInt(dayTime[0]); //integer representing the day of the week with 0=sunday and so on
			int time = Integer.parseInt(dayTime[1]); //the time in 24h format
			println("this shift represents " + Day.values()[day] + " at " +time);
			shiftIndex = processShift(shiftIndex, shiftsToModify, day, time);
		}
		println("Final list of shifts!");
		//		for(Shift s : shiftsToModify){
		//			println(s);
		//		}

		fl.close();
	}

	private int processShift(int shiftIndex, ArrayList<Shift> shiftsToModify, int day, int time) {
		/*we're advancing shift index until the shift represented by that index matches the shift read in from the input
		 * the reason we do this is just in case the 'shifts' list of Shifts is a superset of the list of shifts in the csv*/
		println("the masterlist of shifts has " + shifts.get(shiftIndex) + " at the current index");
		while(shifts.get(shiftIndex).day.compareTo(Day.values()[day]) < 0){ //comparing 'day' to the day of the "current shift" represented by 'shiftIndex'
			println("advancing to get to the correct day...");
			shiftIndex++; 
		}
		if(shifts.get(shiftIndex).day.compareTo(Day.values()[day]) == 0){ //the "current shift" in our list of shifts and 'day' now match
			println("found the correct day: " + shifts.get(shiftIndex));
			while(shifts.get(shiftIndex).time < time){ //comparing 'time' to the time of the "current shift" represented by 'shiftIndex'
				println("advancing to get to the correct time...");
				shiftIndex++;
			}
			if(shifts.get(shiftIndex).time == time){
				println("found the correct time: " + shifts.get(shiftIndex) + "! adding this shift to the list of shifts to modify.");
				shiftsToModify.add(shifts.get(shiftIndex)); //we've found the shift that our csv is looking for!
			}
		}
		if(shifts.get(shiftIndex).day.compareTo(Day.values()[day]) > 0 || shifts.get(shiftIndex).time > time){
			println("UH OH SOMETHING WENT WRONG. The Shifts from input file got mismatched from the masterlist of shifts");
		}
		println("");
		return shiftIndex;
	}

	private void processAllTutors(Scanner sc, ArrayList<Shift> shiftsToModify) {
		while(sc.hasNextLine()){
			String line = sc.nextLine();
			String studentID;
			if(line.isEmpty()){
				continue;
			}
			String[] tokens = line.split(",+");
			studentID = tokens[0];
			if(tutorContains(studentID)){ //if we find a tutor already in the system, then we should skip them
				println(studentID + " already exists. there must be a problem. skipping this tutor for now");
				continue;
			}

			processTutor(shiftsToModify, studentID, tokens);
		}
		sc.close();
		for(Tutor t : tutors){ //calculate the availability ratios for tutors now
			t.calculateAvailabilityRatio();
		}
	}

	private void processTutor(ArrayList<Shift> shiftsToModify, String studentID, String[] tokens) {
		Tutor tutor = new Tutor(studentID);
		int consecutive = 0; // the running total of consecutive shifts the tutor is available for 
		tutors.add(tutor);


		println("--------------------------");
		println("Processing " + tutor + ":\n--------------------------");


		for(int i = 1; i < tokens.length; i++){
			int available = Integer.parseInt(tokens[i]); //1 if the student is available at this time, and a 0 if not
			int j = i-1; //shiftIndex

			Shift shift = shiftsToModify.get(j);
			Shift mostRecent = tutor.availableShifts.isEmpty() ? null : tutor.availableShifts.get(tutor.availableShifts.size()-1); //the most recently assigned shift, shifts are added to 'shiftsToModify' chronologically

			println(shift + " consecutive: " + consecutive);
			println("the most recent available shift is " + mostRecent);
			print("Evaluating...");

			switch(available){
			case 0: //tutor is unavailable for this shift
				println(" x");
				if(consecutive > 0 && consecutive < MIN_LENGTH){ //if the tutor hasn't reached the minimum number of hours, but more than 0 (i.e. not a run of unavailability) then remove the most recent shift because that means it's isolated
					println(tutor + " is not available for " + MIN_LENGTH + " consecutive hours on " + mostRecent + ". So we are removing this shift from their availability.");
					remove(tutor, mostRecent);
				}
				consecutive = 0; //reset the run
				break;
			case 1:
				println(" Available!");
				consecutive = (mostRecent!=null && mostRecent.adjacentTo(shift)) ? consecutive+1 : 1; //increment the run or start over at 1 if it's a new day
				if(!shift.lastShiftOfDay() || consecutive >= MIN_LENGTH){ //if it's the lastShift, then we need to be on a run of consecutive shifts to add this one
					add(tutor, shift);
				}
				break;
			default:
				println("AVAILABILITY NOT 1 OR 0, SOMETHING IS WRONG");
				break;
			}
			println();
		}
		println(tutor + " is available for the following shifts: ");
		for(Shift s : tutor.availableShifts){
			println(s);
		}
		println("");
	}

	private void add(Tutor tutor, Shift shift) {
		tutor.availableShifts.add(shift); //add this shift to the tutor's list of available shifts
		availabilityMap.get(shift).add(tutor); //add this tutor to the map of available tutors
	}

	private void remove(Tutor tutor, Shift shift) { //removes the associated availability between tutor and shift
		tutor.availableShifts.remove(shift);
		availabilityMap.get(shift).remove(tutor);
	}

	private void checkForSingleShift(){//checks for any single shifts in a tutor's availability
		for(Tutor tutor : tutors){
			for(int i = 1; i < tutor.availableShifts.size()-1; i++){
				Shift prev 	  = tutor.availableShifts.get(i-1);
				Shift current = tutor.availableShifts.get(i);
				Shift next    = tutor.availableShifts.get(i+1);
				if(!current.adjacentTo(prev) && !current.adjacentTo(next)){
					println(tutor + " has a single shift at " + current);
					//					remove(tutor, current);
				}
			}
		}
	}

	private boolean tutorContains(String studentID) { //determines whether or not the tutors list already contains a Tutor with the input studentID
		for(Tutor t : tutors){
			if(t.studentID.equalsIgnoreCase(studentID)){
				return true;
			}
		}
		return false;
	}

	public static void println(){
		if(DEBUG) System.out.println();
	}

	public static void println(Object x){
		if(DEBUG){
			System.out.println(x);;
		}
	}

	public static void print(Object x){
		if(DEBUG){
			System.out.print(x);;
		}
	}

	public static void print(){
		if(DEBUG){
			System.out.print("");
		}
	}

	public void printSchedule(){
		int[][] sched = new int[7][24];
		for(Shift shift : shifts){
			for(int i = 0; i < Day.values().length; i++){
				if(shift.day == Day.values()[i]){
					sched[i][shift.time] = shift.assignedTutors.size();
				}
			}
		}
		println("    9am   10am  11am  12pm  1pm   2pm   3pm   4pm   5pm   6pm   7pm   8pm");
		for(int i = 0; i < sched.length-1; i++){//-1 to exclude saturday
			print(Day.values()[i].toString().substring(0, 1)+" : ");
			for(int j = 9; j <= 20; j++){
				if((i==0 && (j < 12 || j > 17)) || (i==5 && j > 15)){
					print("      ");
				}
				else{
					print(sched[i][j]+"     ");
				}
				if(sched[i][j] == Shift.MIN_TUTORS){
					minCount++;
				}
				else if(sched[i][j] >= Shift.MAX_TUTORS){
					maxCount++;
				}
			}
			println();
		}
	}

	public static void main(String[] args) throws FileNotFoundException{
		Master m = new Master();
		m.readFile();
		println(m.shifts.size());
		println("---------------------------------------------------------------------------------");
		long start = System.currentTimeMillis();
		m.generateSchedule();
		long finish = System.currentTimeMillis();
		for(Shift s : m.shifts){
			println(s+": "+s.assignedTutors);
		}
		println();
		for(Tutor t : m.tutors){
			t.sortAssignedShifts();
			println(t+": "+t.assignedShifts);
		}
		println();
		m.printSchedule();
		println("Number of shifts with max # tutors: "+m.maxCount);
		println("Number of shifts with min # tutors: "+m.minCount);

		m.consecutiveCheck();

		println("\n" + (finish-start) + "ms");

		for(int i = 2; i < 10; i++){ //prints all tutors and their longest run
			for(Tutor t : m.tutors){
				if(m.numConsecutiveShifts(t) == i){
					println(t+"("+i+"): "+t.assignedShifts);
				}
			}
		}

	}
}

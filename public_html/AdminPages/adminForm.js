var schedule;
var dataName;
var dataCollection;
var newTutor;

var debug = true;

function setSchedule(sched)
{
	schedule = Array.from(sched);
	saveToHolder(schedule);
}

// for Schedule
function saveTimes(inputType, day, time)
{	
	var closed = -1;
	var open = 0;
	var preferred = 1;
	var busy = 2;
	
	// keep track of hours available
	var timeBlock = document.getElementById(day+"-"+time);
	
	if(timeBlock.className === "open-shift")
	{
		schedule[day-1][time] = inputType;

		switch(inputType)
		{
			case closed:
				timeBlock.className = "closed-shift";
				break;
			case busy:
				timeBlock.className = "busy-shift";
				break;
			case preferred:
				timeBlock.className = "preferred-shift";
				break;
		}
	}
	else
	{
		schedule[day-1][time] = open;
		timeBlock.className = "open-shift";
	}

	saveToHolder(schedule);

}

function loadFile(name)
{
	dataName = name;
	dataCollection = new Map();

	var rawFile = new XMLHttpRequest();
    rawFile.open("GET", name + ".json", false);
    var text;

    rawFile.onreadystatechange = function()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                text = rawFile.responseText;
                dataCollection = objToStrMap(JSON.parse(text));
            }
        }
    }

    rawFile.send(null);

    saveToHolder(dataCollection);
}

// from JSON to javascript Map object
function objToStrMap(obj) 
{
    var strMap = new Map()
    
    // where k is a given key within obj
    for (let k of Object.keys(obj)) 
    {	
    	// if k's value is an Object recurse
    	if(obj[k] instanceof Object)
    	{
    		obj[k] = objToStrMap(obj[k]);
    	}

        strMap.set(k, obj[k]);
    }

    return strMap;
}

function saveToHolder(data)
{
	var holder = document.getElementById("holder");

	if(data instanceof Map)
	{	
		holder.value = JSON.stringify(toObj(data), null, '\t');
	}
	else
	{
		holder.value = JSON.stringify(data, null, '\t');	
	}
}

function toObj(currMap)
{
	var mapArray = Array.from(currMap);
 	
 	var object = new Object();

 	for(var i = 0; i < mapArray.length; i++)
 	{

 		if(mapArray[i][1] instanceof Map) mapArray[i][1] = toObj(mapArray[i][1]);

 		Object.assign(object, {[mapArray[i][0]]: mapArray[i][1]});
 	}

	return object;
}

function saveData(studentID, attr)
{
	print("SAVEDATA");
	var value;
	var elem;
	
	if(studentID == null)
	{
		elem = document.getElementById("none-"+attr);
	}
	else
	{
		elem = document.getElementById(studentID+"-"+attr);
	}
	
	value = elem.value;

	if(value != "")
	{

		// if attr inputted is the studentID, update the necessary fields
		if(attr == "studentID")
		{
			elem.id = value +"-"+ attr;	
			elem.addEventListener("focusout", function(){ saveData(null, elem.id) }, true);
		}

		// if this tutor already exists, change the specified value
		if(dataCollection.get(studentID) != null)
		{
			dataCollection.get(studentID).set(attr, value);	
		}
		// otherwise, keep track of a new tutor, but only add to collection
		// once all attributes have been filled in
		else
		{
			newTutor.set(attr, value);
			
			if (newTutor.size == 4)
			{
				dataCollection.set(newTutor.get("studentID"), newTutor);
				newTutor = null;
			}
		}
		
	}	

	saveToHolder(dataCollection);
}

function addTutor(frameID)
{
	var columns = document.getElementsByClassName('column');

	var input = document.createElement('input');

	if(newTutor == null)
	{
		newTutor = new Map();
		increaseHeight(frameID);
		document.getElementById("errorMessage").style.visibility = 'hidden';
	}	
	else
	{
		var pNode = document.getElementById("errorMessage");
		document.getElementById("errorMessage").style.visibility = 'visible';
		return;
	}

	// modify and append new name input
	input.id = "none-name";
	input.type = "text";
	input.value = "";

	columns[0].append(input);
	input.addEventListener("focusout", function(){ saveData(null, columns[0].id)}, true);

	// modify and append new position input
	var input1 = input.cloneNode(true);
	input1.id = "none-position";
	input1.value = [];
	input1.style.width = "220px";
	input1.addEventListener("focusout", function(){saveData(null, columns[1].id)}, true);
	columns[1].append(input1);

	// append new studentID input
	var input2 = input.cloneNode(true);
	var textNode = document.createTextNode(" @pugetsound.edu");
	input2.id = "none-studentID";
	input2.style.width = "125px";
	input2.addEventListener("focusout", function(){saveData(null, columns[2].id)}, true);
	columns[2].append(textNode);
	columns[2].insertBefore(input2, textNode);

	// append new numHours input
	var input3 = input.cloneNode(true);
	input3.id = "none-numHours";
	input3.style.width = "100px";
	input3.style.textAlign = "center";
	input3.addEventListener("focusout", function(){saveData(null, columns[3].id)}, true);
	columns[3].append(input3);
}

function setFrameHeight(frameID, height)
{
	window.parent.document.getElementById(frameID).style.height = height+"px";
}

// gets the height, remove the 'px', increase the val, then replace the 'px'
function increaseHeight(frameID)
{
	var iframe = window.parent.document.getElementById(frameID);
	var heightVal = parseInt(iframe.style.height.replace("px",""));
	heightVal += 30;
	iframe.style.height = heightVal + "px";
}

function print(str)
{
	if(debug) console.log(str);
}
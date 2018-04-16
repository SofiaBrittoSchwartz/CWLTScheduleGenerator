var schedule;
var dataName;
var dataCollection;

var debug = true;

function setSchedule(sched)
{
	schedule = Array.from(sched);
	saveToHolder(schedule);
}

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
		holder.value = JSON.stringify(toObj(data));
	}
	else
	{
		holder.value = JSON.stringify(data);	
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

function saveData(inputID)
{
	var value = document.getElementById(inputID).value;
	var holder = inputID.split("-");
	var studentID = holder[0];
	var attr = holder[1];

	if(value != "")
	{
		dataCollection.get(studentID).set(attr, value);
	}	

	console.log(dataCollection);

	saveToHolder(dataCollection);
}

function print(str)
{
	if(debug) console.log(str);
}
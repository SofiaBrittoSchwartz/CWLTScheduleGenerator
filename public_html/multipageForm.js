
	var currentTab = 0; // Current tab is set to be the first tab (0)
	showTab(currentTab); // Display the current tab

	function adjustFrame(currForm, variant)
	{
		var frame = document.getElementById(currForm);
		var tabs = document.getElementsByClassName("tab");

		if(variant == 1)
		{
			frame.style.width = "880px";
			frame.style.height = "720px";	
		}
		else if(variant == -1 && (currentTab == 0 || currentTab == tabs.length - 1))
		{
			frame.style.width = "580px";
			frame.style.height = "300px";	
		}
		
	}

	function showTab(variant) 
	{
	  // This function will display the specified tab of the form...
	  var tabs = document.getElementsByClassName("tab");
	  tabs[variant].style.display = "block";
	  
	  //... and fix the Previous/Next buttons:
	  if (variant == 0) {
	    document.getElementById("prevBtn").style.display = "none";
	  } 
	  else {
	    document.getElementById("prevBtn").style.display = "inline";
	    document.getElementById("nextBtn").style = "margin-left: 15px";
	    document.getElementById("prevBtn").style  = "margin-right: 15px";
	  }

	  // second to last button click will title name of nextBtn from Next to Submit
	  if (variant == (tabs.length - 2)) 
	  {
	    document.getElementById("nextBtn").innerHTML = "Submit";
	  } 
	  else if (variant == (tabs.length - 1))
	  {
	  	document.getElementById("prevBtn").style.display = "none";
	    document.getElementById("nextBtn").style.display = "none";
	  }
	  else
	  {
	    document.getElementById("nextBtn").innerHTML = "Next";
	  }
	  //... and run a function that will display the correct step indicator:
	  fixStepIndicator(variant)
	}

	function nextPrev(currForm, variant) 
	{
	  // This function will figure out which tab to display
	  var tabs = document.getElementsByClassName("tab");
	  
	  // Exit the function if any field in the current tab is invalid:
	  if (variant == 1 && !validateForm()) return false;
	  
	  // Hide the current tab:
	  tabs[currentTab].style.display = "none";
	  
	  // Increase or decrease the current tab by 1:
	  currentTab = currentTab + variant;
	  
	  // if you have reached the end of the form...
	  if (currentTab >= tabs.length-1) {

	    adjustFrame(currForm, -1);
	  	showTab(currentTab);

	    // ... the form gets submitted:
	    // document.getElementById("tutorForm").submit();
	    submit();
	    return false;
	  }

	  // Otherwise, display the correct tab:
	  adjustFrame(currForm, variant);
	  showTab(currentTab);
	  // window.scrollTo(155, 155);
	  window.scrollTo(0, 0);
	}

	function validateForm() 
	{
	  // This function deals with validation of the form fields
	  var x, y, i, valid = true;
	  x = document.getElementsByClassName("tab");
	  y = x[currentTab].getElementsByTagName("input");
	  // A loop that checks every input field in the current tab:
	  for (i = 0; i < y.length; i++) {
	    // If a field is empty...
	    if (y[i].value == "") {
	      // add an "invalid" class to the field:
	      y[i].className += " invalid";
	      // and set the current valid status to false
	      valid = false;
	    }
	  }
	  // If the valid status is true, mark the step as finished and valid:
	  if (valid && !document.getElementsByClassName("step")[currentTab].className.includes(" finish"))
	  {
  		
  		document.getElementsByClassName("step")[currentTab].className += " finish";
	  }
	  return valid; // return the valid status
	}

	/* Changes colors of step indicators */
	function fixStepIndicator(n) 
	{
	  // This function removes the "active" class of all steps...
	  var i, x = document.getElementsByClassName("step");

	  for (i = 0; i < x.length; i++) {
	    x[i].className = x[i].className.replace(" active", "");
	  }
	  //... and adds the "active" class on the current step:
	  if(n < x.length)
	  {
	  	if(document.getElementsByClassName("step")[currentTab].className.includes(" finish"))
	  	{
	  		x[n].className = x[n].className.replace(" finish", " active");	
	  	}
	  	else
	  	{
		  	x[n].className += " active";		  		
	  	}
	  
	  }
	  
	}

	function submit()
	{
		
	}
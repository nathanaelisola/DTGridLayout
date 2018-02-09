// take the data from the text area and send it to be modified
function pullForm(){
	// get text from field
	let data = document.getElementById("oldGridBody").value;
	sessionStorage.setItem("unmodified", data);
	
	let updatedData = modifyForm(data);
	presentModification();
	
	sessionStorage.removeItem("unmodified");
	sessionStorage.removeItem("modified");
	
}

// modify form data
function modifyForm(data){
	let text = data;
	let h2Count = text.split("</h2>").length - 1;
	
	if (h2Count == 0){
		// whole text gets formatted as one piece (produces one grid-cols-1 obj)
		text = gridFormatter(text);
	} else {
		
		// loops through text and slices it up at <h2>'s, sending them to gridFormatter individually
		// this is how we handle multiple grid objects
		for (i; i < h2Count; i++){
			let h2Start = text.indexOf("<h2>", offset);
			let h2End = text.indexOf("<h2>", h2Start + 1); //finds the next <h2>
			
			
			if (h2End == -1){
				let subText = text.slice(h2Start);
			} else {
				let subText = text.slice(h2Start, h2End);
			}
			
			let newText = gridFormatter(subText);
			
			text = text.split(subText).join(newText);
			
			offset = h2Start + 4; // so it ignores the previous <h2>
		}
	}
	
	sessionStorage.setItem("modified", text);
}

// presents modified data to user
function presentModification(){
	let data = sessionStorage.getItem("modified");

	// not sure this line is working as intended
	// supposed to let the preview box have DT's css style. 
	// might not have the right file or might need more files
	let css = '<style>@import(https://www.digitaltrends.com/wp-content/themes/digitaltrends-2014/assets/styles/css/dt-single-foot.css?ver=1518041634061)</style>';

	// puts new text in output-grid field
	let x = document.getElementById("output-grid");
	x.innerHTML = data;
	
	// reveals output textarea
	document.getElementById("output-div").classList.remove("hidden");
	
	// reveals preview div
	x = document.getElementById("preview-div");
	x.classList.remove("hidden");
	x.innerHTML = css + data; // gives it some of DT's formatting
	
	// hide input form
	x = document.getElementById("form-div");
	x.classList.add("hidden");

}

function gridFormatter(subText){
	let h3Start = 0;
	let i;
	let arr = [];
	let offset = 0;
	let delim = "|";
	
	let h3Count = subText.split("<h3>").length - 1;
	subText = subText.replace(/\<h3\>/g, "<h3><strong>");
	subText = subText.replace(/\<\/h3\>/g, "</strong></h3>");

	
	for (i = 0; i < h3Count; i++){
		// get the text blurb to modify
		h3Start = subText.indexOf("<h3>", offset);
		h3Next = subText.indexOf("<h3", h3Start + 4);

		// prevents it from looping back on itself?
		if (h3Start == -1){
			break;
		}

		// tests for already gridded fields, does not modify already <div>'d <h3>'s
		let divTest = subText.slice(h3Start - 5, h3Start);

		// puts the separate chunks into an array						
		if (!(divTest === "<div>")){
			
			// determines where to slice the string so that divs go before newlines
			if (h3Next == -1){
			// no more h3's
				
				// look for newline at end of str
				let nlTest = subText.indexOf("\n\n", subText.length - 2);
				if (nlTest == -1){
					// no newlines at end of string
					arr.push(subText.slice(h3Start));					
				} else {
					// newlines at end of string
					arr.push(subText.slice(h3Start, -2));	
				}
			
			} else {
			// more h3's
				
				// look for newline right before next <h3 instance
				let nlTest = subText.indexOf("\n\n", h3Next - 2);
				if (nlTest == -1){
					// no newlines, more h3's
					arr.push(subText.slice(h3Start, h3Next - 1));
				} else {
					// newlines, more h3's
					arr.push(subText.slice(h3Start, h3Next - 2));
				}
			}
			
		}
		offset = h3Start + 4; // so it ignores the previous <h3>

	} 
	// modify the text in the array and replace it in original string
	for (i = 0; i < arr.length; i++){
		let temp = arr[i];


		// add the div boxes 
		temp = '<div>' + temp + '</div>';
		if (i == 0){
			temp = '<div class="item-grid cols-1">' + temp;
		}
		if (i == arr.length - 1){
			temp = temp + '</div>';
		}
		
		// replacing in the original string
		subText = subText.replace(arr[i], temp);
	}	
	
	
	return subText;
}


/*
function getFormData(){
	
	// get the text in the field
	let data = document.getElementById("oldGridBody").value;	
	let css = '<style>@import(https://www.digitaltrends.com/wp-content/themes/digitaltrends-2014/assets/styles/css/dt-single-foot.css?ver=1518041634061)</style>';
	// store it in session storage
	sessionStorage.setItem('data', data);
	data = modifyFormData(data);

	// displaying the new text
	let x = document.getElementById("output-grid");
	x.innerHTML = css + data;
	
	// reveal output, save data
	document.getElementById("output-div").classList.remove("hidden");
	x = document.getElementById("preview-div");
	x.classList.remove("hidden");
	
//	x = document.getElementById("preview-obj");
	x.innerHTML = data;
	
	x = document.getElementById("form-div");
	x.classList.add("hidden");
//	sessionStorage.setItem("data", data);
	
	sessionStorage.removeItem("data");
	
	//clearFormData();
}
function clearFormData(){
	document.getElementById("layoutForm").reset();
}
function clearSaveData(){
	sessionStorage.removeItem('data');
}

// transforms the data
function modifyFormData(data){
	let text = data;
	let closeTag = "</h2>";
	let i = 0;
	let arr = [];
	let offset = 0;
	

	let h2Count = text.split(closeTag).length - 1;

	// if it doesn't find <h2>
	if (h2Count == 0){
		let newText = gridFormatter(text);
		text = text.split(text).join(newText);
	} else {
		
	
	}
		//modify text
		for (i; i < h2Count; i++){
			let h2Start = text.indexOf("<h2>", offset);
			let h2End = text.indexOf("<h2>", h2Start + 1); //finds the start of the NEXT h2
			let subText = "";
			
			if (h2End == -1){
				subText = text.slice(h2Start);
			} else {
				subText = text.slice(h2Start, h2End);
			}
			
			let newText = gridFormatter(subText);
			// console.log(newText);
			
			text = text.split(subText).join(newText);
			
			offset = h2Start + 4; // so it ignores the previous <h2>
		}
	
	return text;
	
}

function hideForm(){
	x = document.getElementById("formColumn");
	
	x.style.display = "none";
}
*/
function getFormData(){
	let data = sessionStorage.getItem('data');		
	let delim = "|";
	
	// get the text in the field
	let oldText = document.getElementById("oldGridBody").value;

	data += delim + oldText;

	// store it in session storage
	sessionStorage.setItem('data', data);
	data = modifyFormData(data);

	// displaying the new text
	let x = document.getElementById("output-grid");
	x.innerHTML = data;
	
	// reveal output, save data
	document.getElementById("output-div").classList.remove("hidden");
	x = document.getElementById("preview-div");
	x.classList.remove("hidden");
	
//	x = document.getElementById("preview-obj");
	x.innerHTML = data;
	
	x = document.getElementById("form-div");
	x.classList.add("hidden");
	sessionStorage.setItem("data", data);

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
	let text = data.slice(5);
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

function gridFormatter(subText){
	let h3Start = 0;
	let h3End = 0;
	let i;
	let arr = [];
	let offset = 0;
	let delim = "|";
	
	let h3Count = subText.split("<h3>").length;
	subText = subText.replace(/\<h3\>/g, "<h3><strong>");
	subText = subText.replace(/\<\/h3\>/g, "</strong></h3>");

	for (i = 0; i < h3Count; i++){
		// get the text blurb to modify
		h3Start = subText.indexOf("<h3>", offset);
		h3End = subText.indexOf("</a></p>", h3Start + 1) + 8;
		// prevents it from looping back on itself?
		if (h3Start == -1){
			break;
		}

		// tests for already gridded fields
		let divTest = subText.slice(h3Start - 5, h3Start);
		if (!divTest === "<div>"){
		
			// puts the separate chunks into an array		
			if (h3End == -1){
				let temp = [h3Start, h3End, subText.slice(h3Start)];
				arr.push(temp);
	//			arr.push(h3Start + delim + h3End + delim + subText.slice(h3Start));
			} else {		
				let temp = [h3Start, h3End, subText.slice(h3Start, h3End)];
				arr.push(temp);

	//			arr.push(h3Start + delim + h3End + delim + subText.slice(h3Start, h3End));
			}
		}
		offset = h3Start + 4; // so it ignores the previous <h3>

	} 
	
	// modify the text in the array and replace it in original string
	for (i = 0; i < arr.length; i++){
		let temp = arr[i][2];


		// add the div boxes 
		temp = '<div>' + temp + '</div>';

		if (i == 0){
			temp = '<div class="item-grid cols-1">' + temp;
		}
		if (i == arr.length - 1){
			temp = temp + '</div>';
		}

		// replacing in the original string
		subText = subText.split(arr[i][2]).join(temp);
		
	}
	
	return subText;
}

function hideForm(){
	x = document.getElementById("formColumn");
	
	x.style.display = "none";
}
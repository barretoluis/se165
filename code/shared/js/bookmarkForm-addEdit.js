function processUrl(url) {
	resetData();

	if(url.indexOf("http://") == -1 && url != "http://") {
		url = "http://" + url;
		document.getElementById("url").value = url;
	}

	populateData(url);
}

function resetData() {
	getImages(null);
	setImage('/shared/images/placeholder.jpg');
	document.getElementById("selectImgBtn").style.visibility = "hidden";
	document.getElementById("createBookmark").description.disabled = true;
	document.getElementById("createBookmark").description.value ="";
	document.getElementById("createBookmark").keywords.disabled = true;
	document.getElementById("createBookmark").privacy.disabled =true;
	document.getElementById("createBookmark").tid.disabled = true;
	quitarTodo();
}

function populateData(url) {
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			getDescription(url);
			getImages(url);
			enableTodo();
			displayImages();
		} else if(xmlhttp.readyState==4 && xmlhttp.status!=200) {
			alert('Please provide a valid URL.');
		}
	}

	xmlhttp.open("GET",'getURLvalid.php?url='+url,true);
	xmlhttp.send();
}

function getDescription(url) {
	var xmlhttp;

	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("createBookmark").description.value=xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET",'getURLdes.php?url='+url,true);
	xmlhttp.send();
}

function checkStatus() {
	enableTodo();
}

function enableTodo(){
	document.getElementById("createBookmark").description.disabled = false;
	document.getElementById("createBookmark").keywords.disabled = false;
	document.getElementById("createBookmark").privacy.disabled = false;
	document.getElementById("createBookmark").tid.disabled = false;
}

function quitarTodo(){
	document.getElementById("createBookmark").description.disabled = true;
	document.getElementById("createBookmark").keywords.disabled = true;
	document.getElementById("createBookmark").privacy.disabled = true;
	document.getElementById("createBookmark").tid.disabled = true;
}

function getImages(url){
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("sitePictures").style.visibility = "visible";
			document.getElementById("sitePictures").innerHTML=xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET",'getURLpic.php?url='+url,true);
	xmlhttp.send();
}

function setImage(src){
	if(src != null) {
		document.getElementById("timage").src = src;
		document.getElementById("sitePictures").style.visibility = "hidden";
		document.getElementById("sitePictures").style.height = "0px";
		document.getElementById("imageSrc").value = src;
		document.getElementById("selectImgBtn").innerHTML = "Select a new Image"
		document.getElementById("selectImgBtn").style.visibility = "visible";
	}
}

function displayImages(){
	document.getElementById("sitePictures").style.visibility = "visible";
	document.getElementById("sitePictures").style.height = "300px";
}

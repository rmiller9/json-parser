<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Parsing JSON objects</title>
<script type="text/javascript" src="oscar-winners.json"></script>
<link href="oscar-winners.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="pageNote">A demonstration of parsing JSON and displaying results with vanilla javaScript</div>
	<div id="wrapper">
		<h1 id="headline"></h1>
		<select id="selector"></select>
		<div id="target"></div>
	</div><!-- wrapper -->
</body>
</html>
<script>
var xmlhttp = new XMLHttpRequest();
var url = "oscar-winners.json";
var jsonResults = [];
	
xmlhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
        jsonResults = JSON.parse(this.responseText);
        populateOptions(jsonResults);
    }
};
xmlhttp.open("GET", url, true);
xmlhttp.send();

function populateOptions(arr) {
    var out = "";
        for(var i in arr) {
        out += '<option value="' + arr[i].year + '">' + 
        arr[i].year + '</option>';
    }
    document.getElementById("selector").innerHTML = out;
	document.getElementById("headline").innerHTML = arr.length + " years of Academy Awards"
}
function detectSelection(selector,callback){
  var isItClicked = document.getElementById(selector);
  isItClicked.addEventListener('change', callback); 
}
function getTitle(){
  var selectElement = document.getElementById('selector');
  var selection = selectElement.options[selectElement.selectedIndex].value;
  for(j in jsonResults){
    if(jsonResults[j]['year'] == selection){
      writeResult("<h2>Best Picture, " + jsonResults[j].year + ":<br> " + jsonResults[j].title + "</h2><button id=\"more-info\">More Info</button><div class=\"additional-info hidden\"><span class=\"director\">Directed by " + jsonResults[j].director + "</span><br><span class=\"screenwriter\">Screenplay by " + jsonResults[j].screenwriter + "</span><br><span class=\"awards\"><strong>Awards:</strong><div id=\"awardsList\">" + jsonResults[j].awards.join(",<br>") + "</div>");
	  clickListen('more-info',reveal);		
	}
  }
}	

/* moveArticle checks if titles begin with 'the' or 'an' or 'a' and if they do it moves the article to the end after a comma. */
function moveArticle(title){
  var alteredTitle = title.split(" ");
  var begin = alteredTitle[0].toLowerCase();
  if(begin == "the" || begin == "a" || begin == "an"){
    var temp = alteredTitle.shift();
    alteredTitle.push(", " + temp);
    return alteredTitle.join(" ");
  } else {
    return title;
  }
}
var writeResult = function(result){
  document.getElementById('target').innerHTML = "<div>" + result + "</div>";
}
var clickListen = function(selector,callback){
	  var isItClicked = document.getElementById(selector);
	  isItClicked.addEventListener('click',callback);
}
var reveal = function(){
	var elems = document.querySelectorAll(".hidden");
	[].forEach.call(elems, function(el) {
    	el.className = el.className.replace(/\bhidden\b/, "");
	});
	
}
detectSelection('selector',getTitle);	


</script>

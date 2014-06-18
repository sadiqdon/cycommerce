$('#database_type').tooltip('toggle');

function startCounter(){
	try {
		var db_type = document.getElementById("db_type").innerHTML;
		var host = document.getElementById("host").innerHTML;
		var name = document.getElementById("name").innerHTML;
		var username = document.getElementById("username").innerHTML;
		var password = document.getElementById("password").innerHTML;
		$("#ajaxBox").load('setup.php', {"db_type": db_type , "host": host,"name": name,"username": username,"password": password});
		
		var myVar = setInterval(function(){myTimer()},1000);
		return true;
	}catch(err) {
		alert(err);
		return false;
	}
}
	
	
var Count = (function() {

var counter = 0;

	return function() {
		counter += 0.5;
		this.name = "Cycommerce";
		this.count = counter;
		//alert(counter);
		}
})();


function myTimer() {
	var count = new Count();
	var current = 0;
	var countCon = document.getElementById("countCon");
	
	countCon.style.width = count.count + '%';				
	document.getElementById("count").innerHTML = count.count + '%';
}




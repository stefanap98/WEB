/*
if (typeof jQuery === "undefined") {
    var script = document.createElement('script');
    script.src = 'http://code.jquery.com/jquery-latest.min.js';
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
}*/
$(document).ready(function(){
	
	$(".project").click(function() {
		var id = $(this)[0].id;
		window.location = "http://localhost/AppStoreProject/project.php?id=" + id;
	});
	/*интересно защо не работи
	$(".homeButton").click(function() {
		window.location = "https://www.w3schools.com/php/php_forms.asp";
	});*/
	

});

function Home() {
  window.location.href = "http://localhost/AppStoreProject/index.php";
}
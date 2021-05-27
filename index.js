/* Ако липсва jquery това проверява и го добавя във файла
if (typeof jQuery === "undefined") {
    var script = document.createElement('script');
    script.src = 'http://code.jquery.com/jquery-latest.min.js';
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
}*/

// при зареждане на документа
$(document).ready(function(){
	//добавяне на onclick event на project div-ове
	$(".project").click(function() {
		var id = $(this)[0].id;
		window.location = "http://localhost/AppStoreProject/project.php?id=" + id;
	});
	/*интересно защо не работи
	$(".homeButton").click(function() {
		window.location = "https://www.w3schools.com/php/php_forms.asp";
	});*/
	

});

//добавяне на onclick event за бутона в upload.php за връщане към index.php
function Home() {
  window.location.href = "http://localhost/AppStoreProject/index.php";
}
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
		window.location = "project.php?id=" + id;
	});
	/*интересно защо не работи
	$(".homeButton").click(function() {
		window.location = "https://www.w3schools.com/php/php_forms.asp";
	});*/
	

});

//добавяне на onclick event за бутона в upload.php за връщане към index.php
function Home() {
  window.location.href = "index.php";
}

function UploadForm() {
  window.location.href = "uploadForm.php";
}

function toggleFormShowinfg(){
	var form =document.getElementByID("update_form");
	var file =document.getElementByID("newProjectFile");
	var name =document.getElementByID("newProjectTitle");
	var desc =document.getElementByID("newProjectDescription");
	var butt =document.getElementByID("submit_update");
	if (form.classList.contains('update_form_hidden')){
		form.classList.remove('update_form_hidden');
		file.classList.remove('update_form_hidden');
		name.classList.remove('update_form_hidden');
		desc.classList.remove('update_form_hidden');
		butt.classList.remove('update_form_hidden');

		form.classList.add('update_form_visible');
		file.classList.add('update_form_visible');
		name.classList.add('update_form_visible');
		desc.classList.add('update_form_visible');
		butt.classList.add('update_form_visible');
	} else {
		form.classList.add('update_form_hidden');
		file.classList.add('update_form_hidden');
		name.classList.add('update_form_hidden');
		desc.classList.add('update_form_hidden');
		butt.classList.add('update_form_hidden');

		form.classList.remove('update_form_visible');
		file.classList.remove('update_form_visible');
		name.classList.remove('update_form_visible');
		desc.classList.remove('update_form_visible');
		butt.classList.remove('update_form_visible');
	}

}

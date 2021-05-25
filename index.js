$(document).ready(function(){
	
	$(".project").click(function() {
		var id = $(this)[0].id;
		window.location = "http://localhost/AppStoreProject/project.php?id=" + id;
	});
	
});
// при зареждане на документа
$(document).ready(function(){
	//добавяне на onclick event на project div-ове
	$(".project").click(function() {
		var id = $(this)[0].id;
		window.location = "project.php?id=" + id;
	});
});

//добавяне на onclick event за бутона в upload.php за връщане към index.php
function Home() {
  window.location.href = "index.php";
}

function UploadForm() {
  window.location.href = "upload_form.php";
}

function toggleFormDisplay(){
  var form = document.getElementById("updateForm");
  if(form.style.display == "block") {
	form.style.display = "none";
	return;
  }
  form.style.display = "block";
}

function cmp_id(tag1,tag2){
	var quallity_t1 = tag1.getAttribute('id');
	var quallity_t2 = tag2.getAttribute('id');
	if (parseInt(quallity_t1) < parseInt(quallity_t2)) return -1;
	if (parseInt(quallity_t1) > parseInt(quallity_t2)) return 1;
	return 0;
}

function cmp_date(tag1,tag2){
	var quallity_t1 =tag1.getAttribute('uploaded_time');
	var quallity_t2 =tag2.getAttribute('uploaded_time');
	if (quallity_t1 < quallity_t2) return -1;
	if (quallity_t1 > quallity_t2) return 1;
	return 0;
}
function cmp_name(tag1,tag2){
	var quallity_t1 = tag1.getAttribute('project_name');
	var quallity_t2 = tag2.getAttribute('project_name');
	if (quallity_t1 < quallity_t2) return -1;
	if (quallity_t1 > quallity_t2) return 1;
	return 0;
}
function cmp_group(tag1,tag2){
	var quallity_t1 = tag1.getAttribute('project_group');
	var quallity_t2 = tag2.getAttribute('project_group');
	if (parseInt(quallity_t1) < parseInt(quallity_t2)) return -1;
	if (parseInt(quallity_t1) > parseInt(quallity_t2)) return 1;
	return 0;
}

function Sort(criteria){
	var all_nodes = document.getElementById("projects").childNodes;
	var flt = [];

	for (node in all_nodes){
		if(all_nodes[node].tagName == 'DIV') flt.push(all_nodes[node]);
	}

	switch(criteria){
		case'date':
			flt = flt.sort(cmp_id);
			allProjects = allProjects.sort(cmp_id);
			break;
		case 'last_uploaded':
			flt = flt.sort(cmp_date);
			allProjects = allProjects.sort(cmp_date);
			break;
		case 'name':
			flt = flt.sort(cmp_name);
			allProjects = allProjects.sort(cmp_name);
			break;
		case 'group':
			flt = flt.sort(cmp_group);
			allProjects = allProjects.sort(cmp_group);
			break;
	}

	document.getElementById("projects").innerHTML = '';
	var prj = document.getElementById("projects");
	for (node in flt){
		prj.appendChild(flt[node]);
	}

}
const prjList = document.getElementById('projects');
const searchBar = document.getElementById('searchBar');
let allProjects = [];
function in_props(tag, item){
	var attr = tag.getAttribute("project_name").toLowerCase();
	return  attr.includes(item)||item == "";
}

searchBar.addEventListener('keyup', (e) => {
    const searchString = e.target.value.toLowerCase();
    const filtered = allProjects.filter((project) => {
        return in_props(project,searchString);
    });
    prjList.innerHTML = "";
    display(filtered);
});

const display = (flt) => {
	for (node in flt){
		prjList.appendChild(flt[node]);
	}
};

function load_sug(){
	console.log("loaded");
	var all_nodes = document.getElementById("projects").childNodes;
	for (node in all_nodes){
		if(all_nodes[node].tagName == 'DIV') allProjects.push(all_nodes[node]);
		console.log(all_nodes[node]);
	}

}

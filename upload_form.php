<!DOCTYPE html>
<html>
<head>
  <title>Project upload</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta charset="utf-8"/>
  
  <!-- Може би малко излишни мета данни, но са добавени за да се покаже повече знания -->
  <meta name="author" content="Stefan Pelke, Rosen Popov"/>
  <meta name="description" content="This is our web assignment in which we develope an app store for people to upload and download their projects"/>
  <meta name="keywords" content="WEB,projects,App,Store"/>
  
  <!-- Вмъкване на външен css файл, добавен е php код за да не зе кешира css файла, защото иначе колкото и да го променям сайта не го показва "That will add the current timestamp on the end of a file path, so it will always be unique and never loaded from cache." -->
  <link href="index.css?<?php echo time(); ?>" rel="stylesheet">
  
  <!-- Вмъкване на jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  <!-- Вмъкване на външен javascript файл -->
  <script src="index.js?<?php echo time(); ?>"></script>
</head>

<body>
	<!--Some rules to follow for the HTML form above:
		Make sure that the form uses method="post"
		The form also needs the following attribute: enctype="multipart/form-data". It specifies which content-type to use when submitting the form -->
	<!-- Post заявка със задаване на проекта и информация за нея -->
	<form action="upload.php" method="post" enctype="multipart/form-data">        
	  <label for="projectTitle">Project Title</label>
	  <input type="text" id="projectTitle" name="projectTitle" required />
	  
	  <label for="projectFile">Upload new project</label>
	  <input type="file" id="projectFile" name="projectFile" required />
	  
	  <label for="projectDescription"> Project Description</label>
	  <textarea id="projectDescription" name="projectDescription" required> </textarea>
	  
	  <input type="submit"/>
	</form>
</body>
</html>

<!-- Всеки проект може да се отваря в нова страница с описание, бутон за сваляне и коментари -->

<!DOCTYPE html>
<head>
  <title>Projects App Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8"/>
  
  <!-- Може би малко излишни мета данни, но са добавени за да се покаже повече знания -->
  <meta name="author" content="Stefan Pelke, Rosen Popov"/>
  <meta name="description" content="This is our web assignment in which we develope an app store for people to upload and download their projects"/>
  <meta name="keywords" content="WEB,projects,App,Store"/>
  
  <!-- Вмъкване на външен css файл -->
  <link href="AppStoreStyle.css" rel="stylesheet">
  
  <!-- Вмъкване на външен javascript файл -->
  <script src="AppStoreScript.js"></script>
</head>
<body>
  <h1> List of available projects</h1>
  
  <div id="projects">
  
<?php 
	echo "start";

    $serverName = "localhost";
    $database = "appstoredb";
	$user = "root";
	$pass = "";
    try {
        $conn = new PDO(
            "mysql:host=$serverName;dbname=$database;",
            $user,
            $pass
            
        );
    }
    catch(PDOException $e) {
        die("Error connecting to SQL Server: " . $e->getMessage());
    }
    
	echo "OK";
?>

  </div>
  
<!-- Бутон за качване на презентация пращащ информация към php файл -->
<form action="/AppStorePhp.php">
  <label for="newProject">Upload new project =></label>
  <input type="file" id="newProject" name="projectname" multiple /> <!--multiple--> 
  <input type="submit"/>
</form>
</body>
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
  <link href="index.css" rel="stylesheet">
  
  <!-- Вмъкване на jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  <!-- Вмъкване на външен javascript файл -->
  <script src="index.js"></script>
</head>
<body>
  <h1> List of available projects</h1>
  
  <div id="projects">
  
<?php 

    $serverName = "localhost";
    $database = "appstoredb";
	$user = "root";
	$pass = "";
    try {
        $conn = new PDO(
			//"sqlsrv:data source=$serverName;initial catalog=$database; Integrated Security=SSPI;", -> startError connecting to SQL Server: could not find driver
            "mysql:host=$serverName;dbname=$database;",
            $user,
            $pass
            
        );
    }
    catch(PDOException $e) {
        die("Error connecting to SQL Server: " . $e->getMessage());
    }
    
	$sql = "SELECT id, title, `description` FROM appstoredb.projects";
	$result = $conn->query($sql);
	$projects = $result->fetchAll();
	
	
	if (count($projects) > 0) {
  // output data of each row
  foreach($projects as $row) {
    //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
	echo "<div class='project' id='".$row["id"]."'>
	  <h3>".$row["title"]."</h3>
	  <p class='description'>".$row["description"]."</p>
	</div>";
  }
} else {
  echo "0 results";
}
$conn = null;

?>

  </div>
  
<!-- Бутон за качване на презентация пращащ информация към php файл -->
<!-- Post заявка със задаване на име и друга информация за проекта -->
<form action="/Upload.php">
  <label for="newProject">Upload new project =></label>
  <input type="file" id="newProject" name="projectname" /> <!--multiple--> 
  <input type="submit"/>
</form>
</body>

<!-- Login forma -->
<!-- Syhranenie na paroli -> PHP password API-->
<!-- Upload php -->
<!-- Proverka pri ka4vane na nova versiq na proekta, dali toi e sobstvenik na proekta -->
<!-- Pri ostavqne na komentar da e sobtsvenik ili teacher -->
<!-- Button za comment-->
<!-- Button za nova versiq-->
<!-- V bazata danni se zapazva samo heshirnata parola sled tova pri log in se sravnqva hashirana parola s tazi v bazata-->
<!-- Link s koito da ti tegli file-->

<!-- 
form login
form sign up
form new project
form update project
form add comment

proverka za dannite na forma s javascript sled tova phpto da proveri dali sa verni
-->
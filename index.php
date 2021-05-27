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
  
  <!-- Вмъкване на външен css файл, добавен е php код за да не зе кешира css файла, защото иначе колкото и да го променям сайта не го показва "That will add the current timestamp on the end of a file path, so it will always be unique and never loaded from cache."-->
  <link href="index.css?<?php echo time(); ?>" rel="stylesheet">
  
  <!-- Вмъкване на jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  <!-- Вмъкване на външен javascript файл -->
  <script src="index.js?<?php echo time(); ?>"></script>

</head>
<body>
  <h1> List of available projects</h1>
  
  <div id="projects">
  
  <!-- php код за връзка с базата  -->
<?php 

  $serverName = "localhost";
  $database = "appstoredb";
  $user = "root";
  $pass = "";
  try {
      $conn = new PDO(
	  //"sqlsrv:data source=$serverName;initial catalog=$database; Integrated Security=SSPI;", -> startError connecting to SQL Server: could not find driver // това е за Microsoft sql но ми бъгва?
      "mysql:host=$serverName;dbname=$database;",
      $user,
      $pass  
      );
    }
  catch(PDOException $e) {
      die("Error connecting to SQL Server: " . $e->getMessage());
    }
    
  // избираме id, заглавие и описание на проекта от базата
  $sql = "SELECT id, title, `description` FROM appstoredb.projects";
  $result = $conn->query($sql);
  $projects = $result->fetchAll();
	
  // Визуализиране на проектите 
  if (count($projects) > 0) {

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
  
<!-- Post заявка със задаване на проекта и информация за нея -->
<form action="http://localhost/AppStoreProject/upload.php" method="post">        
  <label for="projectTitle">Project Title</label>
  <input type="text" id="projectTitle" name="projectTitle" />
  
  <label for="projectFile">Upload new project</label>
  <input type="file" id="projectFile" name="projectFile" />
  
  <label for="projectDescription"> Project Description</label>
  <textarea id="projectDescription" name="projectDescription"> </textarea>
  
  <!--Скрито поле за дата взета от php -->
  <input type="text" id="projectDate" name="projectDate" value="<?php echo date('Y-m-d H:i:s'); ?>" />
  <!-- Остана дата на качване и location-->
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
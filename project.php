<head>
  <title>Project information </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<!-- php script за свързване с базата и извличане на данните по селектирания проект-->
<?php
//echo "<p>".$_GET['id']. "</p>";

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
		
		 
		$sql = "SELECT * FROM appstoredb.projects WHERE id=:id";
		$sth = $conn->prepare($sql);
		$sth->execute(array("id" => $_GET["id"])); //Така е написано за да се избегне SQL injection
		$project = $sth->fetch(); //object

		$sql = "SELECT * FROM appstoredb.comments WHERE id=:id";
		$sth = $conn->prepare($sql);
		$sth->execute(array("id" => $_GET["id"])); //Така е написано за да се избегне SQL injection
		$comments = $sth->fetchAll(); //array of objects
		
		//Тук пишем динамичната html страница
		//tuka trqbva css da opravq, buttona e tymen, teksta ne e podravnen sys ostanaite elementi
		echo "<div><h1>" . $project['Title'] . "</h1> 
			  <h3> Project created: <time>" . $project['DateCreated'] . "</time> </h3> 
			  <h3> Project modified: <time>" . $project['DateModified'] . "</time> </h3> 
			  <h3> Project Description</h3> <p>" . $project['Description'] . "</p> 
			  <a href='ProjectsFileLocation/" . $project['FileLocation'] . "' download>
				<button> Download project </button>
			  </a> 
			  <form action='http://localhost/AppStoreProject/comments.php'>
				<textarea id='comment' name='comment' rows='4' cols='50' placeholder='Type comment here'></textarea> 
				<input type='submit'>
			  </form></div>";
    }
	
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
   
	$conn = null;
?>
<button type="button" onclick="Home()"> Head back to Home screen </button>
</body>

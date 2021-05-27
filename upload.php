<head>
  <title>Project upload window</title>
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

<?php 
// с $_POST достъпваме елементите пратени от формата от файл Index.php

//връзка с базата
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
        echo "Error: " . $e->getMessage();
    }

//проверка дали съществува такъв проект
	/*$sql = "SELECT Title, `Description`, FileLocation FROM appstoredb.projects WHERE Title='$_POST[projectTitle]' AND FileLocation='$_POST[projectFile]'";
	*/
	
	$sql = "SELECT COUNT(1) FROM appstoredb.projects WHERE Title=$_POST[projectTitle]";//FileLocation='$_POST[projectFile]';";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
	
	if(intval($result[0][0])) {
	  echo "<h1> Warning: Project already exists </h1>";
	  
	  //добавяне в базата
	  /*
	  $sql = "INSERT INTO `projects` (`Title`,`Description`,`DateCreated`,`DateModified`,FileLocation) VALUES ('$_POST[projectTitle]','$_POST[projectDescription]','$_POST[projectDate]','$_POST[projectDate]','$_POST[projectFile]')";
	  $sth = $conn->prepare($sql);
	  $sth->execute();
	  */
	} else {
	  echo "<h1> CONGRATS you just uploaded your project</h1>";
	}

// затваряне на връзката с базата
  $conn = null;
?>
<button type="button" onclick="Home()"> Head back to Home screen </button>
</body>
<?php   
  session_start();
?>
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
  <script src="javascript/index.js?<?php echo time(); ?>"></script>
</head>

<body>

<?php
	//връзка с базата
	require 'db_setup.php';
    try {
        $conn = new PDO(
        "mysql:host=$serverName;dbname=$database;",
        $user,
        $pass
        );
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

	//променливи за update на проект
	$projId = $_POST["modProjId"];
	$updateProjectTitle = htmlspecialchars($_POST["modProjectTitle"]);
	$updateProjectDescription = htmlspecialchars($_POST["modProjectDescription"]);
	$projModDate = date('Y-m-d H:i:s');
	
	//Заявка към базата данни за Update-ване на ред
	$sql = "UPDATE `appstoredb`.`projects` SET `Title` = '$updateProjectTitle', `Description` = '$updateProjectDescription', `DateModified` = '$projModDate' WHERE Id = '$projId';"; 
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	
	
	// затваряне на връзката с базата
    $conn = null;
?>
<h1> Successfully updated information about your project!</h1>
<button type="button" onclick="Home()"> Head back to Home screen </button>
</body>
</html>
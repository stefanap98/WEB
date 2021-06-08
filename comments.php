<?php
session_start();
if (isset($_SESSION["id"]) == false) {
  header("Location:login.php");
}

if (isset($_SESSION["admin"]) == true) {
  $comment = $_POST["comment"];
  $prj_id = $_POST["project_id"];
  $us_id = $_SESSION["id"];
  $date = date('Y-m-d H:i:s');

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
	
	$sql = "INSERT INTO `comments` (`ProjectId`,`UserId`,`Text`,`Timestamp`) VALUES ('$prj_id','$us_id','$comment','$date')";
	$sth = $conn->prepare($sql);
	$sth->execute();

	} catch (PDOException $e) {
	  echo "Error: " . $e->getMessage();
  }
  $conn = null;
}
header("Location:project.php?id=$prj_id");
?>
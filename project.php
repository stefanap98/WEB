<?php

//echo $_GET["id"];
//var_dump($_GET);


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
    
	$sql = "SELECT * FROM appstoredb.projects WHERE id=:id";
	$sth = $conn->prepare($sql);
	$sth->execute(array("id" => $_GET["id"])); //Така е написано за да се избегне SQL injection
	$project = $sth->fetch(); //object

	//var_dump($project);
	
	$sql = "SELECT * FROM appstoredb.comments WHERE id=:id";
	$sth = $conn->prepare($sql);
	$sth->execute(array("id" => $_GET["id"])); //Така е написано за да се избегне SQL injection
	$comments = $sth->fetchAll(); //array of objects
	$conn = null;
?>
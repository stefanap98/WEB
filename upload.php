<head>
  <title>Project success or error</title>
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

<?php 
// с $_POST достъпваме елементите а с $_FILES файловете пратени от формата от файл Index.php

//връзка с базата
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
        echo "Error: " . $e->getMessage();
    }

	//проверка дали съществува такъв проект
	$sql = "SELECT COUNT(1) FROM appstoredb.projects WHERE Title='".$_POST["projectTitle"]."'"; //тука може да се провери и името на файла дали съществува в базата
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
	
	if($result==null || $result[0][0] >= 1) {
	  echo "<h1 class='error'> Warning: Project already exists </h1>";
	} else {
		// Добавяне в базата
		$projName = htmlspecialchars( basename( $_FILES["projectFile"]["name"])); //създавам променлива в която складирам името на файла
		
		// Код за качване на файла в папка
		$target_dir = "ProjectsFileLocation/" ;
		$target_file = $target_dir . $projName;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		// Проверка дали съществува файла
		if (file_exists($target_file)) {
		echo "<h1 class='error'>Sorry, file already exists.</h1>";
		$uploadOk = 0;
		}
		
		// Проверка дали файла надвишава лимит
		if ($_FILES["projectFile"]["size"] > 35000000) {
		echo "<h1 class='error'>Sorry, your file is too large.</h1>";
		$uploadOk = 0;
		}
		
		// Проверка за extensiona
		if($imageFileType != "zip" && $imageFileType != "rar" && $imageFileType != "gz"
		&& $imageFileType != "tar" && $imageFileType != "7z") {
			echo "<h1 class='error'>Sorry, only ZIP, RAR, GZIP, TAR or 7ZIP files are allowed.</h1>";
			$uploadOk = 0;
		}
		
		// Проверка дали променливата $uploadOk има стойност 0 поради грешка
		if ($uploadOk == 0) {
			echo "<h1 class='error'>Sorry, your file was not uploaded.</h1>";
		// Ако всичко е добре качваме файла
		} else {
			if (move_uploaded_file($_FILES["projectFile"]["tmp_name"], $target_file)) {
				echo "<h1 class='success'>The file ". $projName . " has been uploaded.</h1>";
				$sql = "INSERT INTO `projects` (`Title`,`Description`,`DateCreated`,`DateModified`,FileLocation) VALUES ('$_POST[projectTitle]','$_POST[projectDescription]','$_POST[projectDate]','$_POST[projectDate]','$projName')";
				$sth = $conn->prepare($sql);
				$sth->execute();
				echo "<h1 class='success'> CONGRATS you just uploaded your project</h1>";
			} else {
				echo "<h1 class='error'>Sorry, there was an error uploading your file.</h1>";
			}
		}
	} 

	//код за проверка на файла от сайт на php / Алтернатива на това което съм писал
	/*
	try {
   
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['projectFile']['error']) ||
        is_array($_FILES['projectFile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['projectFile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($_FILES['projectFile']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['projectFile']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }
	
	var_dump($_FILES['projectFile']);
	var_dump($_FILES);
	var_dump($_FILES['projectFile']['tmp_name']);
	
	/*
    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    if (!move_uploaded_file(
        $_FILES['projectFile']['tmp_name'],
        sprintf('./uploads/%s.%s',
            sha1_file($_FILES['projectFile']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    echo 'File is uploaded successfully.';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}*/

// затваряне на връзката с базата
  $conn = null;
?>

<button type="button" onclick="Home()"> Head back to Home screen </button>
</body>
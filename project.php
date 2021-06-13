<!DOCTYPE html>
<html>
<head>
  <title>Project information </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta charset="utf-8" />

  <!-- Може би малко излишни мета данни, но са добавени за да се покаже повече знания -->
  <meta name="author" content="Stefan Pelke, Rosen Popov" />
  <meta name="description" content="This is our web assignment in which we develope an app store for people to upload and download their projects" />
  <meta name="keywords" content="WEB,projects,App,Store" />

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
session_start();
if (isset($_SESSION["id"]) == false) {
	header("Location:login.php");
  }
  echo "<p class='uname'> Logged in as: " . $_SESSION["name"] . "</p>";
  echo "<input type='button' class='logout' value='Log Out' onClick=\"document.location.href='logout.php'\" />";
  if ($_SESSION["admin"] == 1) {
	  echo "<input type='button' class='admin' value='Admin' onClick=\"document.location.href='admin_page.php'\" />";
  }
	if (isset($_POST['newProjectTitle']))
	{
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
	    } catch (PDOException $e) {
	      die("Error connecting to SQL Server: " . $e->getMessage());
	    }
		//=========================
		$idd = $_GET["id"];
		$sql = "SELECT * FROM appstoredb.projects WHERE id = $idd";
		$sth = $conn->query($sql);
		$project = $sth->fetch(); //object

		$project_name = $_POST['newProjectTitle'];
		$project_descr= $_POST['newProjectDescription'];
		
		if (isset($_POST['newProjectFile'])){
			$projName = htmlspecialchars( basename( $_FILES["newProjectFile"]["name"])); //създавам променлива в която складирам името на файла
			
			// Код за качване на файла в папка
			$target_dir = "ProjectsFileLocation/".$_SESSION['group']."/";
			$target_file = $target_dir . $projName;
			$oldfile = $project['FileLocation'];
			$uploadOk = 1;
			$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
			//Проверка дали има създадена папка за проекти, ако не я създаваме
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}
			
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
			if($fileType != "zip" && $fileType != "rar" && $fileType != "gz"
			&& $fileType != "tar" && $fileType != "7z") {
				echo "<h1 class='error'>Sorry, only ZIP, RAR, GZIP, TAR or 7ZIP files are allowed.</h1>";
				$uploadOk = 0;
			}
			
			// Проверка дали променливата $uploadOk има стойност 0 поради грешка
			if ($uploadOk == 0) {
				echo "<h1 class='error'>Sorry, your file was not uploaded.</h1>";
			// Ако всичко е добре качваме файла
			} else {
				if (move_uploaded_file($_FILES["newProjectFile"]["tmp_name"], $target_file)) {
					
					echo "<h1 class='success'>The file ". $projName . " has been uploaded.</h1>";
					$gr_id = $_SESSION['group'];
					$sql = "INSERT INTO `projects` (GroupId,`Title`,`Description`,`DateCreated`,`DateModified`,FileLocation) VALUES ('$gr_id','$_POST[projectTitle]','$_POST[projectDescription]','$_POST[projectDate]','$_POST[projectDate]','$projName')";
					$sth = $conn->prepare($sql);
					$sth->execute();
					if ($target_file != $oldfile){
						unlink($oldfile);
					}
					echo "<h1 class='success'> CONGRATS you just uploaded your project</h1>";
				} else {
					echo "<h1 class='error'>Sorry, there was an error uploading your file.</h1>";
				}
			}
		} 
		$project_name = $_POST['newProjectTitle'];
		$project_descr= $_POST['newProjectDescription'];
        $sql = "UPDATE appstoredb.Projects SET Title='$project_name' Description='$project_descr' WHERE Id='$idd'";
	    $result = $conn->query($sql);
	    $id = $result->fetch();
		$conn = null;
		}
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

	  $sql = "SELECT * FROM appstoredb.projects WHERE id = :id";
	  $sth = $conn->prepare($sql);
	  $sth->execute(array("id" => $_GET["id"])); //Така е написано за да се избегне SQL injection
	  $project = $sth->fetch(); //object

	  //тука извличаме всички коментари от базата
	  $prj_id = $_GET["id"];
	  $comments_quer = "SELECT * FROM appstoredb.Comments WHERE ProjectId = $prj_id ";
	  $sth = $conn->prepare($comments_quer);
	  $sth->execute();
	  $all_comments = $sth->fetchAll(); //обект с всички коментари по дадения проект

	  //Тук пишем динамичната html страница
	  echo "<div>
		  <h1>" . $project['Title'] . "</h1>
		  <h3 class='comment_header'> Project created: <time>" . $project ['DateCreated'] . "</time> </h3>
		  <h3 class='comment_header'> Project modified: <time>" . $project['DateModified'] . "</time> </h3>
		  <div class='comment'>
		  <h3 class='comment_header'> Project Description</h3> <p class='comment_body'>" . $project['Description'] . "</p>
		  </div>
		  <a href='ProjectsFileLocation/" . $project['FileLocation'] . "' download>
		  <button> Download project </button>
		  </a>";
	  if ($project['GroupId'] == $_SESSION['group']){
			$project_title = $project['Title'];
			$project_description = $project['Description'];
		  echo "<button onclick='toggleFormShowing()'>Update Project</button>
				<form action='update_project.php class='update_form_hidden' id='update_form' method='post' enctype='multipart/form-data'>
	  				<input type='text' class='update_form_hidden' id='newProjectTitle' name='newProjectTitle' value='$project_title' />
	  				<input type='file' class='update_form_hidden' id='newProjectFile' name='newProjectFile'  />
	  				<textarea id='newProjectDescription' class='update_form_hidden' name='newProjectDescription' value='$project_description' > </textarea>
	  				<input type='submit' class='update_form_hidden' value='Update' id='submit_update'/>
				</form> ";
			}
	echo "<h3> Comment Section </h3>";
	$usr = $_SESSION["admin"];
	if($usr) {
		echo  "<form action='comments.php' method='post'>
				<textarea id='comment' name='comment' rows='4' cols='50' placeholder='Type comment here'></textarea> 
				<input type='hidden' id='project_id' name ='project_id' value='" . $_GET["id"] . "'>
				<input type='submit'>
			  </form>
			  </div>";
		
		$comments_query = "SELECT * FROM appstoredb.Comments WHERE ProjectId = :id;";
		$sth = $conn->prepare($comments_query);
		$sth->execute(array("id" => $_GET["id"])); //Така е написано за да се избегне SQL injection
		$user_info = $sth->fetchAll();
	}
	foreach ($all_comments as $comm) {
		$user_id = $comm["UserId"]; //променлива за това кой е писал коментара

		// цялата информация за коментарите от таблицата
		$user_query="SELECT Username FROM appstoredb.users WHERE ID = $user_id";
		$sth = $conn->prepare($user_query);
		$sth->execute();
		$user = $sth->fetch();

		echo "<div class='comment'>
			<h3 class='comment_header'>" . $user["Username"] . "</h3>
			<h3 class='comment_header'>" . $comm["Timestamp"] . "</h3>
			<p class='comment_body'>" . $comm["Text"]  . "</p>
			</div>";

	}
  } catch (PDOException $e) {
	  echo "Error: " . $e->getMessage();
  }

  $conn = null;
?>
	<button type="button" onclick="Home()"> Head back to Home screen </button>
	</body>
	</html>

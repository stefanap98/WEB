<?php   
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Projects App Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta charset="utf-8" />

  <!-- Може би малко излишни мета данни, но са добавени за да се покаже повече знания -->
  <meta name="author" content="Stefan Pelke, Rosen Popov" />
  <meta name="description" content="This is our web assignment in which we develope an app store for people to upload and download their projects" />
  <meta name="keywords" content="WEB,projects,App,Store" />

  <!-- Вмъкване на външен css файл, добавен е php код за да не зе кешира css файла, защото иначе колкото и да го променям сайта не го показва "That will add the current timestamp on the end of a file path, so it will always be unique and never loaded from cache."-->
  <link href="index.css?<?php echo time(); ?>" rel="stylesheet">

  <!-- Вмъкване на jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Вмъкване на външен javascript файл -->
  <script src="index.js?<?php echo time(); ?>"></script>

</head>

<body>
<?php
$message = "";
if (count($_POST) > 0) {
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
    $sql = "SELECT * FROM appstoredb.Users WHERE Username='" . $_POST["username"] . "' and Password = '" . $_POST["password"] . "'";
    $result = $conn->query($sql);
    $id = $result->fetch();
    if (is_array($id)) {
      $_SESSION["id"] =     $id['Id'];
      $_SESSION["name"] =   $id['Username'];
      $_SESSION["admin"] =  $id['IsTeacher'];
      $_SESSION["group"] =  $id['GroupId'];
      $_SESSION["mail"] =  $id['Email'];
    } else {
      echo "<p>Invalid Username or Password!</p>";
    }
    $conn = null;
    if (strlen($_SESSION["mail"]) == 0) {
      header("Location:reg_email.php");
    }
}
if (isset($_SESSION["id"])) {
  header("Location:index.php");
}
?>
  <form method="post"> <!--action=""> Form Submission subsection of the current HTML5 draft does not allow action="" (empty attribute). It is against the specification.-->
    <label>UserName :</label><input type="text" name="username" required/>
    <label>Password :</label><input type="password" name="password" required/>
    <input type="submit" value=" Submit " />
  </form>
</body>
</html>

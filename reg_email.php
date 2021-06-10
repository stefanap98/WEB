<!DOCTYPE html>
<html>
<head>
  <title>Projects App Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
session_start();
if (count($_POST) > 0) {
      $user_mail = $_POST['email_input'];
      var_dump($user_mail);
      if (filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
        echo "is valid";
        $serverName = "localhost";
        $database = "appstoredb";
        $user = "root";
        $pass = "";
        try {
          $conn = new PDO( "mysql:host=$serverName;dbname=$database;", $user, $pass);
        } catch (PDOException $e) {
          die("Error connecting to SQL Server: " . $e->getMessage());
        }
        $idd = $_SESSION["id"];
        echo $idd;
        $sql = "UPDATE appstoredb.Users SET Email='$user_mail' WHERE Id='$idd'";
        $conn->prepare($sql)->execute();
        $_SESSION["mail"] = $user_mail ;
        $conn = null;
        if (isset($_SESSION["id"])) { 
          header("Location:index.php"); 
        }
      }
      else{
        echo "kur";
      }
}
?>
  <div>You have to enter your email to continue to use the site. It will be used to spam you just fyi.</div>
  <form method="POST">
    <label>Email :</label><input type="text" id="email_input" name="email_input" required/> 
    <input type="submit" value=" Submit " />
  </form>
</body>
</html>


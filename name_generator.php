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
  <button type="button" onclick="Home()"> Head back to Home screen </button>
<?php
class profile
{
  public $name = "";
  public $pass = "";
  public $admin = 0;
  public $groupid = 0;
  public function cons($n, $p,$t)
  {
    $this->name = $n;
    $this->pass = $p;
    $this->team = $t;
  }
  public function sendToDb($conn, $safeguard)
  {
    if (array_key_exists($this->name,  $safeguard) == true)
      echo "<p>Username $this->name exist already</p>";
    else {
      $sql = "INSERT INTO appstoredb.Users (Username, GroupId,Email, Password ,IsTeacher) VALUES ('$this->name','$this->team', '', '$this->pass',$this->admin)";
      if ($conn->query($sql)) {
        echo "<p>" . $sql . "</p>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }
}

function genPass($name)
{
  return substr(sha1($name), 0, 5) . substr(md5($name), 0, 5);
}

function genNamesTeam($team, $nrs)
{
  $res = [];
  foreach ($nrs as $i) {
    $id = trim($i);
    $tmp = "team_" . $team . "_" . $id;
    $tmpUser = new profile();
    $tmpUser->cons($tmp,  genPass($tmp),$team);
    array_push($res,  $tmpUser);
  }
  return $res;
}

function readFiles($fname)
{
  $cred = [];
  $file = fopen($fname,  "r");
  while (!feof($file)) {
    $line = fgets($file);
    if (strlen($line) < 5) continue; // possible empy lones, last line is eg empty
    $data = explode(",", $line);
    if ($data and sizeof($data)   > 1)
      $data =  array_filter($data, "is_numeric");
    foreach (genNamesTeam($data[0],  array_slice($data, 1)) as  $i) {
      array_push($cred,  $i);
    }
  }
  fclose($file);
  return $cred;
}
function getAllNames($conn)
{
  $arr = array();

  $sql = "SELECT Username FROM appstoredb.Users ";
  $tmp = $conn->query($sql);
  $result = $tmp->fetchAll();
  foreach ($result as $nm) {
    $arr[$nm['Username']] = true;
  }
  
  return $arr;
}

function genAdminName($name)
{
  $tmp = "admin_" . $name;
  $adm = new profile();
  $adm->admin = 1;
  $adm->name = $tmp;
  $adm->team = 0;
  $adm->pass = genPass($tmp);
  return $adm;
}

function genLogins($fname)
{
    require 'db_setup.php';
    try {
      $conn = new PDO(
        "mysql:host=$serverName;dbname=$database;",
        $user,
        $pass
      );
    } catch (PDOException $e) {
      die("Error connecting to SQL Server: " . $e->getMessage());
    }

  $res = readFiles($fname);

  array_push($res, genAdminName("Rosen"));
  /*
  array_push($res, genAdminName("Stefan"));
*/
  $safeguard = getAllNames($conn); // make a safeguard for generating names once and do iteraetive generation if name is added
  foreach ($res as $i) {
    $i->sendToDb($conn,  $safeguard);
  }
  $conn = null;
}

genLogins("projects.csv");
?>
</body>
</html>

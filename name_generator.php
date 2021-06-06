<?php
class profile
{
  public $name = "";
  public $pass = "";
  public $admin = 0;
  public function cons($n, $p)
  {
    $this->name = $n;
    $this->pass = $p;
  }
  public function send_to_db($conn, $safeguard)
  {
    if (array_key_exists($this->name,  $safeguard) == true)
      echo "<p>Username $this->name exist already</p>";
    else {
      $sql = "INSERT INTO appstoredb.Users (Username, Email, Password ,IsTeacher) VALUES ('$this->name', '', '$this->pass',$this->admin)";
      if ($conn->query($sql) === TRUE) {
        echo "<p>" . $sql . "</p>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }
}

function gen_pass($name)
{
  return substr(sha1($name), 0, 5) . substr(md5($name), 0, 5);
}

function gen_names_team($team, $nrs)
{
  $res = [];
  foreach ($nrs as $i) {
    $tmp = "team_" . $team . "_" . $i;
    $tmp_user = new profile();
    $tmp_user->cons($tmp,  gen_pass($tmp));
    array_push($res,  $tmp_user);
  }
  return $res;
}

function read_files($fname)
{
  $cred = [];
  $file = fopen($fname,  "r");
  while (!feof($file)) {
    $line = fgets($file);
    if (strlen($line) < 5) continue; // possible empy lones, last line is eg empty
    $data = explode(",", $line);
    if ($data and sizeof($data)   > 1)
      $data =  array_filter($data, "is_numeric");
    foreach (gen_names_team($data[0],  array_slice($data, 1)) as  $i) {
      array_push($cred,  $i);
    }
  }
  return $cred;
}
function get_all_names($conn)
{
  $arr = array();
  $result = mysqli_query($conn, "SELECT Username FROM appstoredb.Users ");
  while ($nm = $result->fetch_row()) {
    $arr[$nm[0]] = true;
  }

  //var_dump($arr);
  return $arr;
}

function gen_admin_name($name)
{
  $tmp = "admin_" . $name;
  $adm = new profile();
  $adm->admin = 1;
  $adm->name = $tmp;
  $adm->pass = gen_pass($tmp);
  return $adm;
}

function gen_ccred($fname)
{
  $conn = new mysqli("localhost", "root", "", "appstoredb");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "<p>Could not connect</p>";
  }


  $res = read_files($fname);
  array_push($res, gen_admin_name("Rosen"));
  array_push($res, gen_admin_name("Stefan"));
  array_push($res, gen_admin_name("Milen"));
  $safeguard = get_all_names($conn); // make a safeguard for generating names once and do iteraetive generation if name is added

  foreach ($res as $i) {
    $i->send_to_db($conn,  $safeguard);
  }
  $conn->close();
}
gen_ccred("proojects.csv");

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
  $conn = new mysqli("localhost", "root", "", "appstoredb");
  $sql = $conn->prepare("INSERT INTO appstoredb.Comments (ProjectId,UserId,Text,Timestamp)  VALUES ('$prj_id', '$us_id', '$comment,'$date')");
}

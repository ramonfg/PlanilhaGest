<?php
require_once('../classes/User.php');

if (isset($_POST['login-submit'])) {

  require "dbh.inc.php";

  $email = strtolower($_POST['email']);
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    header("Location: ../index.php?error=emptyfields");
    exit();
  } else {
    $login = Login($email, $password);
    switch ($login) {
      case "nouser":
        header("Location: ../index.php?error=nouser");
        exit();
        break;
      case "wrongpwd":
        header("Location: ../index.php?error=wrongpwd&email=".$email);
        exit();
        break;
      case "success":
        header("Location: ../index.php?error=success");
        exit();
    }
  }
} else {
  header("Location: ../index.php");
  exit();
}

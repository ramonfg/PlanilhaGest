<?php
require_once('../classes/User.php');

if (isset($_POST['signup-submit'])) {

  $firstName = $_POST['firstName'];
  $surname = $_POST['surname'];
  $email = strtolower($_POST['email']);
  $password = $_POST['password'];
  $passwordRepeat = $_POST['passwordRepeat'];
  $phone = $_POST['phone'];

  if(empty($firstName) || empty($surname) || empty($email) || empty($phone)) {
    header("Location: ../signup.php?error=emptyfields&firstName=".$firstName."&surname=".$surname."&email=".$email."&phone=".$phone);
    exit();
  } else if (empty($password) || empty($passwordRepeat)) {
    header("Location: ../signup.php?error=emptypassword&firstName=".$firstName."&surname=".$surname."&email=".$email."&phone=".$phone);
    exit();
  } else if(false) {
    header("Location: ../signup.php?error=invalidphone&firstName=".$firstName."&surname=".$surname."&email=".$email);
    exit();
  } else if(!preg_match("/^[a-zA-Z0-9_ ]*$/", $firstName)) {
    header("Location: ../signup.php?error=invalidfirstname&surname=".$surname."&email=".$email."&phone=".$phone);
    exit();
  } else if(!preg_match("/^[a-zA-Z0-9_ ]*$/", $surname)) {
    header("Location: ../signup.php?error=invalidsurname&firstName=".$firstName."&email=".$email."&phone=".$phone);
    exit();
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invalidemail&firstName=".$firstName."&surname=".$surname."&phone=".$phone);
    exit();
  } else if ($password !== $passwordRepeat) {
    header("Location: ../signup.php?error=passwordcheck&firstName=".$firstName."&surname=".$surname."&email=".$email."&phone=".$phone);
    exit();
  } else {
    if (IsEmailTaken($email) == -1) {
      header("Location: ../signup.php?error=emailtaken&firstName=".$firstName."&surname=".$surname."&phone=".$phone);
      exit();
    } else {
      if (AddUser($firstName, $surname, $email, $password, $phone)) {
        header("Location: ../signup.php?error=success");
        exit();
      } else {
        header("Location: ../signup.php?error=sqlerror");
        exit();
      }
    }
  }

} else {
  header("Location: ../signup.php");
  exit();
}

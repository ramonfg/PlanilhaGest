<?php
  session_start();
  require_once('../classes/Register.php');

  if (isset($_POST['register-submit'])) {

    $initial = $_POST['initial'];
    $dateday = $_POST['dateday'];
    $datemonth = $_POST['datemonth'];
    $dateyear = $_POST['dateyear'];
    $stake = $_POST['stake'];
    $unitytype = $_POST['unitytype'];

    if (UpdateRegister($_SESSION['id'], $initial, $dateyear."-".$datemonth."-".$dateday, $stake, $unitytype)) {
      header("Location: ../registration.php?error=success");
      exit();
    } else {
      header("Location: ../registration.php?error=sqlerror");
      exit();
    }

  } else {
    header("Location: ../registration.php");
    exit();
  }

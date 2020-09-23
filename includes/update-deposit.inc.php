<?php
  session_start();
  require_once('../classes/Bet.php');

  if (isset($_POST['update-bet-submit'])) {

    $id = $_POST['id-update'];
    $result = $_POST['result'];
    $day = $_POST['day'];

    if(UpdateBet($_SESSION['id'], $id, $result)) {
        header("Location: ../dailycentral.php?error=success&date=".$day);
        exit();
      } else {
        header("Location: ../dailycentral.php?error=sqlerror&date=".$day);
        exit();
      }
  } else {
    header("Location: ../dailycentral.php");
    exit();
  }

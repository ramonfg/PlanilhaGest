<?php
  session_start();
  require_once('../classes/Bet.php');

  if (isset($_POST['delete-bet-submit'])) {

    $id = $_POST['id-delete'];
    $day = $_POST['day'];

    if(DeleteBet($_SESSION['id'], $id)) {
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

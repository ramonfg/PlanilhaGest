<?php
  session_start();
  require_once('../classes/Bet.php');


if (isset($_POST['bet-submit'])) {

  $sport = mb_strtoupper($_POST['sport']);
  $strategy = mb_strtoupper($_POST['strategy']);
  $confront = mb_strtoupper($_POST['confront']);
  $units = $_POST['units'];
  $odds = $_POST['odds'];
  $day = $_POST['day'];

  if (AddBet($_SESSION['id'], $day, $sport, $strategy, $confront, $units, $odds)) {
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

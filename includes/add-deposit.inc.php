<?php
  session_start();
  require_once('../classes/Deposit.php');

  if (isset($_POST['deposit-submit'])) {

    $day = $_POST['dateday'];
    $month = $_POST['datemonth'];
    $year = $_POST['dateyear'];
    $operation = $_POST['operation'];
    $method = mb_strtoupper($_POST['method']);
    $value = $_POST['value'];

    if(empty($day) || empty($month) || empty($year) || ($operation != "0" && $operation != "1") || empty($method) || empty($value)) {
      header("Location: ../deposit.php?error=emptyfields&day=".$day."&month=".$month."&year=".$year."&operation=".$operation."&method=".$method."&value=".$value);
      exit();
    } else {
      if (AddDeposit($_SESSION['id'], $year."-".$month."-".$day, $operation, $method, $value)) {
        header("Location: ../deposit.php?error=success");
        exit();
      } else {
        header("Location: ../deposit.php?error=sqlerror");
        exit();
      }
    }
  } else {
    header("Location: ../deposit.php");
    exit();
  }

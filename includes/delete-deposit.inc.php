<?php
  session_start();
  require_once('../classes/Deposit.php');

  if (isset($_POST['delete-deposit-submit'])) {

    $id = $_POST['id-delete'];
    if(DeleteDeposit($_SESSION['id'], $id)) {
        header("Location: ../deposit.php?error=success");
        exit();
      } else {
        header("Location: ../deposit.php?error=sqlerror");
        exit();
      }
  } else {
    header("Location: ../deposit.php");
    exit();
  }

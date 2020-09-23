<?php

if (isset($_POST['change-day-submit'])) {

  $day = $_POST['day'];

  header("Location: ../dailycentral.php?date=".$day);
  exit();
} else {
  header("Location: ../dailycentral.php");
  exit();
}

<?php

if (isset($_POST['filter-credits-submit'])) {
  $month = $_POST['month'];
  $year = $_POST['year'];
  header("Location: ../admin.php?filtermonth=".$year.'-'.$month);
} else {
  header("Location: ../admin.php");
  exit();
}

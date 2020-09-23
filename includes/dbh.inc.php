<?php

$servername = "localhost";
$dBUsername = "planil48_gest";
$dBPassword = "QuUS*iaQtc+-";
$dBName = "planil48_gest";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn) {
  die("Connection faliled: ".mysqli_connect_error());
}

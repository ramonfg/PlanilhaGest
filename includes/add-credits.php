<?php
  require_once('../classes/User.php');
  if (isset($_POST['add-credits-submit'])) {

    $email = $_POST['email'];
    $months = $_POST['months'];

    if (empty($email) || empty($months)) {
      header("Location: ../admin.php?error=emptyfields&form=addcredits&email=".$email."&months=".$months);
      exit();
    } else if(!is_numeric($months)) {
      header("Location: ../admin.php?error=invalidmonths&form=addcredits&email=".$email);
      exit();
    } else {
      $result = AddCredits($email, $months);
      switch ($result) {
        case 'success':
          header("Location: ../admin.php?error=success&form=addcredits");
          exit();
          break;

        case 'nouser':
          header("Location: ../admin.php?error=nouser&form=addcredits&months=".$months);
          exit();
          break;

        case 'nouser':
          header("Location: ../admin.php?error=sqlerror&form=addcredits");
          exit();
          break;

      }

    }



  } else {
    header("Location: ../admin.php");
    exit();
  }

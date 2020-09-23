<?php
  session_start();
  if (!isset($_SESSION['lang'])) $_SESSION['lang'] = 'pt-br';
  require_once('language/'.$_SESSION['lang'].'.php');

  require_once('classes/User.php');
  if (isset($_SESSION['id'])) {
    $expired = IsUserExpired($_SESSION['id']);
  } else {
    $expired = false;

  }

  if ($page != 'index' && ($expired || !isset($_SESSION['id']))) {
    header("Location: index.php");
    exit();
  }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planilha Gest</title>
    <link rel="icon" href="img/icon.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/deposit.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/dailycentral.css">
    <script
			  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous">
    </script>
    <script src="js/script.js"></script>
    <script src="js/register.js"></script>
    <script src="js/deposit.js"></script>
    <script src="js/dailycentral.js"></script>
  </head>
  <body>

    <header>
      <nav class="nav-header-main">
        <a class="header-logo" href="index.php">
          <img src="img/logo.png" alt="gest logo">
        </a>
        <ul>
          <li><a href="index.php"><?php echo ucfirst($lang_home); ?></a></li>
        <?php
          if (isset($_SESSION['id']) && !$expired) {
            ?>
              <li><a href="registration.php"><?php echo ucfirst($lang_registrationcenter); ?></a></li>
              <li><a href="deposit.php"><?php echo ucfirst($lang_depositcenter); ?></a></li>
              <li><a href="dailycentral.php"><?php echo ucfirst($lang_dailycentral); ?></a></li>
              <!-- <li><a href="#"><?php echo ucfirst($lang_dashboardcenter); ?></a></li> -->
            <?php
          }
         ?>
        </ul>
        <select name="lang" id="lang">
          <option value="pt-br"
          <?php if($_SESSION['lang'] == 'pt-br') echo 'selected="selected"'; ?>>PT</option>
          <option value="en-us"
          <?php if($_SESSION['lang'] == 'en-us') echo 'selected="selected"'; ?>>EN</option>
        </select>
        <?php
          if (isset($_SESSION['id'])) {
            ?>
            <form class="form-logout" action="includes/logout.inc.php" method="post">
              <button type="submit" name="logout-submit"><?php echo strtoupper($lang_logout)?></button>
            </form>
            <?php
          }
         ?>
      </nav>
    </header>

      <main>
        <div class="wrapper-main">

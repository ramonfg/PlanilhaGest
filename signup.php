<?php
  $page = 'signup';
  require "header.php";
?>


    <section class="section-default">
      <h1><?php echo ucfirst($lang_signup); ?></h1>
      <?php
        if (isset($_GET['error'])) {
          switch ($_GET['error']) {
            case "emptyfields":
                echo '<p class="signuperror">'.ucfirst($lang_erroremptyfields).'</p>';
              break;
            case "invalidphone":
                echo '<p class="signuperror">'.ucfirst($lang_errorinvalidphone).'</p>';
              break;
            case "invalidfirstname":
                echo '<p class="signuperror">'.ucfirst($lang_errorinvalidfirstname).'</p>';
              break;
            case "invalidsurname":
                echo '<p class="signuperror">'.ucfirst($lang_errorinvalidsurname).'</p>';
              break;
            case "invalidemail":
                echo '<p class="signuperror">'.ucfirst($lang_errorinvalidemail).'</p>';
              break;
            case "emailtaken":
                echo '<p class="signuperror">'.ucfirst($lang_erroremailtaken).'</p>';
              break;
            case "emptypassword":
              echo '<p class="signuperror">'.ucfirst($lang_erroremptyfields).'</p>';
              break;
            case "passwordcheck":
                echo '<p class="signuperror">'.ucfirst($lang_errorpasswordcheck).'</p>';
              break;
            case "success":
                echo '<p class="signupsuccess">'.ucfirst($lang_errorsuccess).'</p>';
              break;
          }
        }
       ?>
      <form class="form-signup" action="includes/signup.inc.php" method="post">
        <input
          <?php
            if(isset($_GET['error']) && ($_GET['error'] == 'invalidfirstname' || ($_GET['error'] == 'emptyfields' && $_GET['firstName'] == ''))){
              echo 'class="redBorder"';
            }
          ?>
          type="text" name="firstName" placeholder="<?php echo ucfirst($lang_firsname); ?>"
          <?php if (isset($_GET['firstName'])) echo 'value="'.$_GET['firstName'].'"' ?>>

        <input
        <?php
          if(isset($_GET['error']) && ($_GET['error'] == 'invalidsurname' || ($_GET['error'] == 'emptyfields' && $_GET['surname'] == ''))){
            echo 'class="redBorder"';
          }
        ?>
          type="text" name="surname" placeholder="<?php echo ucfirst($lang_surname); ?>"
          <?php if (isset($_GET['surname'])) echo 'value="'.$_GET['surname'].'"' ?>>
        <input
          <?php
            if(isset($_GET['error']) && ($_GET['error'] == 'invalidphone' || ($_GET['error'] == 'emptyfields' && $_GET['phone'] == ''))){
              echo 'class="redBorder"';
            }
          ?>
          type="text" name="phone" placeholder="<?php echo ucfirst($lang_phone); ?>"
          <?php if (isset($_GET['phone'])) echo 'value="'.$_GET['phone'].'"' ?>>
        <input
          <?php
            if (isset($_GET['error']) && ($_GET['error'] == 'invalidemail' || $_GET['error'] =='emailtaken' || ($_GET['error'] == 'emptyfields' && $_GET['email'] == ''))){
              echo 'class="redBorder"';
            }
          ?>
          type="text" name="email" placeholder="<?php echo ucfirst($lang_email); ?>"
          <?php if (isset($_GET['email'])) echo 'value="'.$_GET['email'].'"' ?>>
        <input
        <?php
          if (isset($_GET['error']) && ($_GET['error'] == 'passwordcheck' || $_GET['error'] == 'emptypassword')){
            echo 'class="redBorder"';
          }
        ?>
        type="password" name="password" placeholder="<?php echo ucfirst($lang_password); ?>">
        <input
        <?php
          if (isset($_GET['error']) && ($_GET['error'] == 'passwordcheck' || $_GET['error'] == 'emptypassword')){
            echo 'class="redBorder"';
          }
        ?>
        type="password" name="passwordRepeat" placeholder="<?php echo ucfirst($lang_passwordrepeat); ?>">
        <button type="submit" name="signup-submit"><?php echo strtoupper($lang_signup); ?></button>
      </form>
    </section>

<?php
  require "footer.php";
?>

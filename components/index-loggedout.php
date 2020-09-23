
<main>
  <div class="wrapper-main">
    <section class="section-default">
      <h1><?php echo ucfirst($lang_login); ?></h1>
      <?php
        if (isset($_GET['error'])) {
          switch ($_GET['error']) {
            case "emptyfields":
                echo '<p class="signuperror">'.ucfirst($lang_erroremptyfields).'</p>';
              break;
            case "nouser":
                echo '<p class="signuperror">'.ucfirst($lang_usernotfound).'</p>';
              break;
            case "wrongpwd":
                echo '<p class="signuperror">'.ucfirst($lang_wrongpassword).'</p>';
              break;
            case "success":
                echo '<p class="signupsuccess">'.ucfirst($lang_errorsuccess).'</p>';
              break;
          }
        }
       ?>
       <form class="form-signup" action="includes/login.inc.php" method="post">
         <input type="text" name="email" placeholder="<?php echo ucfirst($lang_email); ?>" <?php if (isset($_GET['email'])) echo 'value="'.$_GET['email'].'"' ?>>
         <input type="password" name="password" placeholder="<?php echo ucfirst($lang_password); ?>">
         <button type="submit" name="login-submit"><?php echo strtoupper($lang_login); ?></button>
         <a class="signup-button" href="signup.php"><?php echo ucfirst($lang_signup); ?></a>
       </form>

     </section>
   </div>
 </main>

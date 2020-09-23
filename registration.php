<?php
  $page = 'registration';
  require "header.php";
  require_once('classes/Register.php');
  $R = GetRegister($_SESSION['id']);
?>
  <h1><?php echo mb_strtoupper($lang_registrationcenter); ?></h1>
  <form class="registration-form" action="includes/register.inc.php" method="post">
    <div class="row-register">

      <div class="box-register">
        <div class="label-register">
          <p><?php echo strtoupper($lang_initialbank); ?></p>
        </div>
        <input class="box-register-input" id="initialBank" type="text" name="initial" value="<?php echo $R->initial; ?>">
      </div>

      <div class="box-register">
        <div class="label-register">
          <p><?php echo strtoupper($lang_initialdate); ?></p>
        </div>
        <div class="date">
          <input id="dateday" class="dateday" type="text" name="dateday" value="<?php echo $R->GetRegisterDay(); ?>">
          <p class="datebarra">/</p>
          <input id="datemonth" class="datemonth" type="text" name="datemonth" value="<?php echo $R->GetRegisterMonth(); ?>">
          <p class="datebarra">/</p>
          <input id="dateyear" class="dateyear" type="text" name="dateyear" value="<?php echo $R->GetRegisterYear(); ?>">
        </div>
      </div>

    </div>
    <div class="row-register">

      <div class="box-register">
        <div class="label-register">
          <p><?php echo strtoupper($lang_percentstake); ?></p>
        </div>
        <input class="box-register-input" id="stake" type="text" name="stake" value="<?php echo $R->stake; ?>">
      </div>

      <div class="box-register">
        <div class="label-register">
          <p><?php echo strtoupper($lang_unity); ?></p>
        </div>
        <div class="unity">
          <p id="unity" ><?php echo $R->initial * $R->stake / 100; ?></p>
        </div>


        <div class="radiounity-div">
          <input id="radiounity-variable-label" class="radiounity-input" type="radio" name="unitytype" value="0" <?php if ($R->unitytype == 0) echo 'checked'; ?>>
          <label id="radiounity-variable" class="radiounity-label"><?php echo ucwords($lang_fixed); ?></label>
          <input id="radiounity-fixed-label" class="radiounity-input" type="radio" name="unitytype" value="1" <?php if ($R->unitytype == 1) echo 'checked'; ?>>
          <label id="radiounity-fixed" class="radiounity-label"><?php echo ucwords($lang_variable); ?></label>
        </div>

      </div>

    </div>
    <button id="button-register" class="button-register" type="submit" name="register-submit"><?php echo mb_strtoupper($lang_save); ?></button>
  </form>

<?php
  require "footer.php";
?>


<h1>
  <?php echo ucfirst($lang_welcome).", ".$_SESSION['firstname']." ".$_SESSION['surname']."!";  ?>
</h1>
<p class="indexparagraph">
  <?php echo ucfirst($lang_yourcreditsexpiresat).": ".substr($_SESSION['expire'], 8, 2).'/'.substr($_SESSION['expire'], 5, 2).'/'.substr($_SESSION['expire'], 0, 4)."!" ?>
</p>

<?php
  if ($_SESSION['email'] == 'root') {
    ?>
    <button class="button-admin"><a class="aadm" href="admin.php">ADMIN</a></button>

    <?php
  }

 ?>

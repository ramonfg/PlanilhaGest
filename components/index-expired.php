
<h1>
  <?php echo ucfirst($lang_welcome).", ".$_SESSION['firstname']." ".$_SESSION['surname']."!";  ?>
</h1>
<p class="indexparagraph">
  <?php echo ucfirst($lang_yourcreditsexipiredon).": ".substr($_SESSION['expire'], 8, 2).'/'.substr($_SESSION['expire'], 5, 2).'/'.substr($_SESSION['expire'], 0, 4)."!" ?>
</p>
<p class="indexparagraph">
  <?php echo ucfirst($lang_contactustoaddmorecredits)."!" ?>
</p>

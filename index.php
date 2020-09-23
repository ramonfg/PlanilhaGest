<?php
  $page = 'index';
  require "header.php";
?>

      <section class="section-default">
      <?php
        if (isset($_SESSION['id'])) {
          if ($expired) {
            require_once('components/index-expired.php');
          } else {
            require_once('components/index-loggedin.php');
          }
        } else {
          require_once('components/index-loggedout.php');
        }
       ?>
      </section>

<?php
  require "footer.php";
?>

<?php

  $page = 'adm';
  require "header.php";
  if (!isset($_SESSION['id']) || $_SESSION['email'] != 'root') {
    header("Location: index.php");
    exit();
  }

  require_once('classes/Credit.php');
  $today = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
  $today = $today->format('Y-m-d H:i:s');

  if(!isset($_GET['filtermonth'])) {
    $filtermonth = $today;
  } else {
    $filtermonth = $_GET['filtermonth'];
  }
  $credits = GetCreditsByMonth(substr($filtermonth, 0, 4), substr($filtermonth, 5, 2));
?>
<section class="section-default">
  <h1>Adicionar Créditos</h1>
  <?php
    if (isset($_GET['error']) && isset($_GET['form'])){
      if ($_GET['error'] == 'success' && $_GET['form'] == 'addcredits') {
        ?>
          <p class="add-credit-success">Creditado com sucesso!</p>
        <?php
      }
    }
   ?>

  <div class="form-adm">
    <form action="includes/add-credits.php" method="post">

      <input id="addcredits-email"
      <?php if(isset($_GET['error']) && isset($_GET['form'])){
        if( ($_GET['error'] == 'nouser') || ($_GET['error'] == 'emptyfields' && $_GET['email'] == '') && $_GET['form'] == 'addcredits' ){
          echo 'class="redBorder"';
        }
      }
      ?>
      type="text"
      name="email"
      value="<?php
      if (isset($_GET['error']) && isset($_GET['form']) && isset($_GET['email'])) {
        if ($_GET['form'] == 'addcredits') echo $_GET['email'];
      }

      ?>"
      placeholder="email">

      <input id="addcredits-months"
      <?php if(isset($_GET['error']) && isset($_GET['form'])){
        if(($_GET['error'] == 'invalidmonths') || ($_GET['error'] == 'emptyfields' && $_GET['months'] == '') && $_GET['form'] == 'addcredits'){
          echo 'class="redBorder"';
        }
      }
      ?>
      type="text"
      name="months"
      value="<?php
        if (isset($_GET['error']) && isset($_GET['form']) && isset($_GET['months'])) {
          if ($_GET['form'] == 'addcredits') echo $_GET['months'];
        }
      ?>"
      placeholder="Meses">

      <button type="submit" name="add-credits-submit">Creditar</button>
    </form>
  </div>

  <form class="form-filter-credits" action="includes/filter-credits.inc.php" method="post">
    <input type="text" name="month" placeholder="MÊS" value="<?php echo substr($filtermonth, 5, 2); ?>">
    <input type="text" name="year" placeholder="ANO" value="<?php echo substr($filtermonth, 0, 4); ?>">
    <button type="submit" name="filter-credits-submit">BUSCAR</button>
  </form>

  <table class="bets-daily">
    <tr>
      <th><?php echo 'EMAIL'; ?></th>
      <th><?php echo 'MESES'; ?></th>
      <th><?php echo 'DATA'; ?></th>
    </tr>
    <?php for ($i=0; $i < count($credits); $i++) { ?>
      <tr>
        <td><?php echo $credits[$i]->email; ?></td>
        <td><?php echo $credits[$i]->months; ?></td>
        <td><?php echo $credits[$i]->GetDate(); ?></td>
      </tr>
    <?php } ?>

  </table>

</section>
<?php
  require "footer.php";
?>

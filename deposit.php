<?php
  $page = 'deposit';
  require "header.php";
  require_once('classes/Deposit.php');
  $deposits = GetDepositsByUser($_SESSION['id']);

  $totalDeposits = 0;
  $totalWithdraw = 0;
  for ($i=0; $i < count($deposits); $i++) {
    if ($deposits[$i]->operation == "0") {
      $totalDeposits += $deposits[$i]->value;
    } else {
      $totalWithdraw += $deposits[$i]->value;
    }
  }

?>

  <h1><?php echo mb_strtoupper($lang_depositcenter); ?></h1>

  <table class="table-totdeposit">
    <tr>
      <td><?php echo mb_strtoupper($lang_deposits); ?></td>
      <td><?php echo $totalDeposits ?></td>
    </tr>
    <tr>
      <td><?php echo mb_strtoupper($lang_withdraws); ?></td>
      <td><?php echo $totalWithdraw ?></td>
    </tr>
    <tr>
      <td><?php echo mb_strtoupper($lang_finalBank); ?></td>
      <td
      <?php
        if ($totalDeposits - $totalWithdraw > 0) echo 'class="colorgreen"';
        else echo 'class="colorred"';
      ?>>
        <?php echo $totalDeposits - $totalWithdraw ?>
      </td>
    </tr>
  </table>


<div class="div-table">
  <table class="table-deposit">
    <tr class="table-deposit-row">
      <th><?php echo mb_strtoupper($lang_date); ?></th>
      <th><?php echo mb_strtoupper($lang_operation); ?></th>
      <th><?php echo mb_strtoupper($lang_transfermethod); ?></th>
      <th><?php echo mb_strtoupper($lang_value); ?></th>
      <th></th>
    </tr>
    <?php for ($i=0; $i < count($deposits); $i++) { ?>
        <tr class="table-deposit-row">
          <td><?php echo $deposits[$i]->GetDate(); ?></td>
          <td>
            <?php
              if ($deposits[$i]->operation == "0") {
                echo mb_strtoupper($lang_deposit);
              } else {
                echo mb_strtoupper($lang_withdraw);
              }
            ?>
          </td>
          <td><?php echo $deposits[$i]->method; ?></td>
          <td><?php echo $deposits[$i]->value; ?></td>
          <td>
            <form class="" action="includes/delete-deposit.inc.php" method="post">
              <input style="display: none;" type="text" name="id-delete" value="<?php echo $deposits[$i]->id; ?>">
              <button class="delete-deposit" type="submit" name="delete-deposit-submit">X</button>
            </form>
          </td>
        </tr>
        <?php
      }
     ?>
  </table>
</div>

<form id="form-addDeposit" class="form-addDeposit" action="includes/add-deposit.inc.php" method="post">
  <div class="date-deposit">
    <input id="dateday-deposit" class="dateday-deposit" type="text" name="dateday" placeholder="<?php echo mb_strtoupper($lang_dd); ?>">
    <p class="datebarra-deposit">/</p>
    <input id="datemonth-deposit" class="datemonth-deposit" type="text" name="datemonth" placeholder="<?php echo mb_strtoupper($lang_mm); ?>">
    <p class="datebarra-deposit">/</p>
    <input id="dateyear-deposit" class="dateyear-deposit" type="text" name="dateyear" placeholder="<?php echo mb_strtoupper($lang_yyyy); ?>">
  </div>

  <select id="operation-deposit" class="operation-deposit" name="operation" form="form-addDeposit">
    <option value="0"><?php echo mb_strtoupper($lang_deposit); ?></option>
    <option value="1"><?php echo mb_strtoupper($lang_withdraw); ?></option>
  </select>
  <input id="method-deposit" class="method-deposit" type="text" name="method" placeholder="<?php echo mb_strtoupper($lang_transfermethod); ?>">
  <input id="value-deposit" class="value-deposit" type="text" name="value" placeholder="<?php echo mb_strtoupper($lang_value); ?>">

  <button id="deposit-submit" class="deposit-submit" type="submit" name="deposit-submit" disabled="true">+</button>
</form>




<?php
  require "footer.php";
?>

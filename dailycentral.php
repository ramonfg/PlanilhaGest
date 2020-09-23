<?php
  $page = 'dailycentral';
  require "header.php";
  require_once('classes/Register.php');
  require_once('classes/Bet.php');

  //days after the initial
  if (isset($_GET['date'])) {
    $date = $_GET['date'];
  } else {
    $date = 1;
  }

  $bets = GetBetsByUser($_SESSION['id'], $date);

  //real day
  $R = GetRegister($_SESSION['id']);
  $datebets = new DateTime($R->date, new DateTimeZone('America/Sao_Paulo'));
  date_add($datebets, date_interval_create_from_date_string(($date - 1).' days'));

  $daybank =  GetBankDay($_SESSION['id'], $date, $R->initial, $R->stake, $R->unitytype);
  if ($R->unitytype == 0) {
    $unity = $R->initial * $R->stake / 100;
  } else {
    $unity = $daybank * $R->stake / 100;
  }
  $dayResult = 0;
  for ($i=0; $i < count($bets); $i++) {
    switch ($bets[$i]->result) {
      case 1:
        $dayResult += $unity * $bets[$i]->units * ($bets[$i]->odds - 1);
        break;
      case 2:
        $dayResult -= $unity * $bets[$i]->units;
        break;
    }
  }

?>

<h1><?php echo mb_strtoupper($lang_dailycentral); ?></h1>

<div class="infos-daily">

  <div class="div-1third-daily">
    <div class="div-info-daily">

      <p class="div2-daily"><?php echo mb_strtoupper($lang_daybank); ?></p>
      <p class="div2-daily"><?php echo $datebets->format('d/m/Y'); ?></p>

      <p class="div1-daily"><?php echo sprintf('%0.2f', round($daybank, 2)); ?></p>

      <p class="div2-daily"><?php echo mb_strtoupper($lang_unity); ?></p>
      <p class="div2-daily"><?php echo sprintf('%0.2f', round($unity, 2)); ?></p>

    </div>
  </div>

  <div class="div-1third-daily">
    <div class="day-box-daily">
      <?php
        if ($date > 1) {
          ?>
            <a href="dailycentral.php?date=<?php echo $date-1; ?>" class="day-minus-daily">-</a>
          <?php
        }
      ?>
      <?php
        if ($date <= 1) {
          ?>
            <p class="day-minus-daily">-</p>
          <?php
        }
      ?>
      <form id="form-change-day" style="display:none;" action="includes/change-day.inc.php" method="post">
        <button id="change-day-submit" type="submit" name="change-day-submit"></button>
      </form>
      <input form="form-change-day" id="day-number-daily" name="day" class="day-number-daily" value="<?php echo $date ?>"></input>

      <a href="dailycentral.php?date=<?php echo $date+1; ?>" class="day-plus-daily">+</a>
    </div>
  </div>

  <div class="div-1third-daily">
    <div class="div-info2-daily">
      <p class="div1-daily"><?php echo mb_strtoupper($lang_dayresult); ?></p>

      <p class="div2-daily"><?php echo sprintf('%0.2f', round($daybank + $dayResult, 2)); ?></p>

      <p class="div1-daily"><?php echo mb_strtoupper($lang_profitoverbank); ?></p>

      <p class="div2-daily"><?php if($dayResult > 0) echo '+';  ?><?php echo sprintf('%0.2f', round($dayResult, 2)); ?></p>
      <p class="div2-daily">
        <?php
        if ($daybank == 0) echo sprintf('%0.2f', 0, 2);
        else echo sprintf('%0.2f', round($dayResult * 100 / $daybank, 2)); ?>
        %</p>
    </div>
  </div>

</div>

<table class="bets-daily">
  <tr>
    <th><?php echo mb_strtoupper($lang_sport); ?></th>
    <th><?php echo mb_strtoupper($lang_strategy); ?></th>
    <th><?php echo mb_strtoupper($lang_confront); ?></th>
    <th><?php echo mb_strtoupper($lang_units); ?></th>
    <th><?php echo mb_strtoupper($lang_betvalue); ?></th>
    <th><?php echo mb_strtoupper($lang_odds); ?></th>
    <th><?php echo mb_strtoupper($lang_expectedreturn); ?></th>
    <th><?php echo mb_strtoupper($lang_result); ?></th>
    <th><?php echo mb_strtoupper($lang_profitloss); ?></th>
    <th></th>
  </tr>

  <?php for ($i=0; $i < count($bets); $i++) { ?>
  <tr>
    <td><?php echo $bets[$i]->sport ?></td>
    <td><?php echo $bets[$i]->strategy ?></td>
    <td><?php echo $bets[$i]->confront ?></td>
    <td><?php echo $bets[$i]->units ?></td>
    <td><?php echo $bets[$i]->units * $unity ?></td>
    <td><?php echo $bets[$i]->odds ?></td>
    <td><?php echo $bets[$i]->odds * $bets[$i]->units * $unity ?></td>
    <td>
      <form id="form-updateDeposit<?php echo $i?>" class="form-updateDeposit" action="includes/update-deposit.inc.php" method="post">
        <select id="select-bets<?php  echo $i?>"
          class="select-bets
            <?php
              if($bets[$i]->result == '1') echo 'colorgreen';
              elseif($bets[$i]->result == '2') echo 'colorred';
              else echo 'colorblack';
            ?>
          "
          name="result" form="form-updateDeposit<?php echo $i?>">
          <option value="0" class="colorblack"<?php if($bets[$i]->result == '0') echo 'selected="selected"' ?>>PUSH</option>
          <option value="1" class="colorgreen" <?php if($bets[$i]->result == '1') echo 'selected="selected"'; ?>>GREEN</option>
          <option value="2" class="colorred" <?php if($bets[$i]->result == '2') echo 'selected="selected" '; ?>>RED</option>
        </select>
        <input style="display: none" type="text" name="day" value="<?php echo $date; ?>">
        <input style="display: none;" type="text" name="id-update" value="<?php echo $bets[$i]->id; ?>">
        <button style="display: none;" id="update-bet-submit<?php echo $i?>" type="submit" name="update-bet-submit"></button>
      </form>
    </td>
    <td>
      <?php
        switch ($bets[$i]->result) {
          case '0':
            echo '';
            break;
          case '1':
            echo '+'.(($bets[$i]->odds-1) * $bets[$i]->units * $unity);
            break;
          case '2':
            echo '-'.($bets[$i]->units * $unity);
            break;
        }
      ?>
   </td>
    <td>
      <form class="" action="includes/delete-bet.inc.php" method="post">
        <input style="display: none;" type="text" name="id-delete" value="<?php echo $bets[$i]->id; ?>">
        <input style="display: none" type="text" name="day" value="<?php echo $date; ?>">
        <button class="delete-bet" type="submit" name="delete-bet-submit">X</button>
      </form>
    </td>
  </tr>
  <?php } ?>

</table>

<form id="form-addBet" class="form-addBet" action="includes/add-bet.inc.php" method="post">

  <input id="sport-bet" class="sport-bet" type="text" name="sport" placeholder="<?php echo mb_strtoupper($lang_sport); ?>">
  <input id="strategy-bet" class="strategy-bet" type="text" name="strategy" placeholder="<?php echo mb_strtoupper($lang_strategy); ?>">
  <input id="confront-bet" class="confront-bet" type="text" name="confront" placeholder="<?php echo mb_strtoupper($lang_confront); ?>">
  <input id="units-bet" class="units-bet" type="text" name="units" placeholder="<?php echo mb_strtoupper($lang_units); ?>">
  <input id="odds-bet" class="odds-bet" type="text" name="odds" placeholder="<?php echo mb_strtoupper($lang_odds); ?>">
  <input style="display: none" type="text" name="day" value="<?php echo $date; ?>">

  <button id="bet-submit" class="bet-submit" type="submit" name="bet-submit" disabled="false">+</button>

</form>

<?php
  require "footer.php";
?>

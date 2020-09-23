<?php

  class Bet {
    public $id;
    public $user;
    public $date;
    public $sport;
    public $strategy;
    public $confront;
    public $units;
    public $odds;
    public $result; //NONE = 0, GREEN = 1, RED = 2

  }

  function AddBet($user_bets, $date_bets, $sport_bets, $strategy_bets, $confront_bets, $units_bets, $odds_bets) {
    require 'dbh.inc.php';
    $sql = "INSERT INTO bets (user_bets, date_bets, sport_bets, strategy_bets, confront_bets, units_bets, odds_bets, result_bets) VALUES (?,?,?,?,?,?,?,'0');";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      return false;
    } else {
      mysqli_stmt_bind_param($stmt, "sisssdd", $user_bets, $date_bets, $sport_bets, $strategy_bets, $confront_bets, $units_bets, $odds_bets);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return true;
    }
  }

  function GetBetsByUser($user, $date) {
    require 'includes/dbh.inc.php';
    $sql = "SELECT * FROM bets WHERE user_bets = ? AND date_bets = ?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $user, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $BetsList = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $B = new Bet();
      $B->id = $row['id_bets'];
      $B->user = $row['user_bets'];
      $B->date = $row['date_bets'];
      $B->sport = $row['sport_bets'];
      $B->strategy = $row['strategy_bets'];
      $B->confront = $row['confront_bets'];
      $B->units = $row['units_bets'];
      $B->confront = $row['confront_bets'];
      $B->odds = $row['odds_bets'];
      $B->result = $row['result_bets'];
      array_push($BetsList, $B);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $BetsList;
  }

  function DeleteBet($user, $id) {
    require 'dbh.inc.php';
    $sql = "DELETE FROM bets WHERE id_bets = ? AND user_bets = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      return false;
    } else {
      mysqli_stmt_bind_param($stmt, "is", $id, $user);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return true;
    }
  }

  function UpdateBet($user, $id, $result) {
    require 'dbh.inc.php';
    $sql = "UPDATE bets SET result_bets = ? WHERE id_bets = ? AND user_bets = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      return false;
    } else {
      mysqli_stmt_bind_param($stmt, "iis", $result, $id, $user);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return true;
    }
  }

  function GetBankDay($user, $date, $initial, $stake, $unitytype) {
    $bank = $initial;
    for ($i=1; $i < $date; $i++) {
      $bank += GetResultDay($user, $i, $initial, $stake, $unitytype, $bank);
    }
    return $bank;
  }

  function GetResultDay($user, $date, $initial, $stake, $unitytype, $dayinitial) {
    require 'includes/dbh.inc.php';
    $sql = "SELECT
              CASE
                  WHEN bets.result_bets = 0 THEN 0
                  WHEN bets.result_bets = 1 THEN ( ? * ? / 100) * bets.units_bets * (bets.odds_bets - 1)
                  WHEN bets.result_bets = 2 THEN -( ? * ? / 100) * bets.units_bets
              END AS val
            FROM bets
            WHERE user_bets = ? AND date_bets = ?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    if($unitytype == 0) {
      mysqli_stmt_bind_param($stmt, "ddddii", $initial, $stake, $dayinitial, $stake, $user, $date);
    } else {
      mysqli_stmt_bind_param($stmt, "ddddii", $dayinitial, $stake, $dayinitial, $stake, $user, $date);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $value = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $value += $row['val'];
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $value;
  }























  //

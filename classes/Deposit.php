<?php

    class Deposit {
      public $id;
      public $user;
      public $date;
      public $operation; //DEPOSIT = 0, 1 = WITHDRAW
      public $method;
      public $value;

      function GetDate() {
            return substr($this->date, 8, 2).'/'.substr($this->date, 5, 2).'/'.substr($this->date, 0, 4);
      }

    }

    function AddDeposit($user_deposits, $date_deposits, $operation_deposits, $method_deposits, $value_deposits) {
      require 'dbh.inc.php';
      $sql = "INSERT INTO deposits (user_deposits, date_deposits, operation_deposits, method_deposits, value_deposits) VALUES (?,?,?,?,?);";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
      } else {
        mysqli_stmt_bind_param($stmt, "ssssd", $user_deposits, $date_deposits, $operation_deposits, $method_deposits, $value_deposits);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return true;
      }
    }

    function GetDepositsByUser($user) {
      require 'includes/dbh.inc.php';
      $sql = "SELECT * FROM deposits WHERE user_deposits = ? ORDER BY date_deposits;";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "s", $user);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      $DepositsList = [];
      while ($row = mysqli_fetch_assoc($result)) {
        $D = new Deposit();
        $D->id = $row['id_deposits'];
        $D->user = $row['user_deposits'];
        $D->date = $row['date_deposits'];
        $D->operation = $row['operation_deposits'];
        $D->method = $row['method_deposits'];
        $D->value = $row['value_deposits'];
        array_push($DepositsList, $D);
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return $DepositsList;
    }

    function DeleteDeposit($user, $id) {
      require 'dbh.inc.php';
      $sql = "DELETE FROM deposits WHERE id_deposits = ? AND user_deposits = ?;";
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

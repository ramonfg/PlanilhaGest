<?php

  class Register {
    public $user;
    public $initial;
    public $date;
    public $stake;
    public $unitytype; //FIXED = 0, VARIABLE = 1

    function GetRegisterDay() {
      return substr($this->date, 8, 2);
    }

    function GetRegisterMonth() {
      return substr($this->date, 5, 2);
    }

    function GetRegisterYear() {
      return substr($this->date, 0, 4);
    }

    function GetDate() {
          return substr($this->date, 8, 2).'/'.substr($this->date, 5, 2).'/'.substr($this->date, 0, 4);
    }

  }

  function GetRegister($user_registers) {
    require 'includes/dbh.inc.php';
    $sql = "SELECT * FROM registers WHERE user_registers = ?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_registers);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      $R = new Register();
      $R->user = $row['user_registers'];
      $R->initial = $row['initial_registers'];
      $R->date = $row['date_registers'];
      $R->stake = $row['stake_registers'];
      $R->unitytype = $row['unitytype_registers'];

      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return $R;
    }
  }

  function UpdateRegister($user_registers, $initial_registers, $date_registers, $stake_registers, $unitytype_registers) {
    require 'dbh.inc.php';
    $sql = "UPDATE registers
            SET initial_registers = ?, date_registers = ?, stake_registers = ?, unitytype_registers = ?
            WHERE user_registers = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      return false;
    } else {
      mysqli_stmt_bind_param($stmt, "dsdii", $initial_registers, $date_registers, $stake_registers, $unitytype_registers, $user_registers);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return true;
    }
  }

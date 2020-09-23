<?php

  class User {
    public $id;
    public $email;
    public $phone;
    public $firstName;
    public $surname;
    public $password;
    public $expire;
  }


  function AddUser($firstName_users, $surname_users, $email_users, $password_users, $phone_users) {
    require 'dbh.inc.php';

    $sql = "INSERT INTO users (email_users, phone_users, firstName_users, surname_users, password_users, expire_users) VALUES (?,?,?,?,?,'2020-11-01');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      return false;
    } else {
      $hashedPwd = password_hash($password_users, PASSWORD_DEFAULT);
      mysqli_stmt_bind_param($stmt, "sssss", $email_users, $phone_users, $firstName_users, $surname_users, $hashedPwd);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      AddRegister(GetIdByEmail($email_users));
      return true;
    }
  }

  function AddRegister($id) {
    require 'dbh.inc.php';

    $sql = "INSERT INTO registers (user_registers, initial_registers, date_registers, stake_registers, unitytype_registers) VALUES (?,0,'2020-01-01',0,0);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      return false;
    } else {
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return true;
    }
  }

  function IsEmailTaken($email_users) {
    require 'dbh.inc.php';

    $sql = "SELECT email_users FROM users WHERE email_users = ?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email_users);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultCheck = mysqli_stmt_num_rows($stmt);
    if ($resultCheck > 0) {
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return true;
    } else {
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return false;
    }

  }

  function Login($email_users, $password_users) {
    require 'dbh.inc.php';

    $sql = "SELECT id_users, email_users, phone_users, firstName_users, surname_users, password_users, expire_users FROM users WHERE email_users = ?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email_users);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      $pwdCheck = password_verify($password_users, $row['password_users']);
      if (!$pwdCheck) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return "wrongpwd";
      } else {
        session_start();
        $_SESSION['id'] = $row['id_users'];
        $_SESSION['email'] = $row['email_users'];
        $_SESSION['phone'] = $row['phone_users'];
        $_SESSION['firstname'] = $row['firstName_users'];
        $_SESSION['surname'] = $row['surname_users'];
        $_SESSION['expire'] = $row['expire_users'];

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return "success";
      }
    } else {
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return "nouser";
    }
  }

  function GetIdByEmail($email) {
    require 'dbh.inc.php';

    $sql = "SELECT id_users FROM users WHERE email_users = ?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      return $row['id_users'];
    } else {
      return -1;
    }

  }

  function IsUserExpired($id) {
    require 'includes/dbh.inc.php';

    $sql = "SELECT expire_users FROM users WHERE id_users = ?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      $today = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $expire = date_create($row['expire_users']);
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return $expire <= $today;
    } else {
      return true;
    }
  }

  function AddCredits($email, $months) {
    require 'dbh.inc.php';
    $sql = "SELECT expire_users FROM users WHERE email_users = ?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      //Get the new date
      $today = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $expire = date_create($row['expire_users']);
      if ($expire <= $today) {
        date_add($today, date_interval_create_from_date_string(($months).' months'));
        $expire = $today;
      } else {
        date_add($expire, date_interval_create_from_date_string(($months).' months'));
      }
      mysqli_stmt_close($stmt);
      //Change the expire date
      $sql = "UPDATE users SET expire_users = ? WHERE email_users = ?;";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        return "sqlerror";
      } else {
        $expire = $expire->format('Y-m-d H:i:s');
        mysqli_stmt_bind_param($stmt, "ss", $expire, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        RegisterCredit($email, $months);
        return "success";
      }
    } else {
      return "nouser";
    }
  }

  function RegisterCredit($email, $months) {

    $id = GetIdByEmail($email);
    $today = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
    $today = $today->format('Y-m-d H:i:s');

    require 'dbh.inc.php';
    $sql = "INSERT INTO credits (user_credits, date_credits, months_credits) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      return false;
    } else {
      mysqli_stmt_bind_param($stmt, "isi", $id, $today, $months);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      return true;
    }
  }

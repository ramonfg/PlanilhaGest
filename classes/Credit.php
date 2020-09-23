<?php

  class Credit {
    public $id;
    public $user;
    public $date;
    public $months;

    function GetDate() {
          return substr($this->date, 8, 2).'/'.substr($this->date, 5, 2).'/'.substr($this->date, 0, 4);
    }
  }

  class CreditUser {
    public $email;
    public $date;
    public $months;

    function GetDate() {
          return substr($this->date, 8, 2).'/'.substr($this->date, 5, 2).'/'.substr($this->date, 0, 4);
    }

  }

  function GetCreditsByMonth($year, $month) {
    require 'includes/dbh.inc.php';
    $sql = "SELECT users.email_users, credits.date_credits, credits.months_credits
            FROM credits
            INNER JOIN users ON users.id_users = credits.user_credits
            WHERE TIMESTAMPDIFF(day, ?, date_credits) < TIMESTAMPDIFF(day, ?, ?)
            AND TIMESTAMPDIFF(day, ?, date_credits) >= 0
            ORDER BY credits.date_credits;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    $date = $year.'-'.$month.'-01';
    $firstdaynextmonth = GetFirstDayNextMonth($year, $month);
    mysqli_stmt_bind_param($stmt, "ssss", $date, $date, $firstdaynextmonth, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $CreditsList = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $C = new CreditUser();
      $C->email = $row['email_users'];
      $C->date = $row['date_credits'];
      $C->months = $row['months_credits'];
      array_push($CreditsList, $C);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $CreditsList;
  }

  function GetFirstDayNextMonth($year, $month){
    if($month == '12') {
      return ($year+1).'-01-01';
    } else {
      return $year.'-'.($month+1).'-01';
    }

  }

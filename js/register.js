$(document).ready(function(){
  var initialBank = $("#initialBank").val();
  var stake = $("#stake").val();
  var dateday = $("#dateday").val();
  var datemonth = $("#datemonth").val();
  var dateyear = $("#dateyear").val();

  $("#initialBank").on("change", CalcUnity);
  $("#stake").on("change", CalcUnity);
  $("#dateday").on("change", ValidateDate);
  $("#datemonth").on("change", ValidateDate);
  $("#dateyear").on("change", ValidateDate);


  function CalcUnity() {
    if($.isNumeric($("#initialBank").val())) {
      initialBank = $("#initialBank").val();
    } else {
      $("#initialBank").val(initialBank);
    }

    if($.isNumeric($("#stake").val())) {
      stake = $("#stake").val();
    } else {
      $("#stake").val(stake);
    }

    $("#unity").html(initialBank * stake / 100);
  }

  function ValidateDate() {
    //check if it is empty
    if ($("#dateday").val() == "" || $("#datemonth").val() == "" || $("#dateyear").val() == "") {
      classredborder(true);
      return;
    }

    //check if it is a number
    if($.isNumeric($("#dateday").val())) {
      dateday = parseInt($("#dateday").val());
    } else {
      $("#dateday").val(dateday);
    }
    if($.isNumeric($("#datemonth").val())) {
      datemonth = parseInt($("#datemonth").val());
    } else {
      $("#datemonth").val(datemonth);
    }
    if($.isNumeric($("#dateyear").val())) {
      dateyear = parseInt($("#dateyear").val());
    } else {
      $("#dateyear").val(dateyear);
    }

    //check if month exists
    if(datemonth > 12 || datemonth < 1) {
      classredborder(true);
      return;
    }

    //check if date exists
    if(dateday < 1) {
      classredborder(true);
      return;
    }

    switch (datemonth) {
      case 1:
      case 3:
      case 5:
      case 7:
      case 7:
      case 8:
      case 10:
      case 12:
        if (dateday > 31) {
          classredborder(true);
          return;
        }
        break;
      case 4:
      case 6:
      case 9:
      case 11:
        if (dateday > 30) {
          classredborder(true);
          return;
        }
        break;
      case 2:
        if(dateyear % 4 == 0) {
          if (dateday > 29) {
            classredborder(true);
            return;
          }
        } else {
          if (dateday > 28) {
            classredborder(true);
            return;
          }
        }
        break;
    }

    dateday = $("#dateday").val();
    datemonth = $("#datemonth").val();
    dateyear = $("#dateyear").val();
    classredborder(false);
  }

  /*add = true adiciona, add = false remove*/
  function classredborder(add){
    if (add) {
      $("#dateday").addClass("redBorder");
      $("#datemonth").addClass("redBorder");
      $("#dateyear").addClass("redBorder");
      $("#button-register").prop('disabled', true);
    } else {
      $("#dateday").removeClass("redBorder");
      $("#datemonth").removeClass("redBorder");
      $("#dateyear").removeClass("redBorder");
      $("#button-register").prop('disabled', false);
    }
  }

  $("#radiounity-fixed-label").on("click", ChangeType(0));
  $("#radiounity-variable-label").on("click", ChangeType(1));
  function ChangeType(type) {
    if(type == 0) {
      $("#radiounity-fixed").prop('checked', true);
      $("#radiounity-variable").prop('checked', false);
    } else {
      $("#radiounity-fixed").prop('checked', false);
      $("#radiounity-variable").prop('checked', true);
    }
  }

});

$(document).ready(function(){

  $("#dateday-deposit").on("change", ValidateDeposit);
  $("#datemonth-deposit").on("change", ValidateDeposit);
  $("#dateyear-deposit").on("change", ValidateDeposit);
  $("#operation-deposit").on("change", ValidateDeposit);
  $("#method-deposit").on("change", ValidateDeposit);
  $("#value-deposit").on("change", ValidateDeposit);

  function ValidateDeposit() {
    AddDateRedBorder(false);

    //Check if all fields are filled
    if (
      $("#dateday-deposit").val() == "" ||
      $("#datemonth-deposit").val() == "" ||
      $("#dateyear-deposit").val() == "" ||
      $("#operation-deposit").val() == "" ||
      $("#method-deposit").val() == "" ||
      $("#value-deposit").val() == ""
     ) {
      $("#deposit-submit").prop('disabled', true);
      return;
    }

    var submitRegisterDisabled = false;

    //check if the date is valid
    //check if it is a number
    if($.isNumeric($("#dateday-deposit").val()) && $.isNumeric($("#datemonth-deposit").val()) && $.isNumeric($("#dateyear-deposit").val())) {
      AddDateRedBorder(false);
    } else {
      AddDateRedBorder(true);
      submitRegisterDisabled = true;
    }

    var dateday_deposit = parseInt($("#dateday-deposit").val());
    var datemonth_deposit = parseInt($("#datemonth-deposit").val());
    var dateyear_deposit = parseInt($("#dateyear-deposit").val());

    //check if month exists
    if(datemonth_deposit > 12 || datemonth_deposit < 1) {
      AddDateRedBorder(true);
      submitRegisterDisabled = true;
    }

    //check if date exists
    if(dateday_deposit < 1) {
      AddDateRedBorder(true);
      submitRegisterDisabled = true;
    }

    switch (datemonth_deposit) {
      case 1:
      case 3:
      case 5:
      case 7:
      case 7:
      case 8:
      case 10:
      case 12:
        if (dateday_deposit > 31) {
          AddDateRedBorder(true);
          submitRegisterDisabled = true;
        }
        break;
      case 4:
      case 6:
      case 9:
      case 11:
        if (dateday_deposit > 30) {
          AddDateRedBorder(true);
          submitRegisterDisabled = true;
        }
        break;
      case 2:
        if(dateyear_deposit % 4 == 0) {
          if (dateday_deposit > 29) {
            AddDateRedBorder(true);
            submitRegisterDisabled = true;
          }
        } else {
          if (dateday_deposit > 28) {
            AddDateRedBorder(true);
            submitRegisterDisabled = true;
          }
        }
        break;
    }

    //check operation
    var operation_deposit = parseInt($("#operation-deposit").val());
    if(operation_deposit != 0 && operation_deposit != 1) {
      $("#operation-deposit").addClass("redBorder");
      submitRegisterDisabled = true;
    } else {
      $("#operation-deposit").removeClass("redBorder");
    }

    //check value
    if($.isNumeric($("#value-deposit").val())) {
      $("#value-deposit").removeClass("redBorder");
    } else {
      $("#value-deposit").addClass("redBorder");
      submitRegisterDisabled = true;
    }

    //set button enabled
    $("#deposit-submit").prop('disabled', submitRegisterDisabled);
  }

  function AddDateRedBorder(add) {
    if(add) {
      $("#dateday-deposit").addClass("redBorder");
      $("#datemonth-deposit").addClass("redBorder");
      $("#dateyear-deposit").addClass("redBorder");
      submitRegisterDisabled = true;
    } else {
      $("#dateday-deposit").removeClass("redBorder");
      $("#datemonth-deposit").removeClass("redBorder");
      $("#dateyear-deposit").removeClass("redBorder");
    }

  }

});

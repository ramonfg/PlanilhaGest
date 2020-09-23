$(document).ready(function(){

  $(".select-bets").change(function() {
    var n = $(this).prop('id');
    n = n.substr(11, n.length-11);
    $("#update-bet-submit"+n).click();
  });


  $("#sport-bet").on("change", ValidateBet);
  $("#strategy-bet").on("change", ValidateBet);
  $("#confront-bet").on("change", ValidateBet);
  $("#units-bet").on("change", ValidateBet);
  $("#odds-bet").on("change", ValidateBet);

  function ValidateBet() {

    var submitBetDisabled = false;
    //Check if all fields are filled
    if (
      $("#sport-bet").val() == "" ||
      $("#strategy-bet").val() == "" ||
      $("#confront-bet").val() == "" ||
      $("#units-bet").val() == "" ||
      $("#odds-bet").val() == ""
     ) {
      $("#bet-submit").prop('disabled', true);
      return;
    }

    if ($.isNumeric($("#units-bet").val())) {
      $("#units-bet").removeClass("redBorder");
    } else {
      submitBetDisabled = true;
      $("#units-bet").addClass("redBorder");
    }

    if ($.isNumeric($("#odds-bet").val())) {
      $("#odds-bet").removeClass("redBorder");
    } else {
      submitBetDisabled = true;
      $("#odds-bet").addClass("redBorder");
    }

    //set button enabled
    $("#bet-submit").prop('disabled', submitBetDisabled);

  }


  $("#day-number-daily").change(function() {
    if($.isNumeric($("#day-number-daily").val()) && $("#day-number-daily").val() > 0) {
        $("#change-day-submit").click();
    } else {
      $("#day-number-daily").val(1)
    }
  });

});

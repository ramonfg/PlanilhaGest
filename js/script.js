$(document).ready(function(){
  $("#lang").change(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      location.reload();
    };
    xmlhttp.open("GET", "ajax/lang.php?lang=" + $(this).val(), true);
    xmlhttp.send();
  });
});

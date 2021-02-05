let mora = "is"; 
function checkRows(){
  $.ajax({
    type: "POST",
    data: {},
    dataType: "text",
    url: "modal/shift.php?do=check",
    success: function(response) {
      mora = response;
    }
  });
}

$('#myShift').click(function(e){
  e.preventDefault();
  checkRows();
  let answer;
  setTimeout(function(){
    if(mora == 1){
      answer = confirm("Do u want to time out?");
      window.location.reload();
    }else{
      answer = confirm("Do u want to time in?");
    }
    if(answer == true){
      $.ajax({
        type: "POST",
        data: {},
        dataType: "text",
        url: "modal/shift.php?do=timeIn",
        success: function(response) {
        }
      });
      window.location.reload();
    }
  },500);
});

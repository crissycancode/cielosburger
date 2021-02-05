$(document).ready(function(){
  $("#submit").click(function(){
    const username = $("#username").val();
    const password = $("#password").val();

    if(username !== "" && password !==""){
      $.ajax({
        type: "POST",
        url: "main/modal/user.php?do=login",
        data: {password, username},
        dataType: "text",
        success: function(response) {
            console.log(response);
            window.location.reload();
        }
      });
    }else{
      alert("enter a valid username and password");
    }
  });
});
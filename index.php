  <?php session_start();  if (isset($_SESSION['logged_in']))  if($_SESSION['logged_in']== "true"){ 
    header("Location: main/index.php");
    exit;
  }   
include_once('main/connect.php');
 
?>
<!-- Refresher-->
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
  $(document).ready(function(){
    setInterval(function() {
      $("#refreshMoto").load("index.php #refreshMoto");
    }, 1000);
  });  
</script> 

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cielo's Burger System</title>
    <link rel="shortcut icon" href="main/assets/images/logo.png" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="main/assets/dist/css/AdminLTE.min.css">
  </head>
  <body class="hold-transition login-page"  style="background: url(main/assets/images/bgimage.jpg); height: 1000px; background-position: center;">
    <div class="login-box">
      <div class="login-box-body">
          <div class="login-logo">
              <img src="main/assets/images/logo.png" width="300px" height="300px" alt="">
          </div>
        <p class="login-box-msg">login</p>
        <form action="main/modal/user.php?do=login" method="post" class="text-center">
          <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="username" autofocus>
            <span class="form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password"   class="form-control" placeholder="password">
            <span class="form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4" style = "padding-left: 16px">
              <button type="submit" class="btn btn-primary btn-block btn-flat">login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html> 
<?php 
  session_start();  
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']== "true"){ 
    $_SESSION['start'] = time();
    header("Location: main/index.php");
  }   
  include_once('main/connect.php');
?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
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
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="main/assets/dist/css/AdminLTE.min.css">
  </head>
  <body class="hold-transition login-page"  style="background: url(main/assets/images/bgimage.jpg); height: 1000px; /* You must set a specified height */
    background-position: center; " >
    <div class="login-box">
      <div class="login-box-body">
        <div class="login-logo center">
          <img src="main/assets/images/logo.png" width="300px" height="300px" alt="">
        </div>
        <p class="login-box-msg">login</p>
          <div class="form-group has-feedback">
            <input id="username" type="text" name="username" class="form-control" placeholder="Username" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input id="password" type="password" name="password"   class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            </div>
            <div class="col-xs-4">
              <button id = "submit" type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
            </div>
          </div>
      </div>
    </div>

  <!-- jQuery 2.2.3 -->
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    
    <!-- Bootstrap 3.3.6 -->
    <!-- <script src="main/assets/bootstrap/js/bootstrap.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="index.js"></script>

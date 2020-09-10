<?php   if (isset($_SESSION['logged_in'])) if($_SESSION['logged_in']== "false"){
    header("Location: ../index.php");
    exit;
}  ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cielo's Burger System</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <!-- daterange picker -->
    <!-- <link rel="stylesheet" href="assets/bower_components/bootstrap-daterangepicker/daterangepicker.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
    
    <!-- date picker -->
    <!-- <link rel="stylesheet" href="assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- color picker -->
    <!-- <link rel="stylesheet" href="assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css">

    <!-- time picker -->
    <!-- <link rel="stylesheet" href="assets/plugins/timepicker/bootstrap-timepicker.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css">

    <!-- icheck -->
    <!-- <link rel="stylesheet" href="assets/plugins/iCheck/all.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.css">

    <!-- Select2 -->
    <!-- <link rel="stylesheet" href="assets/bower_components/select2/dist/css/select2.min.css"> -->

    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">

    <!--Refresh JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>


    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>


<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">



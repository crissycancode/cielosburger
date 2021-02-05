<?php
if(isset($_GET['do']) && $_GET['do']=='update'){
  $mission = $_POST['mission'];
  $vision = $_POST['vision'];
  $termsCondi = $_POST['termsCondi'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  $aboutUs = $_POST['aboutUs'];
  $quotation = $_POST['quotation'];
  $email = $_POST['email'];

  $q = $db->prepare("UPDATE tbl_companyinfo set mission='$mission',vision='$vision',termsCondi='$termsCondi',contact='$contact',address='$address',aboutUs='$aboutUs',quotation='$quotation',email='$email'  WHERE id='1'");
  $q->execute(array());
  $message = "Information successfully updated.";
  echo "<script type='text/javascript'>alert('$message');window.location.href='../cms.php';</script>";
  exit();
}

$result = $db->prepare("SELECT  * FROM tbl_companyinfo");
$result->execute();
for($i=0; $row = $result->fetch(); $i++){  
	$_SESSION['address'] = $row['address'];		
	$_SESSION['profile'] = $row['profile']; 
	$_SESSION['aboutUs'] = $row['aboutUs']; 
	$_SESSION['termsCondi'] = $row['termsCondi'];  
	$_SESSION['quotation'] = $row['quotation'];  
	$_SESSION['mission'] = $row['mission']; 
	$_SESSION['vision'] = $row['vision'];		
	$_SESSION['aboutIntro'] = $row['aboutIntro'];	
	$_SESSION['contact'] = $row['contact'];	   
	$_SESSION['bannerImg'] = $row['bannerImg'];	
	$_SESSION['email'] = $row['email'];	 
	$_SESSION['mapFrame'] = $row['mapFrame'];	 
	$_SESSION['name'] = $row['name'];  
	
}?>	
<?php 
// error_reporting(0);
  if(!isset($_SESSION)){  
//     session_save_path("/home/a7440484/public_html/tmp");
// 	ini_set("session.gc_maxlifetime", 3600);
// 	ini_set("session.gc_probability", 100);
// 	session_start();
// 	$session_life = ini_get("session.gc_maxlifetime");
// 	$session_path = session_save_path();
    session_start();  
    $message = session_id();
    // echo "<script type='text/javascript'>alert('$message');</script>";
  }

  date_default_timezone_set('Asia/Manila');
  $dt =  date('Y-m-d h:i:s'); 
  $dtNow =  date('Y-m-d '); 
    
  // $db_host		= 'localhost';
  // $db_user		= 'root';
  // $db_pass		= '';
  // $db_database	= 'cielosburger';

  $db_host		= 'localhost';
  $db_user		= 'id15695597_iamgroot';
  $db_pass		= 'ItQqxSZiF(Y9)Vix';
  $db_database	= 'id15695597_cielosburger';

  $db = new PDO('mysql:host='.$db_host.';dbname='.$db_database, $db_user, $db_pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  

  date_default_timezone_set('Asia/Manila'); 
  $dt = date('Y-m-d H:i:s');
?>

<?php 
// if (isset($_SESSION['timer'])) {
// 	echo$_SESSION['timer'];
// } else {
//    $_SESSION['timer']= $_SESSION['timer']+1;
//    echo$_SESSION['timer'];
// }
?>

<?php 
error_reporting(0);
 if(!isset($_SESSION))   {    session_start();   }
 
date_default_timezone_set('Asia/Manila');
	$dt =  date('Y-m-d h:i:s'); 
	$dtNow =  date('Y-m-d '); 

// if(time()-$_SESSION['time']>20) {
// unset($_SESSION['time']);

// $message = "Database Backup created.";
// 		echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
// 	 } 
// else {
// $_SESSION['time']=time();//updating with latest timestamp
// echo$_SESSION['time'];
// }




// $db_user		= 'u232330628_cielosburger';
// $db_pass		= 'imBlessed@01';
// $db_database	= 'u232330628_cielosburger';


// $db_host		= 'localhost';
// $db_user		= 'root';
// $db_pass		= '';
// $db_database	= 'posinventorydb';

$db_host		= 'us-cdbr-east-02.cleardb.com';
$db_user		= 'b2634379364e1b';
$db_pass		= 'bbf68665';
$db_database	= 'heroku_52fda23290501af';


$db = new PDO('mysql:host='.$db_host.';dbname='.$db_database, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


date_default_timezone_set('Asia/Manila'); 
$dt = date('Y-m-d H:i:s');

  function getCommission($totalSales){
    $fix_salary='260';
    if ($totalSales >=8801 ){
        $commission= number_format($totalSales*.1+$fix_salary,2);
    }elseif($totalSales>=1000){
        $commission= number_format($totalSales*.07+$fix_salary,2);
    }else{
        $commission=  number_format(0,2);
        // echo number_format($fix_salary,2);
    }

    return  $commission;
}
?>

<!--  <script>
  $(document).ready(function(){
    setInterval(function() {
      $("#refreshMoto").load("connect.php #refreshMoto");
    }, 1000);
  });
</script>

 
<?php if (isset($_SESSION['timer'])) {
	echo$_SESSION['timer'];
} else {
   $_SESSION['timer']= $_SESSION['timer']+1;
   echo$_SESSION['timer'];
} ?>  -->

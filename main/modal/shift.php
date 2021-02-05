<?php 
  include_once('../connect.php'); 
  if($_GET['do'] == 'timeIn'){
    $time = time();
    $time = date("Y-m-d H:i:s",$time);
    $duration;
    $rows;
      //check if there is a shift that is not logged out before creating new shift
      $result_category = $db->prepare("SELECT COUNT(1) FROM tbl_shift WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL ORDER BY ID DESC LIMIT 1");
      $result_category->execute();
      for ($i = 1; $row = $result_category->fetch(); $i++) {
        $rows = $row[0];
      }
      if($rows == 0){
        $result_category = $db->prepare("INSERT INTO tbl_shift(employeeId, employeeName, startShift) VALUES (?,?,?)");
        $result_category->execute(array($_SESSION['userID'], "employee name", $time));

        $result = $db->prepare("SELECT * FROM tbl_shift WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL ORDER BY ID DESC LIMIT 1");
        $result->execute();
        if($row = $result->fetch()){
          $_SESSION['timedin'] = $row[3];
        }

        $result = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `dt`, `action`) VALUES ('".$_SESSION['userID']."','".$time."','Time-In')");
        $result->execute(array());

        echo 'true';
      }

      if($rows != 0){
        $result_category = $db->prepare("SELECT * FROM tbl_shift WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL ORDER BY ID DESC LIMIT 1");
        $result_category->execute();
        for ($i = 1; $row = $result_category->fetch(); $i++) {
          $duration = strtotime($time) - strtotime($row[3]);
        }

        $result = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `dt`, `action`) VALUES ('".$_SESSION['userID']."','".$time."','Time-Out')");
        $result->execute(array());

        $result_category = $db->prepare("UPDATE tbl_shift SET endShift='".$time."', duration='".$duration."' WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL");
        $result_category->execute();
        $_SESSION['timedin'] = "";

        echo 'false';
        header("location: ../index.php");
      } 
      exit();
  }

  if($_GET['do'] == 'check'){
    $result_category = $db->prepare("SELECT COUNT(1) FROM tbl_shift WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL ORDER BY ID DESC LIMIT 1");
    $result_category->execute();
    for ($i = 1; $row = $result_category->fetch(); $i++) {
      echo $row[0];
    }
  }
?>
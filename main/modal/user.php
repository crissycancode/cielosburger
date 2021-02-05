<?php
  include_once('../connect.php');
//   date_default_timezone_set('Asia/Manila');
//   $dt = date('Y-m-d h:i:s');
//   $dtl = date('Y-m-d h:i:sa');

//auto logout
//   if(!isset($userID)){
//     $_SESSION['logged_in'] = "false";
//     session_destroy();
//     echo "<script type='text/javascript'>window.location.replace('http://www.cielosburger.online');</script>";
//     exit();
//   }
 
// user login
  if($_GET['do'] == 'login'){ 
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $dashofsalt = "randomkindofburger";
    $password = md5($dashofsalt.$password);
    $password = sha1($password);
    $password = crypt($password,$dashofsalt);
    
    $_SESSION['att'] = 0; //maybe should delete
    
    $result = $db->prepare("SELECT * , CONCAT(fname,' ',lname) fullname FROM tbl_users WHERE username = '$username' AND password = '$password'");
    $result->execute();
    
    if($row = $result->fetch()){ 
        if($row['active'] == 'inactive'){
          sessionAttempts($db);
          echo "The account your are trying to access is inactive. Please contact your administrator to activate the account. \r\n" ;
        }else{
            $_SESSION['logged_in'] = "true";
            $_SESSION['userID'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['pic'] = $row['pic'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['userNo'] = $row['userNo'];
            $_SESSION['timedin'] = "";
            $_SESSION['shiftCode'] = 0;
            $userId = $row['id'];
            
            $result = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `action`) VALUES ('$userId','logged in')");
            $result->execute(array());
            
            if($row['role'] =="admin"){
              $_SESSION['timedin'] = "admin";
            }else{
                $result = $db->prepare("SELECT * FROM tbl_shift WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL ORDER BY ID DESC LIMIT 1");
                $result->execute();
                if($row = $result->fetch()){
                    $_SESSION['timedin'] = $row[3];
                    $_SESSION['shiftCode'] = $row[0];
                }
            }
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $sql = "DELETE FROM tbl_attempts WHERE ipaddress='$ipaddress'";
            $q = $db->prepare($sql);
            $q->execute(array());
            exit();
        }
    }else{
      echo "please enter a valid username and password. \r\n" ;
      sessionAttempts($db);
    }
  } //end of login 
  
  function sessionAttempts($db){
      $ipaddress = $_SERVER['REMOTE_ADDR'];
      $result = $db->prepare("INSERT INTO tbl_attempts(ipaddress, numberofattempts) VALUES ('$ipaddress',1) ON DUPLICATE KEY UPDATE numberofattempts = numberofattempts+1");
      $result->execute(array());
        
      $result = $db->prepare("SELECT numberofattempts FROM tbl_attempts WHERE ipaddress = '$ipaddress'");
      $result->execute();
      if($row = $result->fetch()){
        $_SESSION['att'] = $row['numberofattempts'];
        echo "Number of attempts for ip-address ".$ipaddress. " : " .$row['numberofattempts']."\r\n";
      }
      $date = date('Y/m/d H:i:s');
      echo "where is the poop?!\n\r".$_SESSION['shiftCode'];
      echo $date;
      exit();
  }
  

  
// user logout
  if ($_GET['do'] == 'logout') { //Logout
    $userID = $_SESSION['userID'];
    $r = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `action`) VALUES ('$userID','logged out')");
    $r->execute(array());
    session_destroy();
    echo "<script type='text/javascript'>window.location.replace('http://www.cielosburger.online');</script>";
    exit();
  }
  
// user autologout
//   if ((time() - $_SESSION['timestamp']) > 10) { 
//       echo "15 minutes is over!";
//       // $userID = $_SESSION['userID'];
//       // $action = "Logged-out.";
//       // $r = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `dt`, `action`) VALUES ('$userID','$dt','$action')");
//       // $r->execute(array());

//       // unset($_SESSION['userID']);
//       // unset($_SESSION['fname']);
//       // unset($_SESSION['role']);
//       // unset($_SESSION['username']);
//       // $_SESSION['logged_in'] = "false";


//       // header("location: ../index.php");
//       // exit();
//   }
  
  
  
  
// add new user
  if(isset($_POST['lastname'],$_POST['firstname'], $_POST['role'], $_POST['password'])){ //if all items are not empty
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $role = $_POST['role'];
    $password = ($_POST['password']);
    
    $dashofsalt = "randomkindofburger";
    $password = md5($dashofsalt.$password);
    $password = sha1($password);
    $password = crypt($password,$dashofsalt);
  }
  
  if($_GET['do'] == 'add'){ // add new user account
    $subFN = mb_substr($firstname, 0, 3); //gets the last three letters of the first name
    $newUserName = strtolower($subFN.$lastname) ;
    $newUserName = str_replace(' ', '', $newUserName);
    $pic = "../images/logo.png";
    
    $result = $db->prepare("SELECT * FROM tbl_users WHERE username='$newUserName'");
    $result->execute();
    
    if($row = $result->fetch()){
      $message = "user already exist";
      echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
      exit();
    }else{
      $userNo = $_POST['userNo'];
      $password = str_replace(' ', '', $password);
      $sql = "INSERT INTO tbl_users(fname, lname, role, active, username, password,userNo) VALUES ('$firstname','$lastname','$role','active','$newUserName','$password','$userNo')";
      $q = $db->prepare($sql);
      $q->execute(array());
      echo "<script type='text/javascript'>history.go(-1);</script>";
      exit();
    }
  }


// edit account
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    

    if ($_GET['do'] == 'edit') {
      $active = $_POST['active'];
      $sql = "UPDATE tbl_users SET fname=?, lname=?, role=?, active=? WHERE id=?";
      $q = $db->prepare($sql);
      $q->execute(array($firstname, $lastname, $role, $active,$id));
      echo "<script type='text/javascript'>history.go(-1);</script>";
    }

    if ($_GET['do'] == 'delete') { //Deactive
      $sql = "DELETE FROM tbl_users WHERE id=".$id."";
      $q = $db->prepare($sql);
      $q->execute(array());
      echo "<script type='text/javascript'>history.go(-1);</script>";
    }

    if ($_GET['do'] == 'changePasswordUser') { //Changepassword
      $newPass = ($_POST['newPassword']);
      $retypePass = ($_POST['retypePassword']);

      if ($newPass <> $retypePass) {
          $message = "new password did not match, please type again";
          echo "<script type='text/javascript'>alert('$message');window.location.href='../user.php';</script>";
          exit();
      }
      $dashofsalt = "randomkindofburger";
      $newPass = md5($dashofsalt.$newPass);
      $newPass = sha1($newPass);
      $newPass = crypt($newPass,$dashofsalt);
      $result = $db->prepare("SELECT * FROM tbl_users WHERE id='$id'");
      $result->execute();
      if ($row = $result->fetch()) {
        $q = $db->prepare("UPDATE tbl_users SET password='$newPass' WHERE id='$id'");
        $q->execute(array());
        $message = "password successfully changed";
        echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
        exit();
      }
    }
  }


?>
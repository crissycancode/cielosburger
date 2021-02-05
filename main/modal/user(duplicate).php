<?php
  include_once('../connect.php');
  date_default_timezone_set('Asia/Manila');
  $dt = date('Y-m-d h:i:s');
  $dtl = date('Y-m-d h:i:sa');

  if(isset($_POST['lastname'])){
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $role = $_POST['role'];
    
    $dashofsalt = "randomkindofburger";
    $password = ($_POST['password']);
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

  if($_GET['do'] == 'login'){ // user login
    $a = $_POST['username'];
    $b = $_POST['password'];
    $dashofsalt = "randomkindofburger";
    $b = md5($dashofsalt.$b);
    $b = sha1($b);
    $b = crypt($b,$dashofsalt);

    $result = $db->prepare("SELECT *,CONCAT(fname,' ',lname) fullname FROM tbl_users WHERE username='$a'");
    $result->execute();

    if($row = $result->fetch()){ // user exists on the database
      $userId = $row['id'];
      $_SESSION['userID'] = $row['id'];
      $_SESSION['fullname'] = $row['fullname'];
      $_SESSION['role'] = $row['role'];
      $_SESSION['pic'] = $row['pic'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['userNo'] = $row['userNo'];

      if($row['active'] == 'inactive'){  //if the existing user status is inactive 
        echo "<script>alert('Unable to login.\\nPLEASE CONTACT YOUR ADMINISTRATOR TO REACTIVATE YOUR ACCOUNT!')</script>";
        echo "<script>window.location='../../index.php?'</script>";
        exit();
      }
      
    
      if($row['logattempt'] == '5'){ // on five login attempts
        // $_SESSION['attemp'] = '0';
        // echo "<script>alert('Unable to login.\\nPLEASE CONTACT YOUR ADMINISTRATOR TO REACTIVATE YOUR ACCOUNT!')</script>";
        // echo "<script>window.location='../../index.php?'</script>";
        // exit();
        
      }else if($b == $row['password']){ //if the password matches
        $_SESSION['attemp'] = '0';
        $_SESSION['logged_in'] = "true";
        $role = $_SESSION['role'];
        $fullname = $_SESSION['fullname'];
        $userID = $_SESSION['userID'];
        $action = "Logged-in.";
        $r = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `dt`, `action`) VALUES ('$userID','$dt','$action')");
        $r->execute(array());

        

        //ShiftCode
        $res = $db->prepare("SELECT * FROM tbl_ualt WHERE `action`='Logged-in.' ORDER BY ID DESC LIMIT 1");
        $res->execute();
        if ($r = $res->fetch()) {
          if(isset($r['userId']) && $r['userId']==$userId){
            $_SESSION['shiftCode'] = date('Ymd',$r['dt']) . '-' .$userId;
          }else{
            $_SESSION['shiftCode'] = date('Ymd') . '-' .$userId;
          }
        }

        $result = $db->prepare("SELECT * FROM tbl_shift WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL ORDER BY ID DESC LIMIT 1");
        $result->execute();
        if($row = $result->fetch()){
          $_SESSION['timedin'] = $row[3];
        }

        if($role =="admin"){
          $_SESSION['timedin'] = "admin";
        }

        echo "success";
        exit();
      }else{
            // $_SESSION['attemp'] = $_SESSION['attemp'] + 1;
            // $stat = $_SESSION['attemp'];
            // $id = $row['id'];
            // $q = $db->prepare("UPDATE  tbl_users SET logattempt='$stat' WHERE id='$id'");
            // $q->execute(array());


            // if ($_SESSION['attemp'] == '5') {
            //     $_SESSION['attemp'] = 0;
            //     echo "<script>alert('Unabled to login.\\nPLEASE CONTACT YOUR ADMINISTRATOR TO REACTIVATE YOUR ACCOUNT!')</script>";
            //     echo "<script>window.location='../../index.php?'</script>";
            //     exit();
            // } else {
          
      }
    }else{
        $_SESSION['attemp'] = '0'; 
        echo "failed";
        // <!-- <script> alert('Invalid user not exist'); </script>
        // <script>window.location = '../../index.php';</script> -->
        // <!--check if the username and password is correct-->
    }

    
  } 

  if ($_GET['do'] == 'autoLogout') { //Logout
      // $userID = $_SESSION['userID'];
      // $action = "Logged-out.";
      // $r = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `dt`, `action`) VALUES ('$userID','$dt','$action')");
      // $r->execute(array());

      // unset($_SESSION['userID']);
      // unset($_SESSION['fname']);
      // unset($_SESSION['role']);
      // unset($_SESSION['username']);
      // $_SESSION['logged_in'] = "false";


      // header("location: ../index.php");
      // exit();
  }

//   if(!isset($userID)){
//     $_SESSION['logged_in'] = "false";
//     $message = "Successfully logout.";
//     header("location: ../index.php");
//     exit();
//   }
  
  if ($_GET['do'] == 'logout') { //Logout
    $userID = $_SESSION['userID'];

    $action = "Logged-out.";
    $r = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `dt`, `action`) VALUES ('$userID','$dt','$action')");
    $r->execute(array());

    // unset($_SESSION['userID']);
    // unset($_SESSION['fname']);
    // unset($_SESSION['role']);
    // unset($_SESSION['username']);
    // unset($_SESSION['timedin']);
    // $_SESSION['logged_in'] = "false";
    
    session_destroy();
    
    
    $message = "Successfully logout.";
    // echo "<script type='text/javascript'>history.go(-(history.length - 1));</script>";
    echo "<script type='text/javascript'>window.location.replace('http://www.cielosburger.online');</script>";
    // header("location: ../index.php");
    
    exit();
  }


  if(isset($_GET['id'])){
    $id = $_GET['id'];
    

    if ($_GET['do'] == 'edit') { //Edit
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

    function ualt($action){
        
      date_default_timezone_set('Asia/Manila');
      $dt = date('Y-m-d h:i:s');
      $r = $db->prepare("INSERT INTO `tbl_ualt`(`id`, `dt`, `action`) VALUES ('$userID','$dt','$action')");
      $r->execute(array());
    }

  }


?>
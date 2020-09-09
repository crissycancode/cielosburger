<?php
include_once('../connect.php');
date_default_timezone_set('Asia/Manila');
$dt = date('Y-m-d h:i:s');
$dtl = date('Y-m-d h:i:sa');

function dob($birthday)
{
    list($day, $month, $year) = explode("/", $birthday);
    $year_diff = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0)
        $year_diff--;
    return $year_diff;
}

if (isset($_POST['lastname'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = ($_POST['password']);

    $gender = $_POST['gender'];
    $cs = $_POST['cs'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $zero = '0';


    $bday = $_POST['bday'];
    $userNo = $_POST['userNo'];
    $age = date('d/m/Y', strtotime(str_replace('-', '/', $bday)));
    $age = dob($age);

    if ($age < 18) {
        $message = "Age is invalid.";
        echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
        exit();
    }
}

if ($_GET['do'] == 'add') { //Insert

    $temp = $_FILES["pic"]["tmp_name"];
    $pic = $_FILES["pic"]["name"];
    move_uploaded_file($temp, "../images/" . $pic);


    $result = $db->prepare("SELECT * FROM tbl_users WHERE username='$username' AND password='$password' ");
    $result->execute();
    if ($row = $result->fetch()) {
        $message = "User is existed.";
        echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
        exit();
    } else {
        $sql = "INSERT INTO tbl_users(pic,fname, lname, role, active, username, password,gender,cs,email,contact,address,bday,age,userNo) VALUES ('$pic','$firstname','$lastname','$role','$zero','$username','$password','$gender','$cs','$email','$contact','$address','$bday','$age','$userNo')";
        $q = $db->prepare($sql);
        $q->execute(array());
        header("location: ../user.php?r=added");
        exit();
    }
}

if (isset($_GET['do'])) if ($_GET['do'] == 'goLogin') {
    $distime = $_SESSION['distime'];
    if ($_SESSION['attemp'] == '0') {
        $message = "You can now login.";
    } else {
        $message = "Wait until for a while.";
    }
    echo "<script type='text/javascript'>alert('$message');window.location.href='../../index.php';</script>";
    exit();
}

if ($_GET['do'] == 'login') { //Login
    $a = $_POST['username'];
    $b = $_POST['password'];

    $result = $db->prepare("SELECT *,CONCAT(fname,' ',lname) fullname FROM tbl_users WHERE username='$a'");
    $result->execute();
    if ($row = $result->fetch()) { $userId= $row['id'];
        $_SESSION['userID'] = $row['id'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['pic'] = $row['pic'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['attemp'] = $row['logattempt'];


  if ($row['active'] == '1') {  
            echo "<script>alert('Unabled to login.\\nPLEASE CONTACT YOUR ADMINISTRATOR TO REACTIVATE YOUR ACCOUNT!')</script>";
            echo "<script>window.location='../../index.php?'</script>";
            exit();

        }


        if ($row['logattempt'] == '5') {
            $_SESSION['attemp'] = '0';
            echo "<script>alert('Unabled to login.\\nPLEASE CONTACT YOUR ADMINISTRATOR TO REACTIVATE YOUR ACCOUNT!')</script>";
            echo "<script>window.location='../../index.php?'</script>";
            exit();
        } elseif ($b == $row['password']) {
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
                    if($r['userId']==$userId){
                        $_SESSION['shiftCode'] = date('Ymd',$r['dt']) . '-' .$userId;
                    }else{
                        $_SESSION['shiftCode'] = date('Ymd') . '-' .$userId;
                    }
            }



            echo "<script>alert('Welcome $role $fullname')</script>";
            echo "<script>window.location='../index.php'</script>";
            exit();

        } else {
            $_SESSION['attemp'] = $_SESSION['attemp'] + 1;
            $stat = $_SESSION['attemp'];
            $id = $row['id'];
            $q = $db->prepare("UPDATE  tbl_users SET logattempt='$stat' WHERE id='$id'");
            $q->execute(array());


            if ($_SESSION['attemp'] == '5') {
                $_SESSION['attemp'] = 0;
                echo "<script>alert('Unabled to login.\\nPLEASE CONTACT YOUR ADMINISTRATOR TO REACTIVATE YOUR ACCOUNT!')</script>";
                echo "<script>window.location='../../index.php?'</script>";
                exit();
            } else {

                ?>
                <script> alert('Invalid username or password. attempt : <?php echo $stat;?>'); </script>
                <script>window.location = '../../index.php';</script>

            <?php }
        }
    } else {
        $_SESSION['attemp'] = '0'; ?>
        <script> alert('Invalid user not exist'); </script>
        <script>window.location = '../../index.php';</script>
        <!--check if the username and password is correct-->

    <?php }

}

if ($_GET['do'] == 'autoLogout') { //Logout
    $userID = $_SESSION['userID'];
    $action = "Logged-out.";
    $r = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `dt`, `action`) VALUES ('$userID','$dt','$action')");
    $r->execute(array());

    unset($_SESSION['userID']);
    unset($_SESSION['fname']);
    unset($_SESSION['role']);
    unset($_SESSION['username']);
    $_SESSION['logged_in'] = "false";


    $message = "Automatic logout.";
    echo "<script type='text/javascript'>alert('$message');window.location.href='../../index.php';</script>";
    exit();


}


if ($_GET['do'] == 'logout') { //Logout
    $userID = $_SESSION['userID'];
    $action = "Logged-out.";
    $r = $db->prepare("INSERT INTO `tbl_ualt`(`userID`, `dt`, `action`) VALUES ('$userID','$dt','$action')");
    $r->execute(array());

    unset($_SESSION['userID']);
    unset($_SESSION['fname']);
    unset($_SESSION['role']);
    unset($_SESSION['username']);
    $_SESSION['logged_in'] = "false";


    $message = "Successfully logout.";
    echo "<script type='text/javascript'>alert('$message');window.location.href='../../index.php';</script>";
    exit();


}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_GET['do'] == 'edit') { //Edit
        $pic = $_FILES["pic"]["name"];
        if ($pic == "") {
            $pic = $_POST['pic1'];
        } else {
            $temp = $_FILES["pic"]["tmp_name"];
            $pic = $_FILES["pic"]["name"];
            move_uploaded_file($temp, "../images/" . $pic);
        }


        $sql = "UPDATE tbl_users SET pic=?, fname=?, lname=?, role=?, active=?, username=?,gender=?,cs=?,email=?,contact=?,address=?,bday=?,age=? WHERE id=?";
        $q = $db->prepare($sql);
        $q->execute(array($pic, $firstname, $lastname, $role, $zero, $username, $gender, $cs, $email, $contact, $address, $bday, $age, $id));
        header("location: ../user.php?r=updated");
    }

    if ($_GET['do'] == 'delete') { //Deactive
        $q = $db->prepare("UPDATE tbl_users SET active='1' WHERE id='$id'");
        $q->execute(array());
        header("location: ../user.php?r=deleted");
    }

    if ($_GET['do'] == 'changePassword') { //Changepassword
        $cpassword = ($_POST['cPassword']);
        $rpassword = ($_POST['rPassword']);


        $npassword = ($_POST['nPassword']);
        $result = $db->prepare("SELECT * FROM tbl_users WHERE id='$id' AND password='$cpassword'");
        $result->execute();
        if ($row = $result->fetch()) {
            $q = $db->prepare("UPDATE tbl_users SET password='$npassword' WHERE id='$id'");
            $q->execute(array());
            header("location: ../user.php?r=updated");
        } else {
            $message = "Invalid password.";
            echo "<script type='text/javascript'>alert('$message');window.location.href='../user.php';</script>";
            exit();

        }
    }

    if ($_GET['do'] == 'changePasswordUser') { //Changepassword
        $cpassword = ($_POST['cPassword']);
        $npassword = ($_POST['nPassword']);
        $rpassword = ($_POST['rPassword']);

        if ($cpassword <> $rpassword) {
            $message = "Invalid re-type password.";
            echo "<script type='text/javascript'>alert('$message');window.location.href='../user.php';</script>";
            exit();
        }


        $result = $db->prepare("SELECT * FROM tbl_users WHERE id='$id' AND password='$cpassword'");
        $result->execute();
        if ($row = $result->fetch()) {
            $q = $db->prepare("UPDATE tbl_users SET password='$npassword' WHERE id='$id'");
            $q->execute(array());
            $message = "Successfully changed.";
            echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
            exit();
        } else {
            $message = "Invalid password.";
            echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
            exit();

        }
    }

    function ualt($action)
    {
        date_default_timezone_set('Asia/Manila');
        $dt = date('Y-m-d h:i:s');
        $r = $db->prepare("INSERT INTO `tbl_ualt`(`id`, `dt`, `action`) VALUES ('$userID','$dt','$action')");
        $r->execute(array());
    }

}


?>
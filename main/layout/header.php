<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>CB</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b> Cielo's Burger</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="assets/images/<?php echo $_SESSION['pic']; ?>" class="user-image" alt="User Image">
                        <!-- Timer -->
                        <script type="text/javascript">
                            tday = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
                            tmonth = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

                            function GetClock() {
                                var d = new Date();
                                var nday = d.getDay(), nmonth = d.getMonth(), ndate = d.getDate(),
                                    nyear = d.getFullYear();
                                var nhour = d.getHours(), nmin = d.getMinutes(), nsec = d.getSeconds(), ap;

                                if (nhour == 0) {
                                    ap = " AM";
                                    nhour = 12;
                                }
                                else if (nhour < 12) {
                                    ap = " AM";
                                }
                                else if (nhour == 12) {
                                    ap = " PM";
                                }
                                else if (nhour > 12) {
                                    ap = " PM";
                                    nhour -= 12;
                                }

                                if (nmin <= 9) nmin = "0" + nmin;
                                if (nsec <= 9) nsec = "0" + nsec;

                                document.getElementById('clockbox').innerHTML = "" + tday[nday] + ", " + tmonth[nmonth] + " " + ndate + ", " + nyear + " " + nhour + ":" + nmin + ":" + nsec + ap + "";
                            }

                            window.onload = function () {
                                GetClock();
                                setInterval(GetClock, 1000);
                            }
                        </script>


                        <span id="clockbox" class="hidden-xs">  <?php echo $_SESSION['fullname']; ?> </span>


                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="assets/images/<?php echo $_SESSION['pic']; ?>" class="img-circle" alt="User Image">

                            <p>  <?php echo $_SESSION['fullname']; ?>   </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php $id = $_SESSION['userID']; ?>
                                <a data-toggle="modal" data-target="#updatePassword<?php echo $id; ?>" type="submit"
                                   class="btn btn-default btn-flat">Change Password</a>
                            </div>

                            <div class="pull-right">
                                <a href="modal/user.php?do=logout" onclick="return  confirm('Do you want to logout ?')"
                                   class="btn btn-default btn-flat">Log Out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>


<?php $result = $db->prepare("SELECT * FROM tbl_users ORDER BY id DESC");
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $id = $row['id']; ?>
    <div class="modal fade" id="updatePassword<?php echo $id; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Update Password</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" action="modal/user.php?do=changePasswordUser&id=<?php echo $id; ?>"
                          method="post">
                        <div class="box-body"><input value="<?php echo $row['id']; ?>" type="hidden"
                                                     class="form-control" name="id">
                            <div class="form-group"><label class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input value="<?php echo $row['username']; ?>" type="text" class="form-control"
                                           name="username" placeholder="Username" required readonly></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input value="<?php echo $row['password']; ?>" type="password" class="form-control"
                                           name="password" placeholder="Password" required readonly></div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label">Type Current Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cPassword"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@$!%*#?&]).{6,}"
                                           title="Must contain at least one special characters, one number and one uppercase and lowercase letter, and at least 6 or more characters"
                                           placeholder="Type Current Password" required></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">New Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nPassword"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@$!%*#?&]).{6,}"
                                           title="Must contain at least one special characters, one number and one uppercase and lowercase letter, and at least 6 or more characters"
                                           placeholder="New Password" required></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Re-type Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="rPassword"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@$!%*#?&]).{6,}"
                                           title="Must contain at least one special characters, one number and one uppercase and lowercase letter, and at least 6 or more characters"
                                           placeholder="Re-type Current Password" required></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary pull-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
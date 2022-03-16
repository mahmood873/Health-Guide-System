<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 03-Aug-20
 * Time: 7:51 PM
 */

require_once ("database-connection.php");
session_start();

if (!isset($_COOKIE['username'])){
    header("location:login.php");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}


$username=$_SESSION['username'];

$doc=$con->query("select * from users where user_username='$username'")->fetch_array();

$doc_user_id=$doc['user_id'];
$doctorDetails=$con->query("select * from outsidedoctor where email='$username'")->fetch_array();
$doctorProfile=$con->query("select * from doctorprofile where user_id='$doc_user_id'")->fetch_array();
$doctorImage=$con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];


if (isset($_REQUEST['yes'])){


    $con->query("delete from users where user_username='$username'");
    setcookie("username", "", time() - 10);
    unset($_SESSION['username']);
    header("location:index.php");
    return;
}


/*
 * Messages Counter
 */
$counterMessages=$con->query("select * from chat_message where to_user_id='$doc_user_id' and status='not seen'");
$counter=mysqli_num_rows($counterMessages);

//Counter Area
$countTotalPatient=mysqli_num_rows($con->query("select distinct user_id,visitor_id from appointments where doc_user_id='$doc_user_id'"));


//Today Appointments

$today=date("d M Y");
$todayAppointments=$con->query("select * from appointments where doc_user_id='$doc_user_id' and date='$today' and (status='unapproved' or status='approved')");

$counterTodayPatient=mysqli_num_rows($todayAppointments);
$counterAppointments=mysqli_num_rows($con->query("select * from appointments where doc_user_id='$doc_user_id' and (status='unapproved' or status='approved')"));


?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Delete Account - Doctor Dashboard</title>

    <link href="assets/img/favicon.png" rel="icon">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">





    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<div class="main-wrapper">
    <!--Header Part-->
    <header class="header">
        <nav class="navbar navbar-expand-lg header-nav">
            <!---Logo-->
            <div class="navbar-header">
                <a href="index.php" class="navbar-brand logo"><img src="assets/img/logo1.png"   class="img-fluid" alt="Logo"></a>
            </div>
            <ul class="nav header-navbar-rht">
                <!-- User Menu -->
                <li class="nav-item dropdown has-arrow logged-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
									<img class="rounded-circle" src="assets/img/doctors/<?=$doctorImage?>" width="31" alt="<?=$doctorDetails['firstname']?>">
								</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="assets/img/doctors/<?=$doctorImage?>" alt="User Image" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6>Dr. <?php echo $doctorDetails['firstname'] ?></h6>
                                <p class="text-muted mb-0">Doctor</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="outside-doctor-dashboard.php">Dashboard</a>
                        <a class="dropdown-item" href="outside-doctor-profile-setting.php" >Profile Settings</a>
                        <a class="dropdown-item" href="logout.php?doctor">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->

            </ul>
        </nav>


    </header>
    <!--/Header-->

    <!---Page Content-->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    <!-- Dashboard Sidebar -->
                    <div class="profile-sidebar">
                        <div class="widget-profile pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="#" class="booking-doc-img">
                                    <img src="assets/img/doctors/<?=$doctorImage?>" alt="Doctor Image">
                                </a>
                                <div class="profile-det-info">
                                    <h3>Dr. <?php echo $doctorDetails['firstname'].' '.$doctorDetails['lastname']; ?></h3>

                                    <div class="patient-details">
                                        <h5 class="mb-0"><?php echo $doctorDetails['specialization'];?> </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-widget">
                            <nav class="dashboard-menu">
                                <ul>
                                    <li>
                                        <a href="outside-doctor-dashboard.php">
                                            <i class="fas fa-columns"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-appointments.php">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>Appointments</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-patients.php" >
                                            <i class="fas fa-user-injured"></i>
                                            <span>My Patients</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-schedule-timings.php">
                                            <i class="fas fa-hourglass-start"></i>
                                            <span>Schedule Timings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-chats.php">
                                            <i class="fas fa-comments"></i>
                                            <span>Message</span>
                                            <small class="unread-msg"><?=$counter?></small>
                                        </a>
                                    </li>

                                    <li id="profile">
                                        <a href="outside-doctor-profile-setting.php">
                                            <i class="fas fa-user-cog"></i>
                                            <span>Profile Settings</span>
                                        </a>
                                    </li>

                                    <li id="changePass">
                                        <a href="outside-doctor-change-password.php">
                                            <i class="fas fa-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="outside-delete-doctor-account.php">
                                            <i class="fas fa-trash"></i>
                                            <span>Delete Account</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php?doctor">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- /Dashboard Sidebar -->
                </div>

                <!--Dashboard-->
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <!--Dashboard Counter Area-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card dash-card">
                                <div class="card-body">
                                    <div class="row">

                                        <!--Total Patient Area-->
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget dct-border-rht">
                                                <div class="circle-bar circle-bar1">
                                                    <div class="circle-graph1" data-percent="75">
                                                        <img src="assets/img/icon-01.png" class="img-fluid" alt="patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Total Patient</h6>
                                                    <h3><?=$countTotalPatient?></h3>
                                                    <p class="text-muted">Till Today</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/Total Patient Area-->

                                        <!-- Today Patient Area-->
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget dct-border-rht">
                                                <div class="circle-bar circle-bar2">
                                                    <div class="circle-graph2" data-percent="65">
                                                        <img src="assets/img/icon-02.png" class="img-fluid" alt="Patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Today Patient</h6>
                                                    <h3><?=$counterTodayPatient?></h3>
                                                    <p class="text-muted">Till Today</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/Today Patient Area-->
                                        <!--Appointment Area-->
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget">
                                                <div class="circle-bar circle-bar3">
                                                    <div class="circle-graph3" data-percent="50">
                                                        <img src="assets/img/icon-03.png" class="img-fluid" alt="Patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Appoinments</h6>
                                                    <h3><?=$counterAppointments?></h3>
                                                    <p class="text-muted">Till Today</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/Appointment Area-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/Dashboard Counter Area-->
                    <div class="row" id="scheduleTiming">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Delete Account </h4>
                                            <h5 class="text-muted">Deleting your user account removes all your personal data owned by your account and the data associated with your account.The account name and username (email address/phone number) associated with the account becomes available for use with a different Health Guide account.</h5>
                                            <div class="mt-3 text-md-center">
                                                <small class="btn-sm bg-danger-light">Note: Once your account has been deleted, Health Guide cannot restore your content.</small>
                                            </div>
                                            <button type="button" class="btn bg-danger-light text-md-center mt-4 float-right" data-toggle="modal" data-target="#confirm">Delete your account</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body bg-success-light">
                <strong class="text-md-center">  Do you want to delete your account? </strong>
            </div>

            <div class="modal-footer ">
                <form action="outside-delete-doctor-account.php" method="post">
                    <button type="submit" class="btn bg-danger-light"  name="yes">Yes, Delete my account</button>
                    <button type="submit" class="btn bg-success-light" data-dismiss="modal">No</button>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Sticky Sidebar JS -->

<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

<!-- Circle Progress JS -->
<script src="assets/js/circle-progress.min.js"></script>

<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>



<!-- Profile Settings JS -->
<script src="assets/js/profile-settings.js"></script>

</body>

</html>




<!------------------------------------------>
<!------      PHP Source Code      --------->
<!------------------------------------------>

<?php
//Database Connection
require_once ("database-connection.php");
session_start();
if (!isset($_COOKIE['username'])){
    header("location:login.php");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}

$selectDoctors=$con->query("select * from doctor");
$selectHospitals=$con->query("select * from hospital");
$selectClincs=$con->query("select * from clinics");
$selectMedicals=$con->query("select * from medicals");
$selectMedicines=$con->query("select * from medicineindustry");

$countDoctor=mysqli_num_rows($selectDoctors);
$countHospials=mysqli_num_rows($selectHospitals);
$countClinics=mysqli_num_rows($selectClincs);
$countMedicalStores=mysqli_num_rows($selectMedicals);
$countMedicine=mysqli_num_rows($selectMedicines);



$view=false;
$clinicRecordRow=null;
$viewClinicRecord=false;
$viewClinicRecordEmpty=false;

$runDeleteQuerySuccess=false;
$runDeleteQueryNotSuccess=false;


$clinicList=$con->query("select * from clinics");
$checkRows=mysqli_num_rows($clinicList);
if(isset($_REQUEST['view'])){


    $view=true;
    $clinicID=$_REQUEST['cli_id'];
    $clinicRecord=$con->query("select * from clinics where clinic_id='$clinicID'");
    $clinicRecordRow=$clinicRecord->fetch_array();
    if ($clinicRecordRow['clinic_id']==null){
        $viewClinicRecordEmpty=true;
    }
    else {
        $viewClinicRecord = true;
    }


}
elseif (isset($_REQUEST['cancel'])){
    $view=true;
}
elseif (isset($_REQUEST['deleteByID'])){
    $view=true;
    $clinicID=$_REQUEST['cli_id'];
    $row=$con->query("select clinic_id from clinics where clinic_id='$clinicID'")->fetch_array();
    if($row['clinic_id']==null){
        $runDeleteQueryNotSuccess=true;
    }
    else{
        $runDeleteQuery=$con->query("delete from clinics where clinic_id='$clinicID'");
        header("location:delete-clinic.php?deleteID");


    }
}
elseif (isset($_REQUEST['deleteID'])){
    $view=true;
    $runDeleteQuerySuccess=true;
}
elseif (isset($_REQUEST['deleteByIDTab'])){
    $cli_id=$_REQUEST['deleteByIDTab'];
    $deleteQuery=$con->query("delete from clinics where clinic_id='$cli_id'");

    if($deleteQuery->error){
        header("location:delete-clinic.php?error");
    }
    else{
        header("location:delete-clinic.php?deleteclinicrecord");
    }

}
elseif (isset($_REQUEST['deleteclinicrecord'])){
    $view=true;
    $runDeleteQuerySuccess=true;

}
elseif (isset($_REQUEST['delete'])){
    $cli_id=$_REQUEST['delete'];
    $deleteQuery=$con->query("delete from clinics where clinic_id='$cli_id'");

    if($deleteQuery->error){
        header("location:delete-clinic.php?error");
    }
    else {
        header("location:delete-clinic.php?deleteRecord");
    }
}




?>


<html>
<head>
    <meta charset="utf-8">
    <title>Delete Clinic - MOHA</title>

    <link href="assets/img/favicon.png" rel="icon">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">


    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<!---------------------------------------->
<!--             MAIN WRAPPER           -->
<!---------------------------------------->
<div class="main-wrapper">


    <!--Sidebar-->

    <div class="wrapper1 d-flex align-items-stretch">

        <nav id="sidebar">
            <div class="custom-menu2">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>

                </button>
            </div>

            <div class="p-4 pt-5">
                <span>Main</span>
                <ul class="list-unstyled components mb-5">
                    <li>

                        <a href="moha-dashboard.php"><i class="fas fa-columns" style="position: relative; margin-right: 12px;"></i>Dashboard</a>
                    </li>
                    <li class="subMenu2">
                        <a href="#regSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="fas fa-file-medical" style="position: relative; margin-right: 12px;"></i>Registration</a>
                        <ul class="collapse list-unstyled" id="regSubmenu">
                            <li>
                                <a href="doctor-registration.php">Doctor Registration</a>
                            </li>
                            <li>
                                <a href="hospital-registration.php">Hospital Registration</a>
                            </li>
                            <li>
                                <a href="clinic-registration.php">Clinic Registration</a>
                            </li>
                            <li>
                                <a href="medical-registration.php">Medical Stores Reg</a>
                            </li>
                            <li>
                                <a href="medicine-registration.php">Medicine Industry Reg</a>
                            </li>
                        </ul>
                    </li>

                    <li class="subMenu3 active">
                        <a href="#delSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="fas fa-trash-alt" style="position: relative; margin-right: 12px;"></i>Deletion</a>
                        <ul class="collapse list-unstyled" id="delSubmenu">
                            <li>
                                <a href="delete-doctor.php">Doctor Deletion</a>
                            </li>
                            <li>
                                <a href="delete-hospital.php">Hospital Deletion</a>
                            </li>
                            <li class="active">
                                <a href="delete-clinic.php">Clinic Deletion</a>
                            </li>
                            <li>
                                <a href="delete-medical.php">Medical Stores Del</a>
                            </li>
                            <li>
                                <a href="delete-medicine.php">Medicine Industry Del</a>
                            </li>
                        </ul>
                    </li>

                    <li class="subMenu4">
                        <a href="#viewSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="far fa-eye" style="position: relative; margin-right: 12px;"></i>View Records</a>
                        <ul class="collapse list-unstyled" id="viewSubmenu">
                            <li>
                                <a href="view-doctor-records.php">Doctor Records</a>
                            </li>
                            <li>
                                <a href="view-hospital-records.php">Hospital Records</a>
                            </li>
                            <li>
                                <a href="view-clinic-records.php">Clinic Records</a>
                            </li>
                            <li>
                                <a href="view-medical-records.php">Medical Stores Rec</a>
                            </li>
                            <li>
                                <a href="view-medicine-records.php">Medicine Industry Rec</a>
                            </li>
                        </ul>
                    </li>

                    <li class="subMenu5">
                        <a href="#updateSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="fas fa-edit" style="position: relative; margin-right: 12px;"></i>Update Records</a>
                        <ul class="collapse list-unstyled" id="updateSubmenu">
                            <li>
                                <a href="update-doctor-records.php">Doctor Records</a>
                            </li>
                            <li>
                                <a href="update-hospital-records.php">Hospital Records</a>
                            </li>
                            <li>
                                <a href="update-clinic-records.php">Clinic Records</a>
                            </li>
                            <li>
                                <a href="update-medical-records.php">Medical Stores Rec</a>
                            </li>
                            <li>
                                <a href="update-medicine-records.php">Medicine Industry Rec</a>
                            </li>
                        </ul>
                    </li>

                    <li>

                        <a href="moha-profile.php"><i class="fas fa-user-cog" style="position: relative; margin-right: 12px;"></i>Profile Setting</a>
                    </li>
                    <li>

                        <a href="moha-change-password.php"><i class="fas fa-lock" style="position: relative; margin-right: 12px;"></i>Change Password</a>
                    </li>
                    <li>

                        <a href="lock-screen.php"><i class="fas fa-user-lock" style="position: relative; margin-right: 12px;"></i>Lock Screen</a>
                    </li>
                    <li>

                        <a href="logout.php?doctor"><i class="fas fa-sign-out-alt" style="position: relative; margin-right: 12px;"></i>Log out</a>
                    </li>
                    <br><br><br><br>

                </ul>

            </div>




        </nav>




    </div>




    <!--/Sidebar-->

    <!--Dashboard Page Content-->
    <div class="mohaPageContent" id="mohaPageContent">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome MOHA-Employee!</h3>
                    <span class="spp">Dashboard</span>
                </div>
            </div>
        </div>
        <!--Counter Area-->
        <div class="row mohaCounter">
            <div class="mohaCounterArea doctorCounterArea" data-toggle="modal" data-target="#clinicUpdateModal">

                <div class="dash-widget-header" >
            <span class="dash-widget-icon text-primary">
                <i class="fas fa-user"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countDoctor?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Doctors</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: green;"></div>
                    </div>
                </div>

            </div>
            <!--Hospital Area-->
            <div class="mohaCounterArea hospitalCounterArea" data-toggle="modal" data-target="#clinicUpdateModal">

                <div class="dash-widget-header">
            <span class="dash-widget-icon" style="border-color: black;">
                <i class="fas fa-hospital" style="color: black;"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countHospials?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Hospitals</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: black;"></div>
                    </div>
                </div>

            </div>
            <!--/Hospital Area-->

            <!--Clinic Area-->
            <div class="mohaCounterArea clinicCounterArea">

                <div class="dash-widget-header">
            <span class="dash-widget-icon" style="border-color: rgb(204, 54, 54);">
                <i class="fas fa-clinic-medical" style="color: rgb(204, 54, 54);"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countClinics?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Clinics</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: rgb(204, 54, 54);"></div>
                    </div>
                </div>

            </div>
            <!--/Clinic Area-->
            <!--Medical Stores Area-->
            <div class="mohaCounterArea medicalCounterArea">

                <div class="dash-widget-header">
            <span class="dash-widget-icon" style="border-color: rgb(198, 211, 21);">
                <i class="fas fa-cannabis" style="color: rgb(198, 211, 21);"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countMedicalStores?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Medical Stores</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: rgb(198, 211, 21);"></div>
                    </div>
                </div>

            </div>
            <!--/Medical Stores Area-->

            <!--Medicine Industry Area-->
            <div class="mohaCounterArea medicineCounterArea">

                <div class="dash-widget-header">
            <span class="dash-widget-icon" style="border-color: rgb(9, 156, 161);">
                <i class="fas fa-capsules" style="color: rgb(9, 156, 161);"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countMedicine?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Medicine Industries</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: rgb(9, 156, 161);"></div>
                    </div>
                </div>

            </div>
            <!--/Medicine Industry Area-->
        </div>

        <!--/Counter Area-->



    </div>
    <!--/Dashboard Page Content-->

    <!--Clinic Deletion Area-->
    <div class="mohaForms" id="clinicDeletion">

        <div class="card clinic-deletion">
            <div class="card-body">
                <div class="user-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link  <?php if($view==false){ echo "active"; } ?>" href="#cli-deletion" data-toggle="tab">Delete Clinics Records <?php if(isset($_REQUEST['deleteRecord'])){ ?> <span style="color: red;">(Record Deleted)</span> <?php } ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  <?php if($view==true){ echo "active"; } ?>" href="#cli-deletion-by-id" data-toggle="tab"><span>Delete Clinic Record By ID</span></a>
                        </li>


                    </ul>
                </div>

                <div class="tab-content">
                    <!--Delete Clinic Record Tab-->
                    <div id="cli-deletion" class="tab-pane fade show <?php  if ($view==false){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive clinicList">
                                    <form action="delete-clinic.php" method="post">
                                    <table class="table table-hover table-center mb-0" style="display: <?php if($checkRows==0){ echo "none"; }?>  ">
                                        <thead>
                                        <tr>
                                            <th>Clinic Name</th>

                                            <th>Clinic Type</th>
                                            <th>Clinic Location</th>


                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        while($row=$clinicList->fetch_array()) {


                                        ?>
                                        <tr class="clinicRow">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a href="doctor-profile.html"> <?php echo $row['clinic_name'] ?> <span><?php echo $row['clinic_id'] ?> </span></a>
                                                </h2>
                                            </td>
                                            <td><?php echo $row['clinic_type'] ?> </td>



                                            <td><?php echo $row['clinic_location'] ?> </td>

                                            <td><span class="badge badge-pill bg-success-light"><?php echo $row['clinic_status'] ?> </span></td>
                                            <td class="text-right">
                                                <div class="table-action">
                                                    <button name="delete" value="<?= $row['clinic_id'] ?>" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-trash-alt"></i> Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                            <?php
                                        }
                                        ?>

                                        </tbody>

                                    </table>
                                    <div style="margin-left: 32%;margin-top: 10px;font-size: 20px;color: red; display: <?php if (!$checkRows==0){ echo "none"; }  ?>">
                                        <span>  <i class="far fa-window-close" style="margin-right: 3px"></i> No Clinic Records Avaliable! </span>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/Delete Clinic Record Tab-->

                    <!--Clinic Deletion By ID-->
                    <div id="Cli-deletion-by-id" class="tab-pane fade show clinicList <?php if ($view==true){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <form action="delete-clinic.php" method="post" style="position: relative; margin-top: 20px;">
                                <div class="row form-row">

                                    <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                        <div class="form-group">

                                            <input type="text" name="cli_id" class="form-control" placeholder="enter clinic id here.." required>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group" style="position: relative;margin-top: 4px;">
                                            <button type="submit" name="view"  class="btn btn-md bg-success-light ">
                                                <i class="far fa-eye"></i> View Record
                                            </button>
                                            <button type="submit" name="deleteByID" class="btn btn-md bg-danger-light">
                                                <i class="far fa-trash-alt"></i> Delete Record
                                            </button>


                                        </div>
                                    </div>

                                </div>
                                </form>

                                <!--View Button Records-->
                                <div class="table-responsive clinicList2" id="clinicList2" style="display: <?php if($viewClinicRecord==false){ echo "none"; }  ?>">
                                    <form action="delete-clinic.php" method="post">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Clinic Name</th>
                                            <th>Clinic Type</th>
                                            <th>Clinic Location</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr class="clinicRow">
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="doctor-profile.html"><?php echo $clinicRecordRow['clinic_name'] ?> <span><?php echo $clinicRecordRow['clinic_id'] ?> </span></a>
                                                </h2>
                                            </td>
                                            <td><?php echo $clinicRecordRow['clinic_type'] ?> </td>

                                            <td><?php echo $clinicRecordRow['clinic_location'] ?> </td>

                                            <td><span class="badge badge-pill bg-success-light"><?php echo $clinicRecordRow['clinic_status'] ?> </span></td>
                                            <td class="text-right">
                                                <div class="table-action">
                                                    <button name="deleteByIDTab" value="<?= $clinicRecordRow['clinic_id']; ?>" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-trash-alt"></i> Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>


                                        </tbody>
                                        <tr></tr>

                                    </table>

                                    <button type="submit" name="cancel" class="btn btn-md bg-primary cancelButton" style="width: 78%;margin:10px 100px;">Cancel</button>
                                    </form>
                                </div>
                                <!--/View Button Records-->
                                <div style="margin-left: 35%;color: green; display: <?php if ($runDeleteQuerySuccess==false){ echo "none";}  ?>">
                                    <span>  <i class="fas fa-check" style="margin-right: 3px"></i> Clinic Record Deleted Successfuly! </span>
                                </div>
                                <div style="margin-left: 30%;color: red; display: <?php if ($runDeleteQueryNotSuccess==false){ echo "none";}  ?>">
                                    <span>  <i class="far fa-window-close" style="margin-right: 3px"></i> Clinic Record Not Deleted (No Record Avaliable)! </span>
                                </div>
                                <div style="margin-left: 35%;color: red; display: <?php if ($viewClinicRecordEmpty==false){ echo "none";}  ?>">
                                    <span>  <i class="far fa-window-close" style="margin-right: 3px"></i> No CLinic Record Avaliable! </span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/Clinic Deletion by ID-->
                </div>

            </div>
        </div>
    </div>
    <!--/Clinic Deletion Area-->



</div>
<!--/Main Wrapper-->

<!---------------------------------------->
<!--        MODAL AREA                  -->
<!---------------------------------------->




<!---------------------------------------->
<!--        EXTERNAL SOURCES            -->
<!---------------------------------------->

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>
<script src="assets/js/MOHA.js"></script>




</body>
</html>
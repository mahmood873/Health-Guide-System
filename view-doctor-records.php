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
$doctorRecordRow=null;
$viewDoctorRecord=false;
$viewDoctorRecordEmpty=false;
$viewDoctorRecord=false;
$chkRowsCount=0;

$msgN=false;
$msgS=false;
$msgP=false;






$doctorList=$con->query("select * from doctor");
$checkRows=mysqli_num_rows($doctorList);

if(isset($_REQUEST['viewbyid'])){


    $view=true;
    $doctorID=$_REQUEST['doc_id'];
    $doctorRecordRow=$con->query("select * from doctor where doc_id='$doctorID'");
    $chkRowsCount=mysqli_num_rows($doctorRecordRow);



   if ($chkRowsCount==0){
        $viewDoctorRecordEmpty=true;
    }
    else {
        $viewDoctorRecord = true;
        $viewDoctorRecord=true;
    }


}
    elseif (isset($_REQUEST['viewbyname'])){
        $view=true;
        $docName=$_REQUEST['docName'];
        $doctorRecordRow=$con->query("select * from doctor where doc_firstName like '%$docName%'");
        $chkRowsCount=mysqli_num_rows($doctorRecordRow);

        if (!preg_match("/^[a-zA-Z ]*$/",$docName)){
            $msgN=true;

        } elseif ($chkRowsCount==0){
            $viewDoctorRecordEmpty=true;
        }
        else {
            $viewDoctorRecord = true;
            $viewDoctorRecord=true;
        }

    }
elseif (isset($_REQUEST['viewbyspeciality'])){
    $view=true;
    $docSpeciality=$_REQUEST['docSpeciality'];
    $doctorRecordRow=$con->query("select * from doctor where doc_specialization='$docSpeciality'");
    $chkRowsCount=mysqli_num_rows($doctorRecordRow);


    if ($docSpeciality=="Select by a speciality"){
        $msgS=true;
    }elseif ($chkRowsCount==0){
        $viewDoctorRecordEmpty=true;
    }
    else {
        $viewDoctorRecord = true;
        $viewDoctorRecord=true;
    }
}
elseif (isset($_REQUEST['viewbyprovince'])){
    $view=true;
    $docProvince=$_REQUEST['docProvince'];
    $doctorRecordRow=$con->query("select * from doctor where doc_province='$docProvince'");
    $chkRowsCount=mysqli_num_rows($doctorRecordRow);


    if ($docProvince=="Select by a province"){
        $msgP=true;
    }elseif ($chkRowsCount==0){
        $viewDoctorRecordEmpty=true;
    }
    else {
        $viewDoctorRecord = true;
        $viewDoctorRecord=true;
    }
}
elseif (isset($_REQUEST['viewbylocation'])){
    $view=true;
    $docLocation=$_REQUEST['docLocation'];
    $doctorRecordRow=$con->query("select * from doctor where doc_location='$docLocation'");
    $chkRowsCount=mysqli_num_rows($doctorRecordRow);



    if ($chkRowsCount==0){
        $viewDoctorRecordEmpty=true;
    }
    else {
        $viewDoctorRecord = true;
        $viewDoctorRecord=true;
    }
}
elseif (isset($_REQUEST['cancel'])){
    $view=true;
}





?>


<html>
<head>
    <meta charset="utf-8">
    <title>View Doctor Records - MOHA</title>

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

                    <li class="subMenu3">
                        <a href="#delSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="fas fa-trash-alt" style="position: relative; margin-right: 12px;"></i>Deletion</a>
                        <ul class="collapse list-unstyled" id="delSubmenu">
                            <li>
                                <a href="delete-doctor.php">Doctor Deletion</a>
                            </li>
                            <li>
                                <a href="delete-hospital.php">Hospital Deletion</a>
                            </li>
                            <li>
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

                    <li class="subMenu4 active">
                        <a href="#viewSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="far fa-eye" style="position: relative; margin-right: 12px;"></i>View Records</a>
                        <ul class="collapse list-unstyled" id="viewSubmenu">
                            <li class="active">
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

    <!--Doctor View Area-->
    <div class="mohaForms" id="doctorView">

        <div class="card doctor-view">
            <div class="card-body">
                <div class="user-tabs">
                    <div style="margin-left: 30%;color: green;font-weight: 700; display: <?php if ($viewDoctorRecord==false){ echo "none";}  ?>">
                        <span>  <i class="fas fa-check" style="margin-right: 3px"></i><?php if (isset($_REQUEST['doctorID'])){?> Doctor Record By  Search ID = <?php echo $_REQUEST['doc_id']; } ?>
                            <?php if (isset($_REQUEST['doctorName'])){?> Doctor Record Search  By  Name = <?php echo $_REQUEST['docName']; ?>   <?php } ?>
                            <?php if (isset($_REQUEST['doctorSpeciality'])){?> Doctor Record  Search By  Specialization = <?php echo $_REQUEST['docSpeciality']; ?>   <?php } ?>
                            <?php if (isset($_REQUEST['doctorProvince'])){?> Doctor Record   Search By Province = <?php echo $_REQUEST['docProvince']; ?>   <?php } ?>
                            <?php if (isset($_REQUEST['doctorLocation'])){?> Doctor Record   Search By Lcoation = <?php echo $_REQUEST['docLocation']; ?>   <?php } ?>
                        </span>
                    </div>
                    <div style="margin-left: 30%;color: red;font-weight: 700; ;display: <?php if ($viewDoctorRecordEmpty==false){ echo "none";}  ?>">
                        <span>  <i class="far fa-window-close" style="margin-right: 3px"></i>

                            <?php if (isset($_REQUEST['doctorID'])){?>  No Doctor Record Avaliable By ID = <?php echo $_REQUEST['doc_id']; } ?>
                            <?php if (isset($_REQUEST['doctorName'])){?>  No Doctor Record Avaliable By Name = <?php echo $_REQUEST['docName']; } ?>
                            <?php if (isset($_REQUEST['doctorSpeciality'])){?>  No Doctor Record Avaliable By Specialization = <?php echo $_REQUEST['docSpeciality']; } ?>
                            <?php if (isset($_REQUEST['doctorProvince'])){?>  No Doctor Record Avaliable By Province = <?php echo $_REQUEST['docProvince']; } ?>
                            <?php if (isset($_REQUEST['doctorLocation'])){?>  No Doctor Record Avaliable By Location = <?php echo $_REQUEST['docLocation']; } ?>

                        </span>
                    </div>
                    <!--View Button Records-->
                    <div class="table-responsive doctorList2View"  style="display: <?php if($viewDoctorRecord==false){ echo "none"; }  ?>">
                        <form action="view-doctor-records.php" method="post">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th style="position: relative;margin-left: 0px;">Spec.</th>
                                    <th>Province</th>
                                    <th>District</th>

                                    <th>Location</th>
                                    <th>Email</th>
                                    <th>Qualification</th>
                                    <th>University</th>
                                    <th>Contact</th>
                                    <th>Gender</th>
                                    <th>Birth</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                if ($chkRowsCount==1) {
                                    $doctorRecordRow = $doctorRecordRow->fetch_array();
                                    ?>
                                    <tr class="doctorRow">
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html">Dr. <?php echo $doctorRecordRow['doc_firstName'] . ' ' . $doctorRecordRow['doc_lastName'] ?>
                                                    <span> <?php echo $doctorRecordRow['doc_id'] ?> </span></a>
                                            </h2>
                                        </td>
                                        <td> <?php echo $doctorRecordRow['doc_specialization'] ?></td>
                                        <td> <?php echo $doctorRecordRow['doc_province'] ?> </td>
                                        <td> <?php echo $doctorRecordRow['doc_district'] ?> </td>
                                        <td> <?php echo $doctorRecordRow['doc_location'] ?> </td>
                                        <td> <?php echo $doctorRecordRow['doc_email'] ?> </td>
                                        <td> <?php echo $doctorRecordRow['doc_qualification'] ?> </td>
                                        <td> <?php echo $doctorRecordRow['doc_university'] ?> </td>
                                        <td> <?php echo $doctorRecordRow['doc_contact'] ?> </td>
                                        <td> <?php echo $doctorRecordRow['doc_gender'] ?> </td>
                                        <td> <?php echo $doctorRecordRow['doc_birth'] ?> </td>
                                        <td>
                                            <span class="badge badge-pill bg-success-light"> <?php echo $doctorRecordRow['doc_status'] ?></span>
                                        </td>
                                        <td class="text-right">
                                            <div class="table-action">


                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                elseif ($chkRowsCount>1) {

                                    while ($row = $doctorRecordRow->fetch_array()) {

                                        ?>
                                        <tr class="doctorRow">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a href="doctor-profile.html">Dr. <?php echo $row['doc_firstName'] . ' ' . $row['doc_lastName'] ?>
                                                        <span> <?php echo $row['doc_id'] ?> </span></a>
                                                </h2>
                                            </td>
                                            <td> <?php echo $row['doc_specialization'] ?></td>
                                            <td> <?php echo $row['doc_province'] ?> </td>
                                            <td> <?php echo $row['doc_district'] ?> </td>
                                            <td> <?php echo $row['doc_location'] ?> </td>
                                            <td> <?php echo $row['doc_email'] ?> </td>
                                            <td> <?php echo $row['doc_qualification'] ?> </td>
                                            <td> <?php echo $row['doc_university'] ?> </td>
                                            <td> <?php echo $row['doc_contact'] ?> </td>
                                            <td> <?php echo $row['doc_gender'] ?> </td>
                                            <td> <?php echo $row['doc_birth'] ?> </td>
                                            <td>
                                                <span class="badge badge-pill bg-success-light"> <?php echo $row['doc_status'] ?></span>
                                            </td>
                                            <td class="text-right">
                                                <div class="table-action">


                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                                <tr></tr>

                            </table>


                            <button name="cancel" type="submit" class="btn btn-md bg-primary cancelButton" style="width: 78%;margin:10px 100px;">Cancel</button>
                        </form>
                    </div>
                    <!--/View Button Records-->
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link <?php if($view==false){ echo "active"; } ?>" href="#doc-view" data-toggle="tab" >View Doctors Records</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($view==true){ echo "active"; } ?> " href="#doc-view-by" data-toggle="tab"><span>View Doctor Record By</span></a>
                        </li>


                    </ul>
                </div>

                <div class="tab-content">
                    <!--View Doctor Record Tab-->
                    <div id="doc-view" class="tab-pane fade show <?php  if ($view==false){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive doctorListView">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Doctor</th>
                                            <th style="position: relative;margin-left: 0px;">Spec.</th>
                                            <th>Province</th>
                                            <th>District</th>
                                            <th>Location</th>
                                            <th>Email</th>
                                            <th>Qualification</th>
                                            <th>University</th>
                                            <th>Contact</th>
                                            <th>Gender</th>
                                            <th>Birth</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        while($row=$doctorList->fetch_array()) {
                                            ?>
                                            <tr class="doctorRow">
                                                <td>
                                                    <h2 class="table-avatar">

                                                        <a>Dr. <?php echo $row['doc_firstName'] . ' ' . $row['doc_lastName'] ?>
                                                            <span> <?php echo $row['doc_id'] ?> </span></a>
                                                    </h2>
                                                </td>
                                                <td> <?php echo $row['doc_specialization'] ?></td>
                                                <td> <?php echo $row['doc_province'] ?> </td>
                                                <td> <?php echo $row['doc_district'] ?> </td>
                                                <td> <?php echo $row['doc_location'] ?> </td>
                                                <td> <?php echo $row['doc_email'] ?> </td>
                                                <td> <?php echo $row['doc_qualification'] ?> </td>
                                                <td> <?php echo $row['doc_university'] ?> </td>
                                                <td> <?php echo $row['doc_contact'] ?> </td>
                                                <td> <?php echo $row['doc_gender'] ?> </td>
                                                <td> <?php echo $row['doc_birth'] ?> </td>
                                                <td>
                                                    <span class="badge badge-pill bg-success-light"> <?php echo $row['doc_status'] ?></span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="table-action">


                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>


                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/View Doctor Record Tab-->

                    <!--Doctor View By-->
                    <div id="doc-view-by" class="tab-pane fade show doctorListView <?php if ($view==true){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <form method="post" action="view-doctor-records.php?doctorID" style="position: relative; margin-top: 20px;">
                                <div class="row form-row">

                                    <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                        <div class="form-group">

                                            <input type="number" class="form-control" placeholder="enter doctor id here.." name="doc_id" required>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group" style="position: relative;margin-top: 4px;">
                                            <button name="viewbyid" class="btn btn-md bg-success-light">
                                                <i class="far fa-eye"></i> View Record
                                            </button>



                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!---View Doctor Record by name-->
                                <form action="view-doctor-records.php?doctorName" method="post">
                                <div class="row form-row">

                                    <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                        <div class="form-group">

                                            <input type="text" class="form-control <?php if ($msgN==true){echo "bg-danger-light";} ?>" placeholder="enter doctor name here.." name="docName" value="<?php  if (isset($_REQUEST['docName'])){echo $_REQUEST['docName'];} ?>" required>
                                            <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">only letters and white spaces allowed</small>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group" style="position: relative;margin-top: 4px;">
                                            <button  name="viewbyname" class="btn btn-md bg-success-light">
                                                <i class="far fa-eye"></i> View Record
                                            </button>



                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!---View Doctor Record by Speciality-->
                                <form action="view-doctor-records.php?doctorSpeciality" method="post">
                                <div class="row form-row">

                                    <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                        <div class="form-group">

                                            <select class="form-control select" name="docSpeciality">
                                                <option>Select by a speciality</option>
                                                <option>Eye</option>
                                                <option>Dentist</option>
                                                <option>Skin</option>
                                                <option>Primary Care</option>
                                                <option>ENT</option>
                                                <option>Dermatologist</option>
                                                <option>Urology</option>
                                                <option>Neurology</option>
                                                <option>Orthopedic</option>
                                                <option>Cardiologist</option>

                                            </select>
                                            <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgS==false){echo 'd-none'; } ?>">Select a specialization</small>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group" style="position: relative;margin-top: 4px;">
                                            <button name="viewbyspeciality" class="btn btn-md bg-success-light">
                                                <i class="far fa-eye"></i> View Record
                                            </button>



                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!---View Doctor Record by Province-->
                                <form action="view-doctor-records.php?doctorProvince" method="post">
                                <div class="row form-row">

                                    <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                        <div class="form-group">

                                            <select class="form-control select" name="docProvince">
                                                <option>Select by a province</option>
                                                <option>Kabul</option>
                                                <option>Nangarhar</option>
                                                <option>Konar</option>
                                                <option>Nuristan</option>
                                                <option>Laghman</option>
                                                <option>Kabul</option>
                                                <option>Paktia</option>
                                                <option>Paktika</option>
                                                <option>Khost</option>
                                                <option>Logar</option>
                                                <option>Ghazni</option>
                                                <option>Balkh</option>
                                                <option>Herat</option>
                                                <option>Panjshir</option>


                                            </select>
                                            <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgP==false){echo 'd-none'; } ?>">Select a province</small>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group" style="position: relative;margin-top: 4px;">
                                            <button name="viewbyprovince" class="btn btn-md bg-success-light view-doctor-record-2">
                                                <i class="far fa-eye"></i> View Record
                                            </button>



                                        </div>
                                    </div>
                                </div>
                                </form>





                            </div>
                        </div>
                    </div>
                    <!--/Doctor View by-->
                </div>

            </div>
        </div>
    </div>
    <!--/Doctor View Area-->



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


<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>




</body>
</html>
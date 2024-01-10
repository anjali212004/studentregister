
<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';



$queryClasses = "SELECT * FROM tblclass";
$resultClasses = $conn->query($queryClasses);

$querySections = "SELECT * FROM tblclassarms";
$resultSections = $conn->query($querySections);

$querySubjects = "SELECT * FROM tblsubject";
$resultSubjects = $conn->query($querySubjects);

// Process form submission
if (isset($_POST['searchStudents'])) {
    $selectedClassId = $_POST['selectedClass'];
    $selectedSectionId = $_POST['selectedSection'];
    $selectedSubjectId = $_POST['selectedSection'];

    // Fetch details based on the selected options
    $query = "SELECT tblclass.className, tblclassarms.classArmName, tblsubject.Subject
              FROM tblteacher
              INNER JOIN tblclass ON tblclass.Id = tblteacher.classId
              INNER JOIN tblclassarms ON tblclassarms.Id = tblteacher.classArmId
              INNER JOIN tblsubject ON tblsubject.Id = tblteacher.SubjectId
              WHERE tblteacher.Id = '$_SESSION[userId]'
              AND tblteacher.classId = '$selectedClassId'
              AND tblteacher.classArmId = '$selectedSectionId'
              AND tblteacher.SubjectId = '$selectedSubjectId'";

    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $rrw = $rs->fetch_assoc();

    $studentQuery = "SELECT * FROM tblstudents WHERE classId = '$selectedClassId' AND classArmId = '$selectedSectionId'";
    $studentResult = $conn->query($studentQuery);

    // Loop through the results and display student information
    while ($studentRow = $studentResult->fetch_assoc()) {
        // Display student information as needed
        echo "{$studentRow['firstName']} {$studentRow['lastName']}<br>";
    }
}

// Rest of your existing code
?>

<?php
if (isset($_POST['searchStudentss'])) {
    $selectedClass = $_POST['selectedClass'];
    $selectedSection = $_POST['selectedSection'];
    $selectedSubject = $_POST['selectedSubject'];

    // Use these values to fetch students from the database
    $studentQuery = "SELECT * FROM tblstudents WHERE classId = '$selectedClass' AND classArmId = '$selectedSection'";
    $studentResult = $conn->query($studentQuery);

    // Loop through the results and display student information
    while ($studentRow = $studentResult->fetch_assoc()) {
        // Display student information as needed
        echo "{$studentRow['firstName']} {$studentRow['lastName']}<br>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
   <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
           <?php include "Includes/topbar.php";?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Teacher Dashboard</h1> 
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <!-- Add your code for the search bar here -->
         <!-- Add this form at the beginning of your HTML body -->
<form method="post" action="viewStudents.php">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="classSelect">Select Class</label>
            <select class="form-control" id="classSelect" name="selectedClass">
                <!-- Populate this dropdown with your class options from the database -->
                <?php
                $classQuery = "SELECT * FROM tblclass";
                $classResult = $conn->query($classQuery);
                echo'<option value="">--Select Class--</option>';
                while ($classRow = $classResult->fetch_assoc()) {
                    echo "<option value='{$classRow['Id']}'>{$classRow['className']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="sectionSelect">Select Section</label>
            <select class="form-control" id="sectionSelect" name="selectedSection">
                <!-- Populate this dropdown with your section options from the database -->
                <?php
                $sectionQuery = "SELECT * FROM tblclassarms";
                echo'<option value="">--Select Section--</option>';
                $sectionResult = $conn->query($sectionQuery);
                while ($sectionRow = $sectionResult->fetch_assoc()) {
                  
                    echo "<option value='{$sectionRow['Id']}'>{$sectionRow['classArmName']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="subjectSelect">Select Subject</label>
            <select class="form-control" id="subjectSelect" name="selectedSubject">
                <!-- Populate this dropdown with your subject options from the database -->
                <?php
                $subjectQuery = "SELECT * FROM tblsubject";
                echo'<option value="">--Select subject --</option>';
                $subjectResult = $conn->query($subjectQuery);
                while ($subjectRow = $subjectResult->fetch_assoc()) {
                    echo "<option value='{$subjectRow['Id']}'>{$subjectRow['Subject']}</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" name="searchStudents">Search Students</button>
</form>



          <div class="row mb-3">
          <!-- New User Card Example -->
          
          
          <!--Row-->

          <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>Do you like this template ? you can download from <a href="https://github.com/indrijunanda/RuangAdmin"
                  class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>
            </div>
          </div> -->

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <?php include 'includes/footer.php';?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>
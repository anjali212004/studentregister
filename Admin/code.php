<?php

include '../Includes/dbcon.php';
include 'createStudents.php';

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['save_excel_data'])) {
    $file = $_FILES['import_file']['tmp_name'];
    $file_ext = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);

    if ($file_ext == 'xlsx' || $file_ext == 'xls' || $file_ext == 'csv') {
        try {
            $obj = IOFactory::load($file);
            $data = $obj->getActiveSheet()->toArray();
            $dateCreated = date("Y-m-d");

            foreach ($data as $row) {
                if (!empty($row['0']) && !empty($row['1']) && !empty($row['2']) && !empty($row['3']) && !empty($row['4'])) {
                    $firstName = $row['0'];
                    $lastName = $row['1'];
                    $Enrollment_no = $row['2'];
                    $classId = $row['3'];
                    $classArmId = $row['4'];

                    $insert_query = mysqli_query($conn, "INSERT INTO tblstudents(firstName,lastName,Enrollment_no,password,classId,classArmId,dateCreated) 
                    VALUES ('$firstName','$lastName','$Enrollment_no','12345','$classId','$classArmId','$dateCreated')");

                    if (!$insert_query) {
                        throw new Exception(mysqli_error($conn));
                    }
                } else {
                    throw new Exception("Missing data in the Excel file");
                }
            }

            $msg = "File imported successfully";
        } catch (Exception $e) {
            $msg = "Error: " . $e->getMessage();
        }
    } else {
        $msg = "Invalid file format. Please upload an Excel file (xlsx, xls, csv).";
    }

    echo "Debug Message: " . $msg;  // Add this line for debugging

    header("Location: createStudents.php?msg=" . urlencode($msg));
    exit;
}

?>

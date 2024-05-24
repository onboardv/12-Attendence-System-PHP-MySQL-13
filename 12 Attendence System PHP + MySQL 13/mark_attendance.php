<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "teacher") {
    header("Location: index.php");
    exit();
}

$connection = mysqli_connect("localhost", "root", "", "att");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process marked present checkboxes
    if (isset($_POST["mark_present"]) && is_array($_POST["mark_present"])) {
        foreach ($_POST["mark_present"] as $student_id) {
            // Update the attendance record for present
            $update_query = "INSERT INTO attendance (student_id, attendance_date, status) VALUES ('$student_id', NOW(), 'Present')";
            mysqli_query($connection, $update_query);
        }
    }

    // Process marked absent checkboxes
    if (isset($_POST["mark_absent"]) && is_array($_POST["mark_absent"])) {
        foreach ($_POST["mark_absent"] as $student_id) {
            // Update the attendance record for absent
            $update_query = "INSERT INTO attendance (student_id, attendance_date, status) VALUES ('$student_id', NOW(), 'Absent')";
            mysqli_query($connection, $update_query);
        }
    }

    // Redirect back to the attendance page
    header("Location: attendance.php");
    exit();
} else {
    // If someone tries to access this page without submitting the form, redirect them
    header("Location: index.php");
    exit();
}
?>

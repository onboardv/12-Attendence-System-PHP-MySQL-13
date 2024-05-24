<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "student") {
    header("Location: index.php");
    exit();
}

$connection = mysqli_connect("localhost", "root", "", "att");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_SESSION["username"];

// Debugging: Print username
echo "Debug: Username = " . $username . "<br>";

$query = "
    SELECT attendance.attendance_date, attendance.status 
    FROM attendance
    JOIN class_students ON attendance.student_id = class_students.id
    WHERE class_students.username = '$username'
";

// Debugging: Print SQL query
echo "Debug: SQL Query = " . $query . "<br>";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($connection));
}

// Check if there are attendance records
if (mysqli_num_rows($result) > 0) {
    $no_records = false;
} else {
    $no_records = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>
    <h2>Your Attendance</h2>

    <?php if ($no_records): ?>
        <p style="text-align:center;">No attendance records found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["attendance_date"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php endif; ?>

    <!-- Your logout form -->
</body>
</html>

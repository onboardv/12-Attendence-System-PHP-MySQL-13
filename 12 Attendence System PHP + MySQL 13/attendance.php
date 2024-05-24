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

// Example: Retrieve and display attendance records for the teacher...
$query = "SELECT * FROM attendance";
$result = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
        }

        input[type="checkbox"]:checked {
            background-color: #4caf50;
        }

        input[type="checkbox"]:hover {
            background-color: #45a049;
        }

        form:last-child {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Attendance</h2>
    
    <!-- Display attendance records for the teacher... -->
    <table>
        <tr>
            <th>Student ID</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["student_id"] . "</td>";  // Assuming there's a column named 'student_id' in your 'attendance' table
            echo "<td>" . $row["attendance_date"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h2>Mark Attendance</h2>

    <form action="mark_attendance.php" method="post">
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Mark Present</th>
                <th>Mark Absent</th>
            </tr>
            <?php
            // Retrieve students whose attendance is not marked
            $query_students = "SELECT * FROM class_students WHERE roll_number NOT IN (SELECT student_id FROM attendance)";
            $result_students = mysqli_query($connection, $query_students);

            if (!$result_students) {
                die("Error in SQL query for students: " . mysqli_error($connection));
            }

            while ($row_students = mysqli_fetch_assoc($result_students)) {
                echo "<tr>";
                echo "<td>" . $row_students["roll_number"] . "</td>";
                echo "<td>" . $row_students["name"] . "</td>";
                echo "<td><input type='checkbox' name='mark_present[]' value='" . $row_students["roll_number"] . "'></td>";
                echo "<td><input type='checkbox' name='mark_absent[]' value='" . $row_students["roll_number"] . "'></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <input type="submit" value="Submit Attendance">
    </form>

    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>

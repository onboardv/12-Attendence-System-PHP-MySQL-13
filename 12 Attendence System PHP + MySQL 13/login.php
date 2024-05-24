<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correctTeacherUsername = "admin";
    $correctTeacherPassword = password_hash("admin1234", PASSWORD_DEFAULT);  // Hashed password

    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Perform additional validation and checks as needed

    $connection = mysqli_connect("localhost", "root", "", "att");

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($role == "teacher" && $username == $correctTeacherUsername && password_verify($password, $correctTeacherPassword)) {
        $_SESSION["role"] = "teacher";
        header("Location: attendance.php");
        exit();
    } elseif ($role == "student") {
        // Validate student credentials from the database
        $query = "SELECT * FROM class_students WHERE username='$username'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row && password_verify($password, $row["password"])) {
                $_SESSION["role"] = "student";
                $_SESSION["username"] = $username;
                header("Location: student_attendance.php");
                exit();
            }
        }
    }

    // If credentials are invalid, display an error message
    echo "Invalid username, password, or role. Please try again.";

    mysqli_close($connection);
}
?>

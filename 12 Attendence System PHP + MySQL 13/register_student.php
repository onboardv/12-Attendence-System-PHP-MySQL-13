<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="register_student.php" method="post">
        <h2>Student Registration</h2>
        <label for="roll_no">Roll No:</label>
        <input type="text" name="roll_no" required>
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <input type="submit" value="Register">
    </form>
</body>
</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted data
    $roll_number = $_POST["roll_no"];
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform any additional validation or checks as needed

    // You should hash the password before storing it in the database for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the student data into the database (replace with your database connection code)
    $connection = mysqli_connect("localhost", "root", "", "att");

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $insertQuery = "INSERT INTO class_students (roll_number, name, username, password) VALUES ('$roll_number', '$name', '$username', '$hashedPassword')";

    if (mysqli_query($connection, $insertQuery)) {
        echo '<script>alert("Registration successful. You can now log in as a student.");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>

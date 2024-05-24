<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        select,
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        p {
            margin-top: 5px;
            color: #777;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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
    <script>
        function toggleRegistrationLink() {
            var role = document.getElementById("role").value;
            var registerLink = document.getElementById("register-link");

            if (role === "student") {
                registerLink.style.display = "block";
            } else {
                registerLink.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <form action="login.php" method="post">
        <h2>Login</h2>
        <label for="role">Role:</label>
        <select id="role" name="role" required onchange="toggleRegistrationLink()">
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <p id="register-link" style="display: none;">Don't have a student account? <a href="register_student.php">Create one</a></p>
        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php
session_start(); // Start the session

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("Unable to connect");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST["username"];
    $pass = $_POST["password"];
    //Making sure that SQL Injection doesn't work
    $uname = mysqli_real_escape_string($conn, $uname); //test' or '1'='1
    $pass = mysqli_real_escape_string($conn, $pass);
    $sql = "SELECT * FROM user WHERE username = '$uname' AND password = '$pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) >= 1) {
        echo "<br>" . "Welcome, user!" . "<br>";
        $_SESSION['loggedin'] = true; // Set a session variable to indicate login
        header("Location: index.html"); // Redirect to the welcome page
        exit(); // Exit the script to prevent further execution
    } else {
        echo "<br>" . "Incorrect Username/Password" . "<br>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Indie+Flower">
    <style type="text/css">
        body {
            background-image: url('image_6.jpg');
            background-size: cover;
            font-family: 'Indie Flower', cursive;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            padding: 50px;
            border: 2px solid #4285f4;
            border-radius: 5px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.7);
            transition: all 0.3s;
        }

        .container:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.9);
            transition: all 0.3s;
        }

        .container h2 {
            margin: 0 0 20px;
            color: #4285f4;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .container form {
            text-align: center;
        }

        .container p {
            color: #333;
            margin: 30px 0;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 100%;
            border: 2px solid #4285f4;
            transition: all 0.3s;
        }

        input[type="text"]:hover,
        input[type="password"]:hover {
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        input[type="text"]::before,
        input[type="password"]::before {
            content: "";
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 24px;
            height: 24px;
            margin: -12px 0 0 -12px;
            background: url("loading.gif") no-repeat center center;
            background-size: 100%;
            opacity: 0;
            transform: scale(0);
            transition: all 0.3s;
            background: blue;
        }

        input[type="text"]:hover::before,
        input[type="password"]:hover::before {
            opacity: 1;
            transform: scale(1);
        }

        input[type="submit"] {
            padding: 12px;
            border: none;
            background-color: #4285f4;
            color: white;
            font-weight: 600;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #3579d8;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
    <script type="text/javascript">
        function validateForm() {
            var username = document.forms["loginForm"]["username"].value;
            var password = document.forms["loginForm"]["password"].value;

            if (username.trim() == "") {
                alert("Please enter a username.");
                return false;
            }

            if (password.trim() == "") {
                alert("Please enter a password.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <br>
    <div class="container">
        <h2>Login Portal</h2>
        <form name="loginForm" action="" method="POST" autocomplete="off" onsubmit="return validateForm()">
            <input type="text" name="username" placeholder="Username" /><br />
            <input type="password" name="password" placeholder="Password" /><br />
            <input type="submit" name="login" value="LOGIN" />
        </form>
        <br>
    </div>
    <br>
</body>
</html>
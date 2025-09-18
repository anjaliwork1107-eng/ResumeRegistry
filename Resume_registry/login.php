<?php
session_start();
require_once "DB.php";
require_once "util.php";

$salt = 'XyZzy12*_';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlentities($_POST['email']);
    $pass = htmlentities($_POST['pass']);

    if ($email == '' || $pass == '') {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        exit();
    }

    $check = hash('md5', $salt . $pass);
    $stmt = $pdo->prepare("SELECT user_id, name FROM users WHERE email = :em AND password = :pw");
    $stmt->execute([':em' => $email, ':pw' => $check]);
    $row = $stmt->fetch();

    if ($row !== false) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['success'] = "Login successful";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Incorrect email or password";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Registry - Login</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: 'Lora', serif;
            background: linear-gradient(to bottom right, #fdf6f8, #f4f4f4);
            color: #5a4e4d;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        header {
            flex: 0 0 auto;
            background-color: #e8d1d1;
            color: #3e2c2c;
            padding: 20px 40px;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #d8bcbc;
        }

        main {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 40px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #a85c7a;
            font-weight: 500;
        }

        .welcome h3 {
            font-size: 22px;
            color: #a85c7a;
            margin-bottom: 10px;
        }

        form {
            max-width: 600px;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: 600;
            color: #6b4f4f;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #c8b4b4;
            border-radius: 6px;
            font-size: 15px;
            background-color: #fffafc;
        }

        input[type="submit"] {
            margin-top: 30px;
            padding: 12px 20px;
            background-color: #a85c7a;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #8c4a64;
        }

        .link {
            display: inline-block;
            margin-top: 20px;
            font-size: 14px;
            color: #a85c7a;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
        }

        .message .error {
            color: #c0392b;
        }

        .message .success {
            color: #27ae60;
        }

        footer {
            flex: 0 0 auto;
            padding: 20px 40px;
            background-color: #f1e6e6;
            font-size: 14px;
            color: #7f8c8d;
            text-align: center;
            border-top: 1px solid #d8bcbc;
        }
    </style>
</head>
<body>
    <header>
        Resume Registry
    </header>

    <main>
      

    

        <form method="post">
            <label for="id_email">Email</label>
            <input type="text" name="email" id="id_email">

            <label for="id_1723">Password</label>
            <input type="password" name="pass" id="id_1723">

            <input type="submit" onclick="return doValidate();" value="Log In">
        </form>

        <a class="link" href="register.php">Need an account? Register here</a>
    </main>

    <footer>
        Designed for women who lead with grace and ambition.
    </footer>

    <script>
    function doValidate() {
        let email = document.getElementById('id_email').value;
        let pw = document.getElementById('id_1723').value;
        if (!email || !pw) {
            alert("Both fields must be filled out");
            return false;
        }
        if (!email.includes('@')) {
            alert("Email address must contain @");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
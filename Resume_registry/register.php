<?php
session_start();
require_once "DB.php";
require_once "util.php";

$salt = 'XyZzy12*_';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $pass = htmlentities($_POST['pass']);

    if ($name == '' || $email == '' || $pass == '') {
        $_SESSION['error'] = "All fields are required";
        header("Location: register.php");
        exit();
    }

    $hashed = hash('md5', $salt . $pass);

    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = "Email already registered";
        header("Location: register.php");
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :pass)");
    $stmt->execute([':name' => $name, ':email' => $email, ':pass' => $hashed]);

    $_SESSION['success'] = "Registration successful. Please log in.";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Registry - Register</title>
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
        input[type="email"],
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
        <h1>Create Your Account</h1>

        <div class="message">
            <?php flashMessages(); ?>
        </div>

        <form method="post">
            <label for="name">Name</label>
            <input type="text" name="name" id="name">

            <label for="email">Email</label>
            <input type="email" name="email" id="email">

            <label for="pass">Password</label>
            <input type="password" name="pass" id="pass">

            <input type="submit" value="Register">
        </form>

        <a class="link" href="login.php">Already have an account? Log in here</a>
    </main>

    <footer>
        Designed for women who lead with grace and ambition.
    </footer>
</body>
</html>
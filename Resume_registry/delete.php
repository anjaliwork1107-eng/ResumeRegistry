<?php
session_start();
require_once "DB.php";
require_once "util.php";
checkLogin();

if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header("Location: index.php");
    exit();
}

$profile_id = $_GET['profile_id'];

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid");
$stmt->execute([':pid' => $profile_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile || $profile['user_id'] != $_SESSION['user_id']) {
    die("Access denied");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("DELETE FROM Profile WHERE profile_id = :pid");
    $stmt->execute([':pid' => $profile_id]);

    $_SESSION['success'] = "Profile deleted";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Registry - Delete Profile</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
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
            padding: 40px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #a85c7a;
            font-weight: 500;
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        form {
            max-width: 600px;
        }

        input[type="submit"] {
            margin-top: 10px;
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

        a {
            display: inline-block;
            margin-top: 20px;
            font-size: 14px;
            color: #a85c7a;
            text-decoration: none;
        }

        a:hover {
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
        <h1>Confirm Delete</h1>

        <div class="message">
            <?php flashMessages(); ?>
        </div>

        <p>Are you sure you want to delete profile for <?= htmlentities($profile['first_name'] . ' ' . $profile['last_name']) ?>?</p>

        <form method="post">
            <input type="submit" value="Delete">
            <a href="index.php">Cancel</a>
        </form>
    </main>

    <footer>
        Designed for women who lead with grace and ambition.
    </footer>
</body>
</html>
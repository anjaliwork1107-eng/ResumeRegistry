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
    $fn = htmlentities($_POST['first_name']);
    $ln = htmlentities($_POST['last_name']);
    $em = htmlentities($_POST['email']);
    $he = htmlentities($_POST['headline']);
    $su = htmlentities($_POST['summary']);

    if ($fn == '' || $ln == '' || $em == '' || $he == '' || $su == '') {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?profile_id=$profile_id");
        exit();
    }

    $stmt = $pdo->prepare("UPDATE Profile 
        SET first_name = :fn, last_name = :ln, email = :em, headline = :he, summary = :su 
        WHERE profile_id = :pid");
    $stmt->execute([
        ':fn' => $fn,
        ':ln' => $ln,
        ':em' => $em,
        ':he' => $he,
        ':su' => $su,
        ':pid' => $profile_id
    ]);

    $_SESSION['success'] = "Profile updated";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Registry - Edit Profile</title>
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
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #c8b4b4;
            border-radius: 6px;
            font-size: 15px;
            background-color: #fffafc;
        }

        textarea {
            resize: vertical;
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
        <h1>Edit Profile</h1>

        <div class="message">
            <?php flashMessages(); ?>
        </div>

        <form method="post">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?= htmlentities($profile['first_name']) ?>">

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?= htmlentities($profile['last_name']) ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlentities($profile['email']) ?>">

            <label for="headline">Headline</label>
            <input type="text" name="headline" id="headline" value="<?= htmlentities($profile['headline']) ?>">

            <label for="summary">Summary</label>
            <textarea name="summary" id="summary" rows="6"><?= htmlentities($profile['summary']) ?></textarea>

            <input type="submit" value="Save">
            <a class="link" href="index.php">Cancel</a>
        </form>
    </main>

    <footer>
        Designed for women who lead with grace and ambition.
    </footer>
</body>
</html>
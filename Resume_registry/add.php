<?php
session_start();
require_once "DB.php";
require_once "util.php";
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fn = $_POST['first_name'];
    $ln = $_POST['last_name'];
    $em = $_POST['email'];
    $he = $_POST['headline'];
    $su = $_POST['summary'];

    if ($fn == '' || $ln == '' || $em == '' || $he == '' || $su == '') {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        exit();
    }

    if (strpos($em, '@') === false) {
        $_SESSION['error'] = "Email address must contain @";
        header("Location: add.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary)
                               VALUES (:uid, :fn, :ln, :em, :he, :su)");
        $stmt->execute([
            ':uid' => $_SESSION['user_id'],
            ':fn' => $fn,
            ':ln' => $ln,
            ':em' => $em,
            ':he' => $he,
            ':su' => $su
        ]);
        $_SESSION['success'] = "Profile added";
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: add.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Registry - Add Profile</title>
    <style>
        html, body {
            
            margin: 0;
    padding: 0;
    height: 100%;
    overflow-y: auto; /* Enables vertical scrolling */
    overflow-x: hidden; /* Prevents horizontal scroll */
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
        <h1>Add Profile</h1>

        <div class="message">
            <?php flashMessages(); ?>
        </div>

        <form method="post">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name">

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name">

            <label for="email">Email</label>
            <input type="text" name="email" id="email">

            <label for="headline">Headline</label>
            <input type="text" name="headline" id="headline">

            <label for="summary">Summary</label>
            <textarea name="summary" id="summary" rows="6"></textarea>

            <input type="submit" value="Add">
            <a class="link" href="index.php">Cancel</a>
        </form>
    </main>

    <footer>
        Designed for women who lead with grace and ambition.
    </footer>
</body>
</html>
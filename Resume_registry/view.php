<?php
require_once "DB.php";

if (!isset($_GET['profile_id'])) {
    die("Missing profile_id");
}

$profile_id = $_GET['profile_id'];

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid");
$stmt->execute([':pid' => $profile_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
    die("Profile not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Registry - View Profile</title>
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
            margin-bottom: 15px;
            line-height: 1.6;
        }

        strong {
            color: #6b4f4f;
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
        <h1>Profile Details</h1>
        <p><strong>Name:</strong> <?= htmlentities($profile['first_name'] . ' ' . $profile['last_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlentities($profile['email']) ?></p>
        <p><strong>Headline:</strong> <?= htmlentities($profile['headline']) ?></p>
        <p><strong>Summary:</strong><br><?= nl2br(htmlentities($profile['summary'])) ?></p>
        <a href="index.php">Back</a>
    </main>

    <footer>
        Designed for women who lead with grace and ambition.
    </footer>
</body>
</html>
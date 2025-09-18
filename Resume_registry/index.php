<?php
session_start();
require_once "DB.php";
require_once "util.php";


$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, headline FROM Profile");
$profiles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Registry</title>
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
            padding: 40px;
            overflow-y: auto;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #a85c7a;
            font-weight: 500;
        }

        .welcome {
            font-size: 22px;
            color: #a85c7a;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .message {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .message .error {
            color: #c0392b;
        }

        .message .success {
            color: #27ae60;
        }

        .actions {
            margin-bottom: 20px;
        }

        .actions a {
            text-decoration: none;
            color: #a85c7a;
            font-weight: 500;
            margin-right: 15px;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #d8bcbc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f1e6e6;
            color: #6b4f4f;
        }

        td a {
            color: #6f42c1;
            text-decoration: none;
            margin-right: 10px;
        }

        td a:hover {
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
        <?php if (isset($_SESSION['name'])): ?>
            <div class="welcome">Welcome back, <?= htmlentities($_SESSION['name']) ?> 💼</div>
        <?php endif; ?>

        <div class="message">
            <?php flashMessages(); ?>
        </div>

        <div class="actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="add.php">➕ Add New Entry</a>
                <a href="logout.php">🚪 Logout</a>
            <?php else: ?>
                <a href="login.php">🔐 Please log in</a>
            <?php endif; ?>
        </div>

        <table>
            <tr>
                <th>Name</th>
                <th>Headline</th>
                <th>Action</th>
            </tr>
            <?php foreach ($profiles as $row): ?>
                <tr>
                    <td><?= htmlentities($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlentities($row['headline']) ?></td>
                    <td>
                        <a href="view.php?profile_id=<?= $row['profile_id'] ?>">View</a>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']): ?>
                            <a href="edit.php?profile_id=<?= $row['profile_id'] ?>">Edit</a>
                            <a href="delete.php?profile_id=<?= $row['profile_id'] ?>">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>

    <footer>
        Designed for women who lead with grace and ambition.
    </footer>
</body>
</html>
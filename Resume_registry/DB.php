<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=resume_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("DB Connection Error: " . $e->getMessage());
    echo "Internal error. Please try again later.";
    exit();
}
?>
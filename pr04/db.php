<?php
$dsn = 'mysql:host=localhost;dbname=practicum4;charset=utf8mb4';

try {
    $pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Не вдалося підключитися до бази даних: ' . htmlspecialchars($e->getMessage()));
}

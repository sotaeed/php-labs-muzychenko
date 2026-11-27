<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/workouts.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$values = readWorkoutPost();
$errors = validateWorkout($values);

if (empty($errors)) {
    addWorkout(
        $pdo,
        $values['type'],
        (int) $values['duration_min'],
        (int) $values['calories_burned'],
        $values['workout_date']
    );
    header('Location: index.php');
    exit;
}

$formAction  = 'add.php';
$submitLabel = 'Додати тренування';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нове тренування</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Нове тренування</h1>
    <?php require __DIR__ . '/_form.php'; ?>
    <p><a href="index.php">← Назад до списку</a></p>
</body>
</html>

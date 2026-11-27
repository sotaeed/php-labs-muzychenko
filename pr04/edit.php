<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/workouts.php';

$id = (int) ($_GET['id'] ?? 0);
$workout = findWorkoutById($pdo, $id);

if ($workout === null) {
    http_response_code(404);
    echo 'Тренування не знайдено. <a href="index.php">До списку</a>';
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = readWorkoutPost();
    $errors = validateWorkout($values);

    if (empty($errors)) {
        updateWorkout(
            $pdo,
            $id,
            $values['type'],
            (int) $values['duration_min'],
            (int) $values['calories_burned'],
            $values['workout_date']
        );
        header('Location: index.php');
        exit;
    }
} else {
    $values = [
        'type'            => (string) $workout['type'],
        'duration_min'    => (string) $workout['duration_min'],
        'calories_burned' => (string) $workout['calories_burned'],
        'workout_date'    => (string) $workout['workout_date'],
    ];
}

$formAction  = 'edit.php?id=' . $id;
$submitLabel = 'Зберегти зміни';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагування тренування</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Редагування тренування #<?= $id ?></h1>
    <?php require __DIR__ . '/_form.php'; ?>
    <p><a href="index.php">← Назад до списку</a></p>
</body>
</html>

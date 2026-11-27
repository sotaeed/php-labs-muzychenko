<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/classes/Workout.php';
require_once __DIR__ . '/classes/CardioWorkout.php';
require_once __DIR__ . '/classes/TrainingLog.php';
require_once __DIR__ . '/lib/functions.php';

$log = new TrainingLog();

$log->addWorkout(new Workout('Силове', 40, 300, '2026-11-24'));
$log->addWorkout(new Workout('Йога', 45, 180, '2026-11-20'));
$log->addWorkout(new Workout('Плавання', 60, 480, '2026-11-18'));
$log->addWorkout(new CardioWorkout('Біг', 30, 320, '2026-11-16', 5.0, 152));
$log->addWorkout(new CardioWorkout('Велосипед', 90, 650, '2026-11-22', 28.5, 138));
$log->addWorkout(new CardioWorkout('Біг', 50, 520, '2026-11-25', 8.2, 158));

$workouts = $log->getAll();
$runs = $log->findByType('Біг');
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Журнал тренувань</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Журнал тренувань</h1>
    <table>
        <thead>
            <tr>
                <th>№</th>
                <th>Клас</th>
                <th>Опис</th>
                <th>Тривалість</th>
                <th>Темп</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workouts as $i => $workout): ?>
                <?php $isCardio = $workout instanceof CardioWorkout; ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="<?= $isCardio ? 'cardio' : 'base' ?>">
                        <?= $isCardio ? 'CardioWorkout' : 'Workout' ?>
                    </td>
                    <td><?= htmlspecialchars($workout->getInfo()) ?></td>
                    <td><?= htmlspecialchars(formatDuration($workout->getDurationMin())) ?></td>
                    <td>
                        <?= $isCardio
                            ? htmlspecialchars(calcPace($workout->getDurationMin(), $workout->getDistanceKm()))
                            : '—' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="summary">
        <p>Усього тренувань: <strong><?= count($workouts) ?></strong></p>
        <p>Сумарно спалено калорій: <strong><?= $log->totalCalories() ?> ккал</strong></p>
        <p>Тренувань типу «Біг»: <strong><?= count($runs) ?></strong></p>
    </div>
</body>
</html>
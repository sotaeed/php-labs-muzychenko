<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$workouts = [
    ['type' => 'Біг',          'durationMin' => 30, 'caloriesBurned' => 320, 'date' => '2026-11-16'],
    ['type' => 'Плавання',     'durationMin' => 60, 'caloriesBurned' => 480, 'date' => '2026-11-18'],
    ['type' => 'Йога',         'durationMin' => 45, 'caloriesBurned' => 180, 'date' => '2026-11-20'],
    ['type' => 'Велосипед',    'durationMin' => 90, 'caloriesBurned' => 650, 'date' => '2026-11-22'],
    ['type' => 'Силове',       'durationMin' => 40, 'caloriesBurned' => 300, 'date' => '2026-11-24'],
];

function formatWorkout(array $workout): string {
    return "{$workout['type']}: {$workout['durationMin']} хв, {$workout['caloriesBurned']} ккал";
}

function getDurationLabel(array $workout): string {
    if ($workout['durationMin'] >= 45) {
        return 'Довге тренування';
    } else {
        return 'Коротке';
    }
}
$totalCalories = array_sum(array_column($workouts, 'caloriesBurned'));
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фітнес-трекер</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Фітнес-трекер: мої тренування</h1>

    <table>
        <thead>
            <tr>
                <th>№</th>
                <th>Дата</th>
                <th>Опис</th>
                <th>Тип тренування</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workouts as $i => $workout): ?>
                <?php $label = getDurationLabel($workout); ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($workout['date']) ?></td>
                    <td><?= htmlspecialchars(formatWorkout($workout)) ?></td>
                    <td class="<?= $label === 'Коротке' ? 'short' : 'long' ?>">
                        <?= htmlspecialchars($label) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="summary">
        <p>Усього тренувань: <strong><?= count($workouts) ?></strong></p>
        <p>Сумарно спалено калорій: <strong><?= $totalCalories ?> ккал</strong></p>
    </div>
</body>
</html>
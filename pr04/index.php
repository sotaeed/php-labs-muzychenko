<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/workouts.php';

$filterType = trim($_GET['type'] ?? '');
$workouts = $filterType !== '' ? findByType($pdo, $filterType) : getAllWorkouts($pdo);
$total = totalCalories($pdo);

$formAction  = 'add.php';
$submitLabel = 'Додати тренування';
$errors      = [];
$values      = ['type' => '', 'duration_min' => '', 'calories_burned' => '', 'workout_date' => date('Y-m-d')];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фітнес-трекер (БД)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Фітнес-трекер</h1>

    <form method="get" action="index.php" class="filter">
        <label for="filter-type">Фільтр за типом:</label>
        <input type="text" id="filter-type" name="type" value="<?= e($filterType) ?>" placeholder="наприклад, Біг">
        <button type="submit">Знайти</button>
        <?php if ($filterType !== ''): ?><a href="index.php">Скинути</a><?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Тип</th>
                <th>Тривалість, хв</th>
                <th>Калорії, ккал</th>
                <th>Дата</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($workouts)): ?>
                <tr><td colspan="6">Тренувань не знайдено.</td></tr>
            <?php endif; ?>
            <?php foreach ($workouts as $w): ?>
                <tr>
                    <td><?= e($w['id']) ?></td>
                    <td><?= e($w['type']) ?></td>
                    <td><?= e($w['duration_min']) ?></td>
                    <td><?= e($w['calories_burned']) ?></td>
                    <td><?= e($w['workout_date']) ?></td>
                    <td class="actions">
                        <a href="edit.php?id=<?= (int) $w['id'] ?>">Редагувати</a>
                        <form method="post" action="delete.php"
                              onsubmit="return confirm('Видалити це тренування?');">
                            <input type="hidden" name="id" value="<?= (int) $w['id'] ?>">
                            <button type="submit" class="danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="summary">
        <p>Показано записів: <strong><?= count($workouts) ?></strong></p>
        <p>Сумарно спалено калорій (усі тренування): <strong><?= $total ?> ккал</strong></p>
    </div>

    <h2>Нове тренування</h2>
    <?php require __DIR__ . '/_form.php'; ?>
</body>
</html>

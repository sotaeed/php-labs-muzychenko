<?php
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function getAllWorkouts(PDO $pdo): array
{
    return $pdo->query('SELECT * FROM workouts ORDER BY workout_date DESC, id DESC')->fetchAll();
}

function findByType(PDO $pdo, string $type): array
{
    $stmt = $pdo->prepare('SELECT * FROM workouts WHERE type = :type ORDER BY workout_date DESC, id DESC');
    $stmt->execute([':type' => $type]);
    return $stmt->fetchAll();
}

function totalCalories(PDO $pdo): int
{
    $row = $pdo->query('SELECT SUM(calories_burned) AS total FROM workouts')->fetch();
    return (int) ($row['total'] ?? 0);
}

function findWorkoutById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM workouts WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row === false ? null : $row;
}

function addWorkout(PDO $pdo, string $type, int $durationMin, int $caloriesBurned, string $date): int
{
    $stmt = $pdo->prepare(
        'INSERT INTO workouts (type, duration_min, calories_burned, workout_date)
         VALUES (:type, :duration_min, :calories_burned, :workout_date)'
    );
    $stmt->execute([
        ':type'            => $type,
        ':duration_min'    => $durationMin,
        ':calories_burned' => $caloriesBurned,
        ':workout_date'    => $date,
    ]);
    return (int) $pdo->lastInsertId();
}

function updateWorkout(PDO $pdo, int $id, string $type, int $durationMin, int $caloriesBurned, string $date): int
{
    $stmt = $pdo->prepare(
        'UPDATE workouts
         SET type = :type, duration_min = :duration_min,
             calories_burned = :calories_burned, workout_date = :workout_date
         WHERE id = :id'
    );
    $stmt->execute([
        ':type'            => $type,
        ':duration_min'    => $durationMin,
        ':calories_burned' => $caloriesBurned,
        ':workout_date'    => $date,
        ':id'              => $id,
    ]);
    return $stmt->rowCount();
}

function deleteWorkout(PDO $pdo, int $id): int
{
    $stmt = $pdo->prepare('DELETE FROM workouts WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->rowCount();
}

function validateWorkout(array $d): array
{
    $errors = [];

    if ($d['type'] === '') {
        $errors['type'] = 'Вкажіть тип тренування.';
    } elseif (mb_strlen($d['type']) > 50) {
        $errors['type'] = 'Тип тренування не може бути довшим за 50 символів.';
    }

    if ($d['duration_min'] === '' || !ctype_digit($d['duration_min'])
        || (int) $d['duration_min'] < 1 || (int) $d['duration_min'] > 300) {
        $errors['duration_min'] = 'Тривалість має бути цілим числом від 1 до 300.';
    }

    if ($d['calories_burned'] === '' || !ctype_digit($d['calories_burned'])) {
        $errors['calories_burned'] = 'Калорії мають бути цілим невід\'ємним числом.';
    }

    $dateObj = DateTime::createFromFormat('Y-m-d', $d['workout_date']);
    if ($dateObj === false || $dateObj->format('Y-m-d') !== $d['workout_date']) {
        $errors['workout_date'] = 'Вкажіть коректну дату.';
    } elseif ($d['workout_date'] > date('Y-m-d')) {
        $errors['workout_date'] = 'Дата не може бути пізнішою за сьогоднішню.';
    }

    return $errors;
}

function readWorkoutPost(): array
{
    return [
        'type'            => trim($_POST['type'] ?? ''),
        'duration_min'    => trim($_POST['duration_min'] ?? ''),
        'calories_burned' => trim($_POST['calories_burned'] ?? ''),
        'workout_date'    => trim($_POST['workout_date'] ?? ''),
    ];
}

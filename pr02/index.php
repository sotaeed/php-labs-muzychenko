<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$allowedTypes = ['Біг', 'Плавання', 'Йога', 'Велосипед', 'Силове'];

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$errors = [];
$accepted = false;
$type = '';
$durationMin = '';
$caloriesBurned = '';
$date = '';

if ($isPost) {
    $type           = trim($_POST['type'] ?? '');
    $durationMin    = trim($_POST['durationMin'] ?? '');
    $caloriesBurned = trim($_POST['caloriesBurned'] ?? '');
    $date           = trim($_POST['date'] ?? '');

    if (!in_array($type, $allowedTypes, true)) {
        $errors['type'] = 'Оберіть тип тренування зі списку.';
    }

    if ($durationMin === '' || !is_numeric($durationMin)) {
        $errors['durationMin'] = 'Тривалість має бути числом.';
    } elseif ($durationMin < 1 || $durationMin > 300) {
        $errors['durationMin'] = 'Тривалість має бути від 1 до 300 хвилин.';
    }

    if ($caloriesBurned === '' || !ctype_digit($caloriesBurned)) {
        $errors['caloriesBurned'] = 'Калорії мають бути цілим невід\'ємним числом.';
    }

    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    if ($dateObj === false || $dateObj->format('Y-m-d') !== $date) {
        $errors['date'] = 'Вкажіть коректну дату.';
    } elseif ($date > date('Y-m-d')) {
        $errors['date'] = 'Дата не може бути у майбутньому.';
    }

    $accepted = empty($errors);
}
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

<?php if ($accepted): ?>
    <div class="success">
        <p><strong>Дані прийнято!</strong></p>
        <ul>
            <li>Тип: <?= e($type) ?></li>
            <li>Тривалість: <?= e($durationMin) ?> хв</li>
            <li>Спалено калорій: <?= e($caloriesBurned) ?> ккал</li>
            <li>Дата: <?= e($date) ?></li>
        </ul>
    </div>
    <p><a href="index.php">Додати ще одне тренування</a></p>

<?php else: ?>
    <form id="workoutForm" method="post" action="index.php">
        <label for="type">Тип тренування</label>
        <select id="type" name="type" required class="<?= isset($errors['type']) ? 'field-invalid' : '' ?>">
            <option value="">— оберіть тип —</option>
            <?php foreach ($allowedTypes as $t): ?>
                <option value="<?= e($t) ?>" <?= $type === $t ? 'selected' : '' ?>><?= e($t) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['type'])): ?>
            <span class="error"><?= e($errors['type']) ?></span>
        <?php endif; ?>

        <label for="durationMin">Тривалість (хв)</label>
        <input type="number" id="durationMin" name="durationMin" min="1" max="300" required
               value="<?= e($durationMin) ?>" class="<?= isset($errors['durationMin']) ? 'field-invalid' : '' ?>">
        <?php if (isset($errors['durationMin'])): ?>
            <span class="error"><?= e($errors['durationMin']) ?></span>
        <?php endif; ?>

        <label for="caloriesBurned">Спалено калорій (ккал)</label>
        <input type="number" id="caloriesBurned" name="caloriesBurned" min="0" step="1" required
               value="<?= e($caloriesBurned) ?>" class="<?= isset($errors['caloriesBurned']) ? 'field-invalid' : '' ?>">
        <?php if (isset($errors['caloriesBurned'])): ?>
            <span class="error"><?= e($errors['caloriesBurned']) ?></span>
        <?php endif; ?>

        <label for="date">Дата</label>
        <input type="date" id="date" name="date" max="<?= date('Y-m-d') ?>" required
               value="<?= e($date) ?>" class="<?= isset($errors['date']) ? 'field-invalid' : '' ?>">
        <?php if (isset($errors['date'])): ?>
            <span class="error"><?= e($errors['date']) ?></span>
        <?php endif; ?>

        <div id="clientErrors"></div>

        <button type="submit">Зберегти тренування</button>
    </form>

    <script>
        const form = document.getElementById('workoutForm');
        const typeSelect = document.getElementById('type');
        const clientErrors = document.getElementById('clientErrors');
        const wasSubmitted = <?= $isPost ? 'true' : 'false' ?>;

        try {
            const saved = localStorage.getItem('lastWorkoutType');
            const exists = Array.from(typeSelect.options).some(o => o.value === saved);
            if (!wasSubmitted && saved && exists) {
                typeSelect.value = saved;
            }
        } catch (err) {
            console.warn('localStorage недоступний', err);
        }

        typeSelect.addEventListener('change', () => {
            try {
                if (typeSelect.value !== '') {
                    localStorage.setItem('lastWorkoutType', typeSelect.value);
                }
            } catch (err) {
                console.warn('localStorage недоступний', err);
            }
        });

        form.addEventListener('submit', (event) => {
            const messages = [];
            const duration = Number(document.getElementById('durationMin').value);
            const dateValue = document.getElementById('date').value;
            const today = new Date().toISOString().slice(0, 10);

            if (!Number.isFinite(duration) || duration < 1 || duration > 300) {
                messages.push('Тривалість від 1 до 300 хвилин.');
            }
            if (dateValue === '') {
                messages.push('Вкажіть дату.');
            } else if (dateValue > today) {
                messages.push('Дата не може бути у майбутньому.');
            }

            if (messages.length > 0) {
                event.preventDefault();
                clientErrors.textContent = messages.join(' ');
            } else {
                clientErrors.textContent = '';
            }
        });
    </script>
<?php endif; ?>
</body>
</html>
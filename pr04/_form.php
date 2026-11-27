<?php
?>
<form method="post" action="<?= e($formAction) ?>" class="workout-form">
    <label for="type">Тип тренування</label>
    <input type="text" id="type" name="type" list="types" maxlength="50" required
           value="<?= e($values['type']) ?>">
    <datalist id="types">
        <option value="Біг">
        <option value="Плавання">
        <option value="Йога">
        <option value="Велосипед">
        <option value="Силове">
    </datalist>
    <?php if (isset($errors['type'])): ?><span class="error"><?= e($errors['type']) ?></span><?php endif; ?>

    <label for="duration_min">Тривалість (хв)</label>
    <input type="number" id="duration_min" name="duration_min" min="1" max="300" required
           value="<?= e($values['duration_min']) ?>">
    <?php if (isset($errors['duration_min'])): ?><span class="error"><?= e($errors['duration_min']) ?></span><?php endif; ?>

    <label for="calories_burned">Спалено калорій (ккал)</label>
    <input type="number" id="calories_burned" name="calories_burned" min="0" step="1" required
           value="<?= e($values['calories_burned']) ?>">
    <?php if (isset($errors['calories_burned'])): ?><span class="error"><?= e($errors['calories_burned']) ?></span><?php endif; ?>

    <label for="workout_date">Дата</label>
    <input type="date" id="workout_date" name="workout_date" max="<?= date('Y-m-d') ?>" required
           value="<?= e($values['workout_date']) ?>">
    <?php if (isset($errors['workout_date'])): ?><span class="error"><?= e($errors['workout_date']) ?></span><?php endif; ?>

    <button type="submit"><?= e($submitLabel) ?></button>
</form>

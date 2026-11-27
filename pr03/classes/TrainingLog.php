<?php
require_once __DIR__ . '/Workout.php';
class TrainingLog
{
    private array $workouts = [];

    public function addWorkout(Workout $workout): void
    {
        $this->workouts[] = $workout;
    }

    public function getAll(): array
    {
        return $this->workouts;
    }

    public function totalCalories(): int
    {
        $total = 0;
        foreach ($this->workouts as $workout) {
            $total += $workout->getCaloriesBurned();
        }
        return $total;
    }

    public function findByType(string $type): array
    {
        return array_values(array_filter(
            $this->workouts,
            fn(Workout $w) => $w->getType() === $type
        ));
    }
}
<?php
require_once __DIR__ . '/Workout.php';
class CardioWorkout extends Workout
{
    private float $distanceKm;
    private int $avgHeartRate;

    public function __construct(
        string $type,
        int $durationMin,
        int $caloriesBurned,
        string $date,
        float $distanceKm,
        int $avgHeartRate
    ) {
        parent::__construct($type, $durationMin, $caloriesBurned, $date);
        $this->distanceKm = $distanceKm;
        $this->avgHeartRate = $avgHeartRate;
    }

    public function getDistanceKm(): float
    {
        return $this->distanceKm;
    }

    public function getAvgHeartRate(): int
    {
        return $this->avgHeartRate;
    }

    public function getInfo(): string
    {
        return parent::getInfo() . ", дистанція {$this->distanceKm} км, середній пульс {$this->avgHeartRate} уд/хв";
    }
}
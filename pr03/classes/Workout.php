<?php
class Workout
{
    protected string $type;
    protected int $durationMin;
    protected int $caloriesBurned;
    private string $date;

    public function __construct(string $type, int $durationMin, int $caloriesBurned, string $date)
    {
        $this->type = $type;
        $this->durationMin = $durationMin;
        $this->caloriesBurned = $caloriesBurned;
        $this->date = $date;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDurationMin(): int
    {
        return $this->durationMin;
    }

    public function getCaloriesBurned(): int
    {
        return $this->caloriesBurned;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getInfo(): string
    {
        return "{$this->type}: {$this->durationMin} хв, {$this->caloriesBurned} ккал, {$this->date}";
    }
}
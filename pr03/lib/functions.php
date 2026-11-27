<?php
function formatDuration(int $minutes): string
{
    $hours = intdiv($minutes, 60);
    $mins = $minutes % 60;

    if ($hours === 0) {
        return "{$mins} хв";
    }
    if ($mins === 0) {
        return "{$hours} год";
    }
    return "{$hours} год {$mins} хв";
}

function calcPace(int $durationMin, float $distanceKm): string
{
    if ($distanceKm <= 0) {
        return '—';
    }

    $paceMinutes = $durationMin / $distanceKm;
    $wholeMinutes = (int) floor($paceMinutes);
    $seconds = (int) round(($paceMinutes - $wholeMinutes) * 60);

    if ($seconds === 60) {
        $wholeMinutes++;
        $seconds = 0;
    }

    return sprintf('%d:%02d хв/км', $wholeMinutes, $seconds);
}
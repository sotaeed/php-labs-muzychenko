CREATE DATABASE IF NOT EXISTS practicum4
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE practicum4;

CREATE TABLE IF NOT EXISTS workouts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    duration_min INT NOT NULL,
    calories_burned INT NOT NULL,
    workout_date DATE NOT NULL
);

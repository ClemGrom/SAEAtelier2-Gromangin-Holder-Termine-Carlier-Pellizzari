<?php

namespace geoquiz\api\domain\dto;

use geoquiz\api\domain\entities\Difficulty_Levels;

class Difficulty_LevelsDTO extends DTO
{
    public string $difficulty_id;
    public string $level_name;
    public string $description;
    public float $distance_threshold;
    public int $time_limit;

    public function __construct(string $difficulty_id, string $level_name, string $description, float $distance_threshold, int $time_limit)
    {
        $this->difficulty_id = $difficulty_id;
        $this->level_name = $level_name;
        $this->description = $description;
        $this->distance_threshold = $distance_threshold;
        $this->time_limit = $time_limit;
    }

    public function toModel() : Difficulty_Levels
    {
        return Difficulty_Levels::findOr($this->difficulty_id, function () {
            $newDifficultyLevel = new Difficulty_Levels();
            $newDifficultyLevel->difficulty_id = $this->difficulty_id;
            return $newDifficultyLevel;
        })->fill([
            'level_name' => $this->level_name,
            'description' => $this->description,
            'distance_threshold' => $this->distance_threshold,
            'time_limit' => $this->time_limit
        ]);
    }
}
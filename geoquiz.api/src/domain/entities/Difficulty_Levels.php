<?php

namespace geoquiz\api\domain\entities;

use geoquiz\api\domain\dto\Difficulty_LevelsDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Difficulty_Levels extends Model
{
    protected $table = 'difficulty_levels';
    protected $primaryKey = 'difficulty_id';
    public $timestamps = false;
    protected $fillable = ['level_name', 'description', 'distance_threshold', 'time_limit'];

    public function games(): HasMany
    {
        return $this->hasMany('geoquiz\api\domain\entities\Games', 'difficulty_id');
    }

    public function toDTO(): Difficulty_LevelsDTO
    {
        return new Difficulty_LevelsDTO(
            $this->difficulty_id,
            $this->level_name,
            $this->description,
            $this->distance_threshold,
            $this->time_limit
        );
    }

}
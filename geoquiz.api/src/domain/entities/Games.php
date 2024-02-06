<?php

namespace geoquiz\api\domain\entities;

use geoquiz\api\domain\dto\GamesDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Games extends Model
{
    protected $table = 'games';
    protected $primaryKey = 'game_id';
    public $timestamps = false; // This is set to false because we don't have created_at and >updated_at< columns in our table
    protected $fillable = ['user_id', 'serie_id', 'difficulty_id', 'status', 'score', 'created_at', 'finished_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo('geoquiz\api\domain\entities\Users', 'user_id');
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo('geoquiz\api\domain\entities\Series', 'serie_id');
    }

    public function difficulty(): BelongsTo
    {
        return $this->belongsTo('geoquiz\api\domain\entities\Difficulty_Levels', 'difficulty_id');
    }

    public function toDTO(): GamesDTO
    {
        return new GamesDTO(
            $this->game_id,
            $this->user()->first()->toDTO(),
            $this->serie()->first()->toDTO(),
            $this->difficulty()->first()->toDTO(),
            $this->status,
            $this->score,
            $this->created_at,
            $this->finished_at
        );
    }

}
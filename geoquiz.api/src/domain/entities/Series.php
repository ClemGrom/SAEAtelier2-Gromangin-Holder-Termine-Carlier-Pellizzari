<?php

namespace geoquiz\api\domain\entities;

use geoquiz\api\domain\dto\SeriesDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    protected $table = 'series';
    protected $primaryKey = 'serie_id';
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    public function games(): HasMany
    {
        return $this->hasMany('geoquiz\api\domain\entities\Games', 'serie_id');
    }

    public function toDTO(): SeriesDTO
    {
        return new SeriesDTO(
            $this->serie_id,
            $this->name,
            $this->description
        );
    }

}
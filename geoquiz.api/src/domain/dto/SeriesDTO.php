<?php

namespace geoquiz\api\domain\dto;

use geoquiz\api\domain\entities\Series;

class SeriesDTO extends DTO
{
    public string $serie_id;
    public string $name;
    public string $description;

    public function __construct(int $serie_id, string $name, string $description)
    {
        $this->serie_id = $serie_id;
        $this->name = $name;
        $this->description = $description;
    }

    public function toModel() : Series
    {
        return Series::findOr($this->serie_id, function () {
            $newSerie = new Series();
            $newSerie->serie_id = $this->serie_id;
            return $newSerie;
        })->fill([
            'name' => $this->name,
            'description' => $this->description
        ]);
    }
}
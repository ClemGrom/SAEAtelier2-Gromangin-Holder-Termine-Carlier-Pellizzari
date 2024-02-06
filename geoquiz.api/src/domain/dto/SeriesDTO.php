<?php

namespace geoquiz\api\domain\dto;

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

    public function toModel() : null
    {
        return null;
    }
}
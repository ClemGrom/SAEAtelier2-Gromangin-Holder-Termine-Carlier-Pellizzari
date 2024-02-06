<?php

namespace geoquiz\api\domain\dto;

class SeriesDTO extends DTO
{
    public string $serie_id;
    public ?string $name;
    public ?string $description;

    public function __construct(string $serie_id)
    {
        $this->serie_id = $serie_id;
    }

    public function toModel($data = null) : null
    {
        return null;
    }
}
<?php

namespace geoquiz\api\domain\dto;

abstract class DTO
{

    public function __toString() : string
    {
        return json_encode(get_object_vars($this));
    }

    abstract public function toModel($data = null);

}
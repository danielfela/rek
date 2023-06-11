<?php

namespace Model;

class Brands extends Model
{
    public string $id = '';
    public ?string $brand = null;

    public function initialize()
    {
        $this->skipAttributes([
            'id',
        ]);

        $this->skipAttributesOnCreate([
            'id',
        ]);

        $this->skipAttributesOnUpdate([
            'id',
        ]);
    }

}

<?php

namespace Model;

class Models extends Model
{
    public string $id = '';
    public string $model;

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

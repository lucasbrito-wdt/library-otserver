<?php

namespace Otserver;

class Stage
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getMinlevel()
    {
        return $this->data['minlevel'];
    }

    public function getMaxlevel()
    {
        return $this->data['maxlevel'];
    }

    public function getMultiplier()
    {
        return $this->data['multiplier'];
    }
}

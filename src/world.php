<?php

namespace Otserver;

class World
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function getMultiplier()
    {
        return $this->data['multiplier'];
    }

    public function getStages()
    {
        return $this->data['stages'];
    }
}

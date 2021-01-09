<?php

namespace Otserver;

class Quest
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

    public function getName()
    {
        return $this->data['name'];
    }

    public function getStartStorageId()
    {
        return $this->data['startstorageid'];
    }

    public function getStartStorageValue()
    {
        return $this->data['startstoragevalue'];
    }

    public function getMission()
    {
        return $this->data['mission'];
    }
}

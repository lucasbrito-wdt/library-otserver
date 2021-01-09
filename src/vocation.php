<?php

namespace Otserver;

class Vocation
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

    public function getPromotion()
    {
        return $this->data['promotion'];
    }

    public function getParentVocation()
    {
        return $this->data['fromvoc'];
    }

    public function getName()
    {
        return $this->data['name'];
    }

    public function getBaseId()
    {
        return $this->data['base_id'];
    }

    public function getManaMultiplier()
    {
        return $this->data['manamultiplier'];
    }

    public function getGainHp()
    {
        return $this->data['gainhp'];
    }

    public function getGainMana()
    {
        return $this->data['gainmana'];
    }

    public function getGainCap()
    {
        return $this->data['gaincap'];
    }

    public function getGainHpTicks()
    {
        return $this->data['gainhpticks'];
    }

    public function getGainHpAmount()
    {
        return $this->data['gainhpamount'];
    }

    public function getGainManaTicks()
    {
        return $this->data['gainmanaticks'];
    }

    public function getGainManaAmount()
    {
        return $this->data['gainmanaamount'];
    }

    public function getGainSoulTicks()
    {
        return $this->data['gainsoulticks'];
    }

    public function getAttackSpeed()
    {
        return $this->data['attackspeed'];
    }
}

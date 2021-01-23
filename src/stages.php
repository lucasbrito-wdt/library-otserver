<?php

namespace Otserver;

use \Iterator;
use \Countable;

class Stages implements Iterator, Countable
{
    public $stages = [];

    private $XML;
    public $iterator = 0;

    public function __construct($file)
    {
        try {
            $XML = simplexml_load_file($file);
        } catch (\Exception $e) {
            new Error_Critic('', 'Stages::__construct - cannot load file <b>' . htmlspecialchars($file) . '</b>');
        }

        $this->XML = $XML;

        $_tmp_stages = [];

        foreach ($XML->world as $worlds) {
            $worldData = [];
            $worldData["id"] = $worlds->attributes()->id;
            $worldData["multiplier"] = $worlds->attributes()->multiplier;
            $worldData['stages'] = [];
            foreach ($worlds->stage as $stage) {
                $stageData["minlevel"] = $stage->attributes()->minlevel;
                $stageData["maxlevel"] = $stage->attributes()->maxlevel;
                $stageData["multiplier"] = $stage->attributes()->multiplier;
                array_push($worldData['stages'], new Stage($stageData));
            }
            $_tmp_stages[(int)$worlds->attributes()->id] = $worldData;
        }

        foreach ($_tmp_stages as $stage) {
            $this->stages[(int)$worlds->attributes()->id] = new World($stage);
        }
    }

    public function getWorld($id)
    {
        if (isset($this->stages[$id]))
            return $this->stages[$id];
        return false;
    }

    public function current()
    {
        return $this->stages[$this->iterator];
    }

    public function rewind()
    {
        $this->iterator = 0;
    }

    public function next()
    {
        ++$this->iterator;
    }

    public function key()
    {
        return $this->iterator;
    }

    public function valid()
    {
        return isset($this->stages[$this->iterator]);
    }

    public function count()
    {
        return count($this->stages);
    }
}

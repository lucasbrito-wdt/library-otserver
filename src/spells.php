<?php

namespace Otserver;

use \Iterator;
use \Countable;
use \DOMDocument;

class Spells implements Iterator, Countable
{
    public $spells = [];
    public $instants = [];
    public $conjures = [];

    private $XML;
    public $iterator = 0;

    public function __construct($file)
    {
        try {
            $XML = simplexml_load_file($file);
        } catch (\Exception $e) {
            new Error_Critic('', 'Spells::__construct - cannot load file <b>' . htmlspecialchars($file) . '</b>');
        }

        $this->XML = $XML;

        $_tmp_instant = [];
        $_tmp_conjure = [];

        foreach ($XML->instant as $Spells) {
            $instantData = [];

            if (strpos($Spells->attributes()->script, "monsters") === 0) {
                break;
            }

            $instantData["name"] = $Spells->attributes()->name;
            $instantData["words"] = $Spells->attributes()->words;
            $instantData["lvl"] = $Spells->attributes()->lvl;
            $instantData["maglv"] = $Spells->attributes()->maglv;
            $instantData["mana"] = $Spells->attributes()->mana;
            $instantData["manapercent"] = $Spells->attributes()->manapercent;
            $instantData["prem"] = $Spells->attributes()->prem;
            $instantData["aggressive"] = $Spells->attributes()->aggressive;
            $instantData["selftarget"] = $Spells->attributes()->selftarget;
            $instantData["exhaustion"] = $Spells->attributes()->exhaustion;
            $instantData["needlearn"] = $Spells->attributes()->needlearn;
            $instantData["soul"] = $Spells->attributes()->soul;
            $instantData["type"] = "Instant";
            if (isset($Spells->attributes()->script))
                $instantData["group"] = ucwords(explode("/", $Spells->attributes()->script)[0]);
            if (isset($Spells->attributes()->value))
                $instantData["group"] = ucwords(explode("/", $Spells->attributes()->value)[0]);

            foreach ($Spells->vocation as $vocation) {
                $instantData["vocation"][(int)$vocation->attributes()->id] = Website::getVocationName((int)$vocation->attributes()->id);
            }
            $_tmp_instant[] = $instantData;
        }

        foreach ($XML->conjure as $conjure) {
            $conjureData = [];

            $conjureData["name"] = $conjure->attributes()->name;
            $conjureData["words"] = $conjure->attributes()->words;
            $conjureData["lvl"] = $conjure->attributes()->lvl;
            $conjureData["maglv"] = $conjure->attributes()->maglv;
            $conjureData["mana"] = $conjure->attributes()->mana;
            $conjureData["manapercent"] = $conjure->attributes()->manapercent;
            $conjureData["prem"] = $conjure->attributes()->prem;
            $conjureData["exhaustion"] = $conjure->attributes()->exhaustion;
            $conjureData["soul"] = $conjure->attributes()->soul;
            $conjureData["type"] = "Conjure";
            $conjureData["group"] = str_replace('conjure', '', $conjure->attributes()->value);
            foreach ($conjure->vocation as $vocation) {
                $conjureData["vocation"][(int)$vocation->attributes()->id] = Website::getVocationName((int)$vocation->attributes()->id);
            }
            $_tmp_conjure[] = $conjureData;
        }

        foreach ($_tmp_instant as $instant) {
            $this->instants = new Instant($instant);
        }

        foreach ($_tmp_conjure as $conjure) {
            $this->conjures = new Conjure($instant);
        }

        $this->spells = array_merge($_tmp_instant, $_tmp_conjure);
    }

    public function current()
    {
        return $this->spells[$this->iterator];
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
        return isset($this->spells[$this->iterator]);
    }

    public function count()
    {
        return count($this->spells);
    }
}

<?php

namespace Otserver;

use \Iterator;
use \Countable;
use \DOMDocument;

class Quests implements Iterator, Countable
{
    public $quests = [];
    private $XML;
    public $iterator = 0;

    public function __construct($file)
    {
        try {
            $XML = simplexml_load_file($file);
        } catch (\Exception $e) {
            new Error_Critic('', 'Quests::__construct - cannot load file <b>' . htmlspecialchars($file) . '</b>');
        }

        $this->XML = $XML;
        $_tmp_quests = [];

        foreach ($XML->quest as $quest) {
            if (!empty($quest->attributes()->name) && !empty($quest->attributes()->startstorageid)) {
                $questData = [];
                $questData['name'] = $quest->attributes()->name;
                $questData['startstorageid'] = (int)$quest->attributes()->startstorageid;
                $questData['startstoragevalue'] = (int)$quest->attributes()->startstoragevalue;
                $questData['mission'] = [];
                foreach ($quest->mission as $mission) {
                    if (!empty($mission->attributes()->name) && !empty($mission->attributes()->storageid)) {
                        $missionData['name'] = $mission->attributes()->name;
                        $missionData['storageid'] = (int)$mission->attributes()->storageid;
                        $missionData['startvalue'] = (int)$mission->attributes()->startvalue;
                        $missionData['endvalue'] = (int)$mission->attributes()->endvalue;
                        $missionData['missionstate'] = [];
                        foreach ($mission->missionstate as $missionstate) {
                            if (!empty($missionstate->attributes()->description)) {
                                $missionstateData['id'] = (int)$missionstate->attributes()->id;
                                $missionstateData['description'] = $missionstate->attributes()->description;
                                array_push($missionData['missionstate'], $missionstateData);
                            }
                        }
                        array_push($questData['mission'], $missionData);
                    }
                }
                $_tmp_quests[(int)$quest->attributes()->startstorageid] = $questData;
            } else
                new Error_Critic('#C', 'Cannot load quest. <b>id</b> or/and <b>name</b> parameter is missing');
        }

        foreach ($_tmp_quests as $_tmp_quest) {
            $this->quests[(int)$_tmp_quest['startstorageid']] = new Quest($_tmp_quest);
        }
    }

    /*
     * Get quest
     */
    public function getQuest($id)
    {
        if (isset($this->quests[$id]))
            return $this->quests[$id];
        return false;
    }

    /*
     * Get quest name without getting quest
     */

    public function getQuestName($id)
    {
        if ($quest = $this->getQuest($id))
            return $quest->getName();
        return false;
    }

    public function current()
    {
        return $this->quests[$this->iterator];
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
        return isset($this->quests[$this->iterator]);
    }

    public function count()
    {
        return count($this->quests);
    }
}

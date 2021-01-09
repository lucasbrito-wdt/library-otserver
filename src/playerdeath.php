<?php

namespace Otserver;

// class for 'lists' only, to use it you must set list filter:
// $yourList->setFilter(new SQL_Filter(new SQL_Field('id', 'players'), SQL_Filter::EQUAL, new SQL_Field('player_id', 'player_deaths')));
class PlayerDeath extends ObjectData
{
    public static $table = 'player_deaths';
    public $data = array('id' => null, 'player_id' => null, 'date' => null, 'level' => null, 'altkilled_by' => null);
    public static $fields = array('id', 'player_id', 'date', 'level', 'altkilled_by');
    //public static $extraFields = array(array('id', 'players'), array('name', 'players'));
    public $killers;

    public function __construct($player_id = null)
    {
        if ($player_id != null)
            $this->load($player_id);
    }

    public function load($player_id)
    {
        $search_string = $this->getDatabaseHandler()->fieldName('player_id') . ' = ' . $this->getDatabaseHandler()->quote($player_id);
        $fieldsArray = [];
        foreach (self::$fields as $fieldName)
            $fieldsArray[$fieldName] = $this->getDatabaseHandler()->fieldName($fieldName);
        $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $search_string)->fetch();
    }

    public function save($forceInsert = false)
    {
        if (!isset($this->data['id']) || $forceInsert) {
            $keys = array();
            $values = array();
            foreach (self::$fields as $key)
                if ($key != 'id') {
                    $keys[] = $this->getDatabaseHandler()->fieldName($key);
                    $values[] = $this->getDatabaseHandler()->quote($this->data[$key]);
                }
            $this->getDatabaseHandler()->query('INSERT INTO ' . $this->getDatabaseHandler()->tableName(self::$table) . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $values) . ')');
            $this->setID($this->getDatabaseHandler()->lastInsertId());
        } else {
            $updates = array();
            foreach (self::$fields as $key)
                if ($key != 'id')
                    $updates[] = $this->getDatabaseHandler()->fieldName($key) . ' = ' . $this->getDatabaseHandler()->quote($this->data[$key]);
            $this->getDatabaseHandler()->query('UPDATE ' . $this->getDatabaseHandler()->tableName(self::$table) . ' SET ' . implode(', ', $updates) . ' WHERE ' . $this->getDatabaseHandler()->fieldName('id') . ' = ' . $this->getDatabaseHandler()->quote($this->data['id']));
        }
    }

    public function loadKillers()
    {
        return $this->killers = $this->getDatabaseHandler()->query('SELECT ' . $this->getDatabaseHandler()->tableName('environment_killers') . '.' . $this->getDatabaseHandler()->fieldName('name') . ' AS monster_name, ' . $this->getDatabaseHandler()->tableName('players') . '.' . $this->getDatabaseHandler()->fieldName('name') . ' AS player_name, ' . $this->getDatabaseHandler()->tableName('players') . '.' . $this->getDatabaseHandler()->fieldName('deleted') . ' AS player_exists FROM ' . $this->getDatabaseHandler()->tableName('killers') . ' LEFT JOIN ' . $this->getDatabaseHandler()->tableName('environment_killers') . ' ON ' . $this->getDatabaseHandler()->tableName('killers') . '.' . $this->getDatabaseHandler()->fieldName('id') . ' = ' . $this->getDatabaseHandler()->tableName('environment_killers') . '.' . $this->getDatabaseHandler()->fieldName('kill_id') . ' LEFT JOIN ' . $this->getDatabaseHandler()->tableName('player_killers') . ' ON ' . $this->getDatabaseHandler()->tableName('killers') . '.' . $this->getDatabaseHandler()->fieldName('id') . ' = ' . $this->getDatabaseHandler()->tableName('player_killers') . '.' . $this->getDatabaseHandler()->fieldName('kill_id') . ' LEFT JOIN ' . $this->getDatabaseHandler()->tableName('players') . ' ON ' . $this->getDatabaseHandler()->tableName('players') . '.' . $this->getDatabaseHandler()->fieldName('id') . ' = ' . $this->getDatabaseHandler()->tableName('player_killers') . '.' . $this->getDatabaseHandler()->fieldName('player_id') . '  WHERE ' . $this->getDatabaseHandler()->tableName('killers') . '.' . $this->getDatabaseHandler()->fieldName('death_id') . ' = ' . $this->getDatabaseHandler()->quote($this->data['id']) . ' ORDER BY ' . $this->getDatabaseHandler()->tableName('killers') . '.' . $this->getDatabaseHandler()->fieldName('final_hit') . ' DESC, ' . $this->getDatabaseHandler()->tableName('killers') . '.' . $this->getDatabaseHandler()->fieldName('id') . ' ASC')->fetchAll();
    }

    public function isLoaded()
    {
        return isset($this->data['player_id']);
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function getPlayerID()
    {
        return $this->data['player_id'];
    }

    public function getDate()
    {
        return $this->data['date'];
    }

    public function getLevel()
    {
        return $this->data['level'];
    }
}

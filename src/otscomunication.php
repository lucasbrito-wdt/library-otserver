<?php

namespace Otserver;

class OtsComunication extends ObjectData
{
    const LOADTYPE_ID = 'id';
    public static $table = 'z_ots_comunication';
    public $data = [
        'id' => null,
        'name' => null,
        'type' => null,
        'action' => null,
        'param1' => null,
        'param2' => null,
        'param3' => null,
        'param4' => null,
        'param5' => null,
        'param6' => null,
        'param7' => null,
        'delete_it' => null,
        'created_at' => null,
        'updated_at' => null,
    ];
    public static $fields = [
        'id',
        'name',
        'type',
        'action',
        'param1',
        'param2',
        'param3',
        'param4',
        'param5',
        'param6',
        'param7',
        'delete_it',
    ];

    public function __construct($search_text = null, $search_by = self::LOADTYPE_ID)
    {
        if ($search_text != null)
            $this->load($search_text, $search_by);
    }

    public function load($search_text, $search_by = self::LOADTYPE_ID)
    {
        if (in_array($search_by, self::$fields))
            $search_string = $this->getDatabaseHandler()->fieldName($search_by) . ' = ' . $this->getDatabaseHandler()->quote($search_text);
        else
            new Error_Critic('', 'Wrong Ots Comunication search_by type.');
        $fieldsArray = array();
        foreach (self::$fields as $fieldName)
            $fieldsArray[] = $this->getDatabaseHandler()->fieldName($fieldName);

        return $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $search_string)->fetchAll();
    }

    public function loadById($id)
    {
        $this->load($id, self::LOADTYPE_ID);
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

    public function delete()
    {
        $this->getDatabaseHandler()->query('DELETE FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $this->getDatabaseHandler()->fieldName('id') . ' = ' . $this->getDatabaseHandler()->quote($this->data['id']));
        unset($this->data['id']);
    }

    public function setID($id)
    {
        $this->data['id'] = $id;
    }

    public function getID()
    {
        return $this->data['id'];
    }

    public function setName($value)
    {
        $this->data['name'] = $value;
    }

    public function getName()
    {
        return $this->data['name'];
    }

    public function setType($value)
    {
        $this->data['type'] = $value;
    }

    public function getType()
    {
        return $this->data['type'];
    }

    public function setAction($value)
    {
        $this->data['action'] = $value;
    }

    public function getAction()
    {
        return $this->data['action'];
    }

    public function setParam1($value)
    {
        $this->data['param1'] = $value;
    }

    public function getParam1()
    {
        return $this->data['param1'];
    }

    public function setParam2($value)
    {
        $this->data['param2'] = $value;
    }

    public function getParam2()
    {
        return $this->data['param2'];
    }

    public function setParam3($value)
    {
        $this->data['param3'] = $value;
    }

    public function getParam3()
    {
        return $this->data['param3'];
    }

    public function setParam4($value)
    {
        $this->data['param4'] = $value;
    }

    public function getParam4()
    {
        return $this->data['param4'];
    }

    public function setParam5($value)
    {
        $this->data['param5'] = $value;
    }

    public function getParam5()
    {
        return $this->data['param5'];
    }

    public function setParam6($value)
    {
        $this->data['param6'] = $value;
    }

    public function getParam6()
    {
        return $this->data['param6'];
    }

    public function setParam7($value)
    {
        $this->data['param7'] = $value;
    }

    public function getParam7()
    {
        return $this->data['param7'];
    }

    public function setDeleteIt($value)
    {
        $this->data['delete_it'] = $value;
    }

    public function getDeleteIt()
    {
        return $this->data['delete_it'];
    }

    public function setCreatedAt($value)
    {
        $this->data['created_at'] = $value;
    }

    public function getCreatedAt()
    {
        return $this->data['created_at'];
    }

    public function setUpdatedAt($value)
    {
        $this->data['updated_at'] = $value;
    }

    public function getUpdatedAt()
    {
        return $this->data['updated_at'];
    }
}

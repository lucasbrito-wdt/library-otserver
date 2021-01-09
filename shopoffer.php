<?php

namespace Otserver;

class ShopOffer extends ObjectData
{
    const LOADTYPE_ID = 'id';
    const LOADTYPE_NAME = 'ref';
    public static $table = 'z_shop_offer';
    public $data = array(
        'points' => 0, 'itemid1' => 0, 'count1' => 0, 'itemid2' => 0, 'count2' => 0,
        "offer_type" => null, "offer_description" => null, "offer_name" => null, "pid" => 0, "category" => 1
    );
    public static $fields = array('id', 'points', 'itemid1', 'count1', 'itemid2', 'count2', 'offer_type', 'offer_description', 'offer_name', 'pid', "category");

    public function __construct()
    {
    }

    public function load($search_text, $search_by = self::LOADTYPE_ID, $all = false)
    {
        if (in_array($search_by, self::$fields))
            $search_string = $this->getDatabaseHandler()->fieldName($search_by) . ' = ' . $this->getDatabaseHandler()->quote($search_text);
        else
            new Error_Critic('', 'Wrong Donate search_by type.');
        $fieldsArray = array();
        foreach (self::$fields as $fieldName)
            $fieldsArray[] = $this->getDatabaseHandler()->fieldName($fieldName);
        if ($all) {
            $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $search_string)->fetchAll();
        } else {
            $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $search_string)->fetch();
        }
    }

    public function loadAll()
    {
        $fieldsArray = array();
        foreach (self::$fields as $fieldName) {
            $fieldsArray[] = $this->getDatabaseHandler()->fieldName($fieldName);
        }
        $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table))->fetchAll();
        return $this->data;
    }

    public function loadById($id, $all = false)
    {
        $this->load($id, 'id', $all);
    }

    public function loadByItemId($itemid, $all = false)
    {
        $this->load($itemid, 'itemid1', $all);
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

    public function getId()
    {
        return $this->data['id'];
    }

    public function setItemId1($val)
    {
        $this->data['item1'] = $val;
    }
}

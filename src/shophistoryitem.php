<?php

namespace Otserver;

class ShopHistoryItem extends ObjectData
{
    const LOADTYPE_ID = 'id';
    public static $table = 'z_shop_history_item';
    public $data = [
        'id' => null,
        'to_name' => null,
        'to_account' => 0,
        'from_nick' => null,
        'from_account' => 0,
        'price' => 0,
        'offer_id' => null,
        'trans_state' => null,
        'trans_start' => null,
        'trans_real' => null,
        'created_at' => null,
        'updated_at' => null,
    ];
    public static $fields = [
        'id',
        'to_name',
        'to_account',
        'from_nick',
        'from_account',
        'price',
        'offer_id',
        'trans_state',
        'trans_start',
        'trans_real',
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
            new Error_Critic('', 'Wrong Shop History Item search_by type.');
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

    public function setID($value)
    {
        $this->data['id'] = $value;
    }

    public function getID()
    {
        return $this->data['id'];
    }

    public function setToName($value)
    {
        $this->data['to_name'] = $value;
    }

    public function getToName()
    {
        return $this->data['to_name'];
    }

    public function setToAccount($value)
    {
        $this->data['to_account'] = $value;
    }

    public function getToAccount()
    {
        return $this->data['to_account'];
    }

    public function setFromNick($value)
    {
        $this->data['from_nick'] = $value;
    }

    public function getFromNick()
    {
        return $this->data['from_nick'];
    }

    public function setFromAccount($value)
    {
        $this->data['from_account'] = $value;
    }

    public function getFromAccount()
    {
        return $this->data['from_account'];
    }

    public function setPrice($value)
    {
        $this->data['price'] = $value;
    }

    public function getPrice()
    {
        return $this->data['price'];
    }

    public function setOfferId($value)
    {
        $this->data['offer_id'] = $value;
    }

    public function getOfferId()
    {
        return $this->data['offer_id'];
    }

    public function setTransState($value)
    {
        $this->data['trans_state'] = $value;
    }

    public function getTransState()
    {
        return $this->data['trans_state'];
    }

    public function setTransStart($value)
    {
        $this->data['trans_start'] = $value;
    }

    public function getTransStart()
    {
        return $this->data['trans_start'];
    }

    public function setTransReal($value)
    {
        $this->data['trans_real'] = $value;
    }

    public function getTransReal()
    {
        return $this->data['trans_real'];
    }
}

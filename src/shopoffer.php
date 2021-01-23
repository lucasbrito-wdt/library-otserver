<?php

namespace Otserver;

class ShopOffer extends ObjectData
{
    const LOADTYPE_ID = 'id';
    const LOADTYPE_NAME = 'ref';

    const OFFERTYPE_ITEM = 'item';
    const OFFERTYPE_PACC = 'pacc';
    const OFFERTYPE_FRAGS = 'frags';
    const OFFERTYPE_UNBAN = 'unban';
    const OFFERTYPE_REDSKULL = 'redskull';
    const OFFERTYPE_CHANGENAME = 'changename';
    const OFFERTYPE_CONTAINER = 'container';
    const OFFERTYPE_ITEMLOGOUT = 'itemlogout';

    const CATEGORY_ITEM = 'item';
    const CATEGORY_ACCOUNT = 'account';
    const CATEGORY_RUNE = 'rune';

    public static $table = 'z_shop_offer';
    public $data = [
        'id' => null,
        'points' => 0,
        'itemid1' => 0,
        'count1' => 0,
        'itemid2' => 0,
        'count2' => 0,
        'offer_type' => null,
        'offer_description' => null,
        'offer_name' => null,
        'pid' => 0,
        'bought' => 0,
        'free_cap' => 0,
        'category' => null,
        'active' => 1
    ];
    public static $fields = [
        'id',
        'points',
        'itemid1',
        'count1',
        'itemid2',
        'count2',
        'offer_type',
        'offer_description',
        'offer_name',
        'pid',
        'bought',
        'free_cap',
        'category',
        'active'
    ];

    public function __construct($search_text = null, $search_by = self::LOADTYPE_ID)
    {
        if ($search_text != null)
            $this->load($search_text, $search_by);
    }

    public function load($search_text, $search_by = self::LOADTYPE_ID, $all = false)
    {
        if (in_array($search_by, self::$fields))
            $search_string = $this->getDatabaseHandler()->fieldName($search_by) . ' = ' . $this->getDatabaseHandler()->quote($search_text);
        else
            new Error_Critic('', 'Wrong Donate search_by type.');
        $fieldsArray = [];
        foreach (self::$fields as $fieldName)
            $fieldsArray[] = $this->getDatabaseHandler()->fieldName($fieldName);
        if ($all) {
            return $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $search_string . ' AND ' . $this->getDatabaseHandler()->fieldName('active') . ' = ' . $this->getDatabaseHandler()->quote(true))->fetchAll();
        } else {
            return $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $search_string . ' AND ' . $this->getDatabaseHandler()->fieldName('active') . ' = ' . $this->getDatabaseHandler()->quote(true))->fetch();
        }
    }

    public function loadAll()
    {
        $fieldsArray = array();
        foreach (self::$fields as $fieldName) {
            $fieldsArray[] = $this->getDatabaseHandler()->fieldName($fieldName);
        }
        $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . 'WHERE ' . $this->getDatabaseHandler()->fieldName('active') . ' = ' . $this->getDatabaseHandler()->quote(true))->fetchAll(\PDO::FETCH_OBJ);
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

    public function getID()
    {
        return $this->data['id'];
    }

    public function setPoints($points)
    {
        $this->data['points'] = (int) $points;
    }

    public function getPoints()
    {
        return (int) $this->data['points'];
    }

    public function setItemId1($val)
    {
        $this->data['itemid1'] = $val;
    }

    public function getItemId1()
    {
        return $this->data['itemid1'];
    }

    public function setCount1($val)
    {
        $this->data['count1'] = $val;
    }

    public function getCount1()
    {
        return $this->data['count1'];
    }

    public function setItemId2($val)
    {
        $this->data['itemid2'] = $val;
    }

    public function getItemId2()
    {
        return $this->data['itemid2'];
    }

    public function setCount2($val)
    {
        $this->data['count2'] = $val;
    }

    public function getCount2()
    {
        return $this->data['count2'];
    }

    public function setOfferType($val)
    {
        $this->data['offer_type'] = $val;
    }

    public function getOfferType()
    {
        return $this->data['offer_type'];
    }

    public function setOfferDescription($val)
    {
        $this->data['offer_description'] = $val;
    }

    public function getOfferDescription()
    {
        return $this->data['offer_description'];
    }

    public function setOfferName($val)
    {
        $this->data['offer_name'] = $val;
    }

    public function getOfferName()
    {
        return $this->data['offer_name'];
    }

    public function setPid($val)
    {
        $this->data['pid'] = $val;
    }

    public function getPid()
    {
        return $this->data['pid'];
    }

    public function setBought($val)
    {
        $this->data['bought'] = $val;
    }

    public function getBought()
    {
        return $this->data['bought'];
    }

    public function setFreeCap($val)
    {
        $this->data['free_cap'] = $val;
    }

    public function getFreeCap()
    {
        return $this->data['free_cap'];
    }

    public function setCategory($val)
    {
        $this->data['category'] = $val;
    }

    public function getCategory()
    {
        return $this->data['category'];
    }

    public function setCreatedAt($val)
    {
        $this->data['created_at'] = $val;
    }

    public function getCreatedAt()
    {
        return $this->data['created_at'];
    }

    public function setUpdatedAt($val)
    {
        $this->data['updated_at'] = $val;
    }

    public function getUpdatedAt()
    {
        return $this->data['updated_at'];
    }

    public function setActive($val)
    {
        $this->data['active'] = $val;
    }

    public function getActive()
    {
        return $this->data['active'];
    }

    public function isLoaded()
    {
        return isset($this->data['id']);
    }
}

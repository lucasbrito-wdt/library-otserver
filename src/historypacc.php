<?php

namespace Otserver;

class HistoryPacc extends ObjectData
{
    public static $table = 'z_shop_history_pacc';
    public $data = ['to_name' => null, 'to_account' => null, 'from_nick' => null, 'from_account' => null, 'price' => null, 'pacc_days' => null, 'trans_state' => null, 'trans_start' => null, 'trans_real' => null];
    public static $fields = ['id', 'to_name', 'to_account', 'from_nick', 'from_account', 'price', 'pacc_days', 'trans_state', 'trans_start', 'trans_real'];

    public function __construct($search_text = null)
    {
        if ($search_text != null)
            $this->load($search_text);
    }

    public function load($search_text)
    {
        $search_string = $this->getDatabaseHandler()->fieldName('from_account') . ' = ' . $this->getDatabaseHandler()->quote($search_text);
        $fieldsArray = [];
        foreach (self::$fields as $fieldName)
            $fieldsArray[$fieldName] = $this->getDatabaseHandler()->fieldName($fieldName);
        $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $search_string)->fetch();
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function setId($value)
    {
        $this->data['id'] = $value;
    }

    public function getToName()
    {
        return $this->data['to_name'];
    }

    public function setToName($value)
    {
        $this->data['to_name'] = $value;
    }

    public function getToAccount()
    {
        return $this->data['to_account'];
    }

    public function setToAccount($value)
    {
        $this->data['to_account'] = $value;
    }

    public function getFromNick()
    {
        return $this->data['from_nick'];
    }

    public function setFromNick($value)
    {
        $this->data['from_nick'] = $value;
    }

    public function getFromAccount()
    {
        return $this->data['from_account'];
    }

    public function setFromAccount($value)
    {
        $this->data['from_account'] = $value;
    }

    public function getPrice()
    {
        return $this->data['price'];
    }

    public function setPrice($value)
    {
        $this->data['price'] = $value;
    }

    public function getPaccDays()
    {
        return $this->data['pacc_days'];
    }

    public function setPaccDays($value)
    {
        $this->data['pacc_days'] = $value;
    }

    public function getTransState()
    {
        return $this->data['trans_state'];
    }

    public function setTransState($value)
    {
        $this->data['trans_state'] = $value;
    }

    public function getTransStart()
    {
        return $this->data['trans_start'];
    }

    public function setTransStart($value)
    {
        $this->data['trans_start'] = $value;
    }

    public function getTransReal()
    {
        return $this->data['trans_real'];
    }

    public function setTransReal($value)
    {
        $this->data['trans_real'] = $value;
    }
}

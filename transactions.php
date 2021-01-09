<?php

namespace Otserver;

class Transactions extends ObjectData
{
    public static $table = 'z_transactions';
    public $data = ['account_id' => null, 'name' => null, 'payment_method' => null, 'item_count' => null, 'points' => null, 'reference_code' => null, 'transaction_code' => null, 'status' => null, 'created_at' => null, 'updated_at' => null];
    public static $fields = ['id', 'account_id', 'name', 'payment_method', 'item_count', 'points', 'reference_code', 'transaction_code', 'status', 'created_at', 'updated_at'];

    public function __construct($search_text = null)
    {
        if ($search_text != null)
            $this->load($search_text);
    }

    public function load($search_text)
    {
        $search_string = $this->getDatabaseHandler()->fieldName('account_id') . ' = ' . $this->getDatabaseHandler()->quote($search_text);
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

    public function getAccountId()
    {
        return $this->data['account_id'];
    }

    public function setAccountId($value)
    {
        $this->data['account_id'] = $value;
    }

    public function getName()
    {
        return $this->data['name'];
    }

    public function setName($value)
    {
        $this->data['name'] = $value;
    }

    public function getPaymentMethod()
    {
        return $this->data['payment_method'];
    }

    public function setPaymentMethod($value)
    {
        $this->data['payment_method'] = $value;
    }

    public function getItemCount()
    {
        return $this->data['item_count'];
    }

    public function setItemCount($value)
    {
        $this->data['item_count'] = $value;
    }

    public function getPoints()
    {
        return $this->data['points'];
    }

    public function setPoints($value)
    {
        $this->data['points'] = $value;
    }

    public function getReferenceCode()
    {
        return $this->data['reference_code'];
    }

    public function setReferenceCode($value)
    {
        $this->data['reference_code'] = $value;
    }

    public function getTransactionCode()
    {
        return $this->data['transaction_code'];
    }

    public function setTransactionCode($value)
    {
        $this->data['transaction_code'] = $value;
    }

    public function getStatus()
    {
        return $this->data['status'];
    }

    public function setStatus($value)
    {
        $this->data['status'] = $value;
    }

    public function getCreatedAt()
    {
        return $this->data['created_at'];
    }

    public function setCreatedAt($value)
    {
        $this->data['created_at'] = $value;
    }

    public function getUpdatedAt()
    {
        return $this->data['updated_at'];
    }

    public function setUpdatedAt($value)
    {
        $this->data['updated_at'] = $value;
    }
}

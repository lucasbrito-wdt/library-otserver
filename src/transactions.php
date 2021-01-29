<?php

namespace Otserver;

class Transactions extends ObjectData
{
    const LOADTYPE_ID = 'id';
    const LOADTYPE_TRANSACTION_CODE = 'transaction_code';

    public static $table = 'z_transactions';
    public $data = [
        'account_id' => null,
        'account_from' => null,
        'name' => null,
        'payment_method' => null,
        'item_count' => null,
        'points' => null,
        'reference_code' => null,
        'transaction_code' => null,
        'status' => null,
        'created_at' => null,
        'updated_at' => null
    ];
    public static $fields = ['id', 'account_id', 'account_from', 'name', 'payment_method', 'item_count', 'points', 'reference_code', 'transaction_code', 'status'];

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
            new Error_Critic('', 'Pesquisa de transações por tipo errada.');
        $fieldsArray = array();
        foreach (self::$fields as $fieldName)
            $fieldsArray[] = $this->getDatabaseHandler()->fieldName($fieldName);
        return $this->data = $this->getDatabaseHandler()->query('SELECT ' . implode(', ', $fieldsArray) . ' FROM ' . $this->getDatabaseHandler()->tableName(self::$table) . ' WHERE ' . $search_string)->fetch();
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

    public function getAccountFrom()
    {
        return $this->data['account_from'];
    }

    public function setAccountFrom($value)
    {
        $this->data['account_from'] = $value;
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

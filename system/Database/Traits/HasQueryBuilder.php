<?php

namespace System\Database\Traits;

use System\Database\DBConnection\DBConnection;

trait HasQueryBuilder {

    private $sql = '';
    protected $where = [];
    private $orderBy = [];
    private $limit = [];
    private $values = [];
    private $bindValues = [];

    /**
     * Set sql commands
     * SELECT column1, column2, ... FROM table_name
     *
     * @param $query
     */
    protected function setSql($query) {
        $this->sql = $query;
    }

    /**
     * Return sql commands
     *
     * @return string
     */
    protected function getSql() {
        return $this->sql;
    }

    /**
     * Delete and reset sql commands
     */
    protected function resetSql() {
        $this->sql = '';
    }

    /**
     * Set WHERE-sql command
     *
     * @param $operator : AND, OR, NOT
     * @param $condition : condition
     */
    protected function setWhere($operator, $condition) {
        $array = ['operator' => $operator, 'condition' => $condition];
        array_push($this->where, $array);
    }

    /**
     * Delete and reset WHERE-sql command
     */
    protected function resetWhere() {
        $this->where = [];
    }

    /**
     * Set ORDER BY-sql command
     *
     * @param $name : column1, column2, ...
     * @param $expression : ASC|DESC
     */
    protected function setOrderBy($name, $expression) {
        array_push($this->orderBy, $this->getAttributeName($name) . ' ' . $expression);
    }

    /**
     * Delete and reset ORDER BY-sql command
     */
    protected function resetOrderBy() {
        $this->orderBy = [];
    }

    /**
     * Set LIMIT-sql command
     *
     * @param $form
     * @param $number
     */
    protected function setLimit($from, $number) {
        $this->limit['from'] = (int)$from;
        $this->limit['number'] = (int)$number;
    }

    /**
     * Delete and reset LIMIT-sql command
     */
    protected function resetLimit() {
        unset($this->limit['from']);
        unset($this->limit['number']);
    }

    /**
     * Add values to bindValues
     * INSERT INTO table_name VALUES (value1, value2, value3, ...)
     *
     * @param $attribute
     * @param $value
     */
    protected function addValue($attribute, $value) {
        $this->values[$attribute] = $value;
        array_push($this->bindValues, $value);
    }

    /**
     * Remove all values
     */
    protected function removeValues() {
        $this->values = [];
        $this->bindValues = [];
    }

    /**
     * Delete and Reset all queries
     */
    protected function resetQuery() {
        $this->resetSql();
        $this->resetWhere();
        $this->resetOrderBy();
        $this->resetLimit();
        $this->removeValues();
    }

    /**
     * Execute Queries
     * performs a query against a database
     *
     * @return bool|\PDOStatement
     * @throws \Exception
     */
    protected function executeQuery() {
        $query = '';
        $query .= $this->sql;
        if (!empty($this->where)) {
            $whereString = '';
            foreach ($this->where as $where)
                $whereString == '' ? $whereString .= $where['condition'] : $whereString .= ' ' . $where['operator'] . ' ' . $where['condition'];
            $query .= ' WHERE ' . $whereString;
        }
        if (!empty($this->orderBy))
            $query .= ' ORDER BY ' . implode(', ', $this->orderBy);
        if (!empty($this->limit))
            $query .= ' limit ' . $this->limit['from'] . ' , ' . $this->limit['number'] . ' ';
        $query .= ' ;';
        $pdoInstance = DBConnection::getDBConnectionInstance();
        $statement = $pdoInstance->prepare($query);
        sizeof($this->bindValues) > 0 ? $statement->execute($this->bindValues) : $statement->execute();
        return $statement;
    }

    /**
     * The count method returns the total number of items in the collection.
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getCount() {
        $query = '';
        $query .= "SELECT COUNT(*) FROM " . $this->getTableName();
        if (!empty($this->where)) {
            $whereString = '';
            foreach ($this->where as $where)
                $whereString == '' ? $whereString .= $where['condition'] : $whereString .= ' ' . $where['operator'] . ' ' . $where['condition'];
            $query .= ' WHERE ' . $whereString;
        }
        $query .= ' ;';
        $pdoInstance = DBConnection::getDBConnectionInstance();
        $statement = $pdoInstance->prepare($query);
        if (sizeof($this->bindValues) > sizeof($this->values)) {
            sizeof($this->bindValues) > 0 ? $statement->execute($this->bindValues) : $statement->execute();
        } else {
            sizeof($this->values) > 0 ? $statement->execute(array_values($this->values)) : $statement->execute();
        }
        return $statement->fetchColumn();
    }

    /**
     * Put a backtick in the name of the table.
     *
     * @return string
     */
    protected function getTableName() {
        return ' `' . $this->table . '`';
    }

    /**
     * Put a backtick in the name of the table fields.
     *
     * @param $attribute
     * @return string
     */
    protected function getAttributeName($attribute) {
        return ' `' . $this->table . '`.`' . $attribute . '` ';
    }

}
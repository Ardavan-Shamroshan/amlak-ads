<?php

namespace System\Database\Traits;

use System\Database\DBConnection\DBConnection;

trait HasCRUD {
    /**
     * You may use the create method to "save" a new model using a single PHP statement. The
     * inserted model instance will be returned to you by the create method.
     *
     * @param $values
     * @return HasCRUD
     */
    protected function createMethod($values) {
        $values = $this->arrayToCastEncodeValue($values);
        $this->arrayToAttributes($values, $this);
        return $this->saveMethod();
    }

    /**
     * You may use the create method to "update" an existing model using a single PHP statement.
     *
     * @param $values
     * @return HasCRUD
     */
    protected function updateMethod($values) {
        $values = $this->arrayToCastEncodeValue($values);
        $this->arrayToAttributes($values, $this);
        return $this->saveMethod();
    }

    /**
     * To delete a model, call the delete method on a model instance.
     *
     * @param null $id
     * @return mixed
     */
    protected function deleteMethod($id = null) {
        $object = $this;
        $this->resetQuery();
        if ($id) {
            $object = $this->findMethod($id);
            $this->resetQuery();
        }
        $object->setSql("DELETE FROM " . $object->getTableName());
        $object->setWhere("AND", $this->getAttributeName($this->primaryKey) . " = ? ");
        $object->addValue($object->primaryKey, $object->{$object->primaryKey});
        return $object->executeQuery();
    }

    /**
     * The model's all method will retrieve all of the records from the model's
     * associated database table.
     *
     * @return array
     */
    protected function allMethod() {
        $this->setSql("SELECT * FROM " . $this->getTableName());
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }
        return [];
    }

    /**
     * You may also retrieve single records using the find method.
     * Instead of returning a collection of models, this method returns a single model instance
     *
     * @param $id
     * @return |null
     */
    protected function findMethod($id) {
        $this->setSql("SELECT * FROM " . $this->getTableName());
        $this->setWhere("AND", $this->getAttributeName($this->primaryKey) . " = ? ");
        $this->addValue($this->primaryKey, $id);
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        $this->setAllowedMethods(['update', 'delete', 'save']);
        if ($data)
            return $this->arrayToAttributes($data);
        return null;
    }

    /**
     * You may use the query builder's where method to add "where" clauses to the query. The most
     * basic call to the where method requires three arguments. The first argument is the name of
     * the column. The second argument is an operator, which can be any of the database's
     * supported operators. The third argument is the value to compare against the column's value.
     *
     * @param $attribute
     * @param $firstValue
     * @param $secondValue
     * @return $this
     */
    protected function whereMethod($attribute, $firstValue, $secondValue = null) {
        if ($secondValue === null) {
            $condition = $this->getAttributeName($attribute) . ' = ?';
            $this->addValue($attribute, $firstValue);
        } else {
            $condition = $this->getAttributeName($attribute) . ' ' . $firstValue . ' ?';
            $this->addValue($attribute, $secondValue);
        }
        $operator = 'AND';
        $this->setWhere($operator, $condition);
        $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    /**
     * You may use the orWhere method to join a clause to the query using the or operator. The
     * orWhere method accepts the same arguments as the where method
     *
     * @param $attribute
     * @param $firstValue
     * @param null $secondValue
     * @return $this
     */
    protected function whereOrMethod($attribute, $firstValue, $secondValue = null) {
        if ($secondValue === null) {
            $condition = $this->getAttributeName($attribute) . ' = ?';
            $this->addValue($attribute, $firstValue);
        } else {
            $condition = $this->getAttributeName($attribute) . ' ' . $firstValue . ' ?';
            $this->addValue($attribute, $secondValue);
        }
        $operator = 'OR';
        $this->setWhere($operator, $condition);
        $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    /**
     * The whereNull method verifies that the value of the given column is NULL.
     *
     * @param $attribute
     * @return $this
     */
    protected function whereNullMethod($attribute) {
        $condition = $this->getAttributeName($attribute) . ' IS NULL ';
        $operator = 'AND';
        $this->setWhere($operator, $condition);
        $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    /**
     * The whereNotNull method verifies that the column's value is not NULL.
     *
     * @param $attribute
     * @return $this
     */
    protected function whereNotNullMethod($attribute) {
        $condition = $this->getAttributeName($attribute) . ' IS NOT NULL ';
        $operator = 'AND';
        $this->setWhere($operator, $condition);
        $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    /**
     * The whereIn method verifies that a given column's value is contained within the given array.
     *
     * @param $attribute
     * @param $values
     * @return $this
     */
    protected function whereInMethod($attribute, $values) {
        if (is_array($values)) {
            $valuesArray = [];
            foreach ($values as $value) {
                $this->addValue($attribute, $value);
                array_push($valuesArray, '?');
            }
            $condition = $this->getAttributeName($attribute) . ' IN (' . implode(' , ', $valuesArray) . ')';
            $operator = 'AND';
            $this->setWhere($operator, $condition);
            $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
            return $this;
        }
    }

    /**
     * The orderBy method allows you to sort the results of the query by a given column. The first
     * argument accepted by the orderBy method should be the column you wish to sort by, while the
     * second argument determines the direction of the sort and may be either asc or desc
     *
     * @param $attribute
     * @param $expression
     * @return $this
     */
    protected function orderByMethod($attribute, $expression) {
        $this->setOrderBy($attribute, $expression);
        $this->setAllowedMethods(['limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    /**
     * You may use the limit method to limit the number of results returned
     *  from the query or to skip a given number of results in the query.
     */
    protected function limitMethod($from, $number) {
        $this->setLimit($from, $number);
        $this->setAllowedMethods(['limit', 'get', 'paginate']);
        return $this;
    }

    /**
     * The get method returns an Collection containing the results of the query where each result
     * is an instance of the PHP stdClass object. You may access each column's value by accessing
     * the column as a property of the object.
     *
     * @param array $array
     * @return array
     */
    protected function getMethod($array = []) {
        if ($this->sql == '') {
            if (empty($array))
                $fields = $this->getTableName() . '.*';
            else {
                foreach ($array as $key => $field)
                    $array[$key] = $this->getAttributeName($field);
                $fields = implode(' , ', $array);
            }
            $this->setSql("SELECT $fields FROM " . $this->getTableName());
        }
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }
        return [];
    }

    /**
     * The paginate method counts the total number of records matched by the query before
     * retrieving the records from the database. This is done so that the paginator knows how many
     * pages of records there are in total. However, if you do not plan to show the total number
     * of pages in your application's UI then the record count query is unnecessary.
     *
     * @param $perPage
     * @return array
     */
    protected function paginateMethod($perPage) {
        $totalRows = $this->getCount();
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = min($currentPage, $totalPages);
        $currentPage = max($currentPage, 1);
        $currentRow = ($currentPage - 1) * $perPage;
        $this->setLimit($currentRow, $perPage);
        if ($this->sql == '')
            $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }
        return [];
    }

    /**
     * To create a new record in the database, create a new model instance, set
     * attributes on the model, then call the save method.
     * The save method may also be used to update models that already exist in the database.
     *
     * @return $this
     * @throws \Exception
     */
    protected function saveMethod() {
        $fillString = $this->fill();
        if (!isset($this->{$this->primaryKey}))
            $this->setSql("INSERT INTO " . $this->getTableName() . " SET $fillString, " . $this->getAttributeName($this->createdAt) . "=Now()");
        else {
            $this->setSql("UPDATE " . $this->getTableName() . " SET $fillString, " . $this->getAttributeName($this->updatedAt) . "=Now()");
            $this->setWhere("AND", $this->getAttributeName($this->primaryKey) . " = ?");
            $this->addValue($this->primaryKey, $this->{$this->primaryKey});
        }
        $this->executeQuery();
        $this->resetQuery();
        if (!isset($this->{$this->primaryKey})) {
            $object = $this->findMethod(DBConnection::newInsertId());
            $defaultVars = get_class_vars(get_called_class());
            $allVars = get_object_vars($object);
            $differentVars = array_diff(array_keys($allVars), array_keys($defaultVars));
            foreach ($differentVars as $attribute)
                $this->inCastsAttributes($attribute) == true ? $this->registerAttribute($this, $attribute, $this->castEncodeValue($attribute, $object->$attribute)) : $this->registerAttribute($this, $attribute, $object->$attribute);
        }
        $this->resetQuery();
        $this->setAllowedMethods(['update', 'delete', 'find']);
        return $this;
    }

    /**
     * you should define which model attributes you want to make mass assignable. You may do this
     * using the $fillable property on the model.
     *
     * @return string
     */
    protected function fill() {
        $fillArray = array();
        foreach ($this->fillable as $attribute)
            if (isset($this->$attribute)) {
                if ($this->$attribute === '')
                    $this->$attribute = null;
                array_push($fillArray, $this->getAttributeName($attribute) . " = ?");
                $this->inCastsAttributes($attribute) == true ? $this->addValue($attribute, $this->castEncodeValue($attribute, $this->$attribute)) : $this->addValue($attribute, $this->$attribute);
            }
        $fillString = implode(', ', $fillArray);
        return $fillString;
    }
}
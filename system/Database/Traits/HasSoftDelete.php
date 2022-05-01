<?php

namespace System\Database\Traits;

trait HasSoftDelete {
    /**
     * To delete a model, call the delete method on a model instance.
     *
     * @param null $id
     * @return mixed
     */
    protected function deleteMethod($id = null) {
        $object = $this;
        if ($id) {
            $this->resetQuery();
            $object = $this->findMethod($id);
        }
        if ($object) {
            $object->resetQuery();
            $object->setSql("UPDATE " . $object->getTableName() . " SET " . $this->getAttributeName($this->deletedAt) . " = NOW() ");
            $object->setWhere("AND", $this->getAttributeName($object->primaryKey) . " = ?");
            $object->addValue($object->primaryKey, $object->{$object->primaryKey});
            return $object->executeQuery();
        }
    }

    /**
     * The model's all method will retrieve all of the records from the model's
     * associated database table.
     *
     * @return array
     */
    protected function allMethod() {
        $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $this->setWhere("AND", $this->getAttributeName($this->deletedAt) . " IS NULL ");
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
        $this->resetQuery();
        $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $this->setWhere("AND", $this->getAttributeName($this->primaryKey) . " = ? ");
        $this->addValue($this->primaryKey, $id);
        $this->setWhere("AND", $this->getAttributeName($this->deletedAt) . " IS NULL ");
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        $this->setAllowedMethods(['update', 'delete', 'save']);
        if ($data)
            return $this->arrayToAttributes($data);
        return null;
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
        if ($this->getSql() == '') {
            if (empty($array))
                $fields = $this->getTableName() . '.*';
            else {
                foreach ($array as $key => $field)
                    $array[$key] = $this->getAttributeName($field);
                $fields = implode(' , ', $array);
            }
            $this->setSql("SELECT $fields FROM " . $this->getTableName());
        }
        $this->setWhere("AND", $this->getAttributeName($this->deletedAt) . " IS NULL ");
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
        $this->setWhere("AND", $this->getAttributeName($this->deletedAt) . " IS NULL ");
        $totalRows = $this->getCount();
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = min($currentPage, $totalPages);
        $currentPage = max($currentPage, 1);
        $currentRow = ($currentPage - 1) * $perPage;
        $this->setLimit($currentRow, $perPage);
        if ($this->getSql() == '')
            $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }
        return [];
    }
}
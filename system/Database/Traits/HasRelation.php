<?php

namespace System\Database\Traits;

trait HasRelation {
    /**
     * A one-to-one relationship is a very basic type of database relationship
     * To define this relationship, should call the hasOne method and return its result.
     * @param $model
     * @param $foreign
     * @param $localKey
     * @return mixed
     */
    protected function hasOne($model, $foreignKey, $localKey) {
        if ($this->{$this->primaryKey}) {
            $modelObject = new $model();
            return $modelObject->getHasOneRelation($this->table, $foreignKey, $localKey, $this->$localKey);
        }
    }

    /**
     * @param $table
     * @param $foreignKey
     * @param $otherKey
     * @param $otherKeyValue
     * @return |null
     */
    public function getHasOneRelation($table, $foreignKey, $otherKey, $otherKeyValue) {
        // sql = 'SELECT phones.* FROM users JOIN phones ON users.id = phones.user_id'
        $this->setSql("SELECT `b`.* FROM `{$table}` AS `a` JOIN " . $this->getTableName() . " AS `b` on `a`.`{$otherKey}` = `b`.`{$foreignKey}` ");
        $this->setWhere('AND', "`a`.`$otherKey` = ? ");
        $this->table = 'b';
        $this->addValue($otherKey, $otherKeyValue);
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        if ($data)
            return $this->arrayToAttributes($data);
        return null;
    }

    /**
     * A one-to-many relationship is used to define relationships where a single model is
     * the parent to one or more child models.
     *
     * @param $model
     * @param $foreignKey
     * @param $otherKey
     * @return mixed
     */
    protected function hasMany($model, $foreignKey, $otherKey) {
        if ($this->{$this->primaryKey}) {
            $modelObject = new $model;
            return $modelObject->getHasManyRelation($this->table, $foreignKey, $otherKey, $this->$otherKey);
        }
    }

    /**
     * @param $table
     * @param $foreignKey
     * @param $otherKey
     * @param $otherKeyValue
     * @return $this
     */
    public function getHasManyRelation($table, $foreignKey, $otherKey, $otherKeyValue) {
        // sql = 'SELECT posts.* FROM categories JOIN posts ON categories.id = posts.cat_id'
        // sql = 'SELECT categories.* FROM categories JOIN categories ON categories.id = categories.parent_id'
        $this->setSql("SELECT `b`.* FROM `{$table}` AS `a` JOIN " . $this->getTableName() . " AS `b` on `a`.`{$otherKey}` = `b`.`{$foreignKey}` ");
        $this->setWhere('AND', "`a`.`$otherKey` = ? ");
        $this->table = 'b';
        $this->addValue($otherKey, $otherKeyValue);
        return $this;
    }

    /**
     * We can define the inverse of a hasOne relationship using the belongsTo method.
     *
     * @param $model
     * @param $foreignKey
     * @param $localKey
     * @return mixed
     */
    protected function belongsTo($model, $foreignKey, $localKey) {
        if ($this->{$this->primaryKey}) {
            $modelObject = new $model();
            return $modelObject->getBelongsToRelation($this->table, $foreignKey, $localKey, $this->$foreignKey);
        }
    }

    /**
     * @param $table
     * @param $foreignKey
     * @param $otherKey
     * @param $foreignKeyValue
     * @return |null
     */
    public function getBelongsToRelation($table, $foreignKey, $otherKey, $foreignKeyValue) {
        // sql = 'SELECT posts.* FROM categories JOIN posts ON categories.id = posts.cat_id'
        $this->setSql("SELECT `b`.* FROM `{$table}` AS `a` JOIN " . $this->getTableName() . " AS `b` on `a`.`{$foreignKey}` = `b`.`{$otherKey}` ");
        $this->setWhere('AND', "`a`.`$foreignKey` = ? ");
        $this->table = 'b';
        $this->addValue($foreignKey, $foreignKeyValue);
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        if ($data)
            return $this->arrayToAttributes($data);
        return null;
    }

    /**
     * Many-to-many relationships are defined by writing a method that returns the result of the
     * belongsToMany method.
     *
     * @param $model
     * @param $commonTable
     * @param $localKey
     * @param $middleForeignKey
     * @param $middleRelation
     * @param $foreignKey
     * @return mixed
     */
    protected function belongsToMany($model, $commonTable, $localKey, $middleForeignKey, $middleRelation, $foreignKey) {
        if ($this->{$this->primaryKey}) {
            $modelObject = new $model();
            return $modelObject->getBelongsToManyRelation($this->table, $commonTable, $localKey, $this->$localKey, $middleForeignKey, $middleRelation, $foreignKey);
        }
    }

    /**
     * @param $table
     * @param $commonTable
     * @param $localKey
     * @param $localKeyValue
     * @param $middleForeignKey
     * @param $middleRelation
     * @param $foreignKey
     * @return $this
     */
    protected function getBelongsToManyRelation($table, $commonTable, $localKey, $localKeyValue, $middleForeignKey, $middleRelation, $foreignKey) {
        // $sql = "SELECT posts.* FROM ( SELECT category_post.* FROM categories JOIN category_post on categories.id = category_post.cat_id WHERE  categories.id = ? ) as relation JOIN posts on relation.post_id=posts.id ";
        $this->setSql("SELECT `c`.* FROM ( SELECT `b`.* FROM `{$table}` AS `a` JOIN `{$commonTable}` AS `b` on `a`.`{$localKey}` = `b`.`{$middleForeignKey}` WHERE  `a`.`{$localKey}` = ? ) AS `relation` JOIN " . $this->getTableName() . " AS `c` ON `relation`.`{$middleRelation}` = `c`.`$foreignKey`");
        $this->addValue("{$table}_{$localKey}", $localKeyValue);
        $this->table = 'c';
        return $this;
    }
}

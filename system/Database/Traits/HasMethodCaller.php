<?php

namespace System\Database\Traits;

trait HasMethodCaller {

    private $allMethods = ['create', 'update', 'delete', 'find', 'all', 'save', 'where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate'];
    private $allowedMethods = ['create', 'update', 'delete', 'find', 'all', 'save', 'where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate'];

    /**
     * Method call
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args) {
        return $this->methodCaller($this, $method, $args);
    }

    /**
     * Static method call
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic($method, $args) {
        $className = get_called_class();
        $instance = new $className;
        return $instance->methodCaller($instance, $method, $args);
    }

    /**
     * Calls Methods defined in HasCRUD trait.
     *
     * @return mixed
     */
    private function methodCaller($object, $method, $args) {
        $suffix = 'Method';
        $methodName = $method . $suffix;
        if (in_array($method, $this->allowedMethods))
            return call_user_func_array(array($object, $methodName), $args);
    }

    /**
     * Methods can be used in the sql command.
     *
     * @param $array
     */
    protected function setAllowedMethods($array) {
        $this->allowedMethods = $array;
    }
}
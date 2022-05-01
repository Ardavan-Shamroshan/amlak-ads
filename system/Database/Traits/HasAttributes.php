<?php

namespace System\Database\Traits;

trait HasAttributes {

    /**
     * Import database records to the array
     *
     * @param $object
     * @param string $attribute
     * @param $value
     */
    private function registerAttribute($object, string $attribute, $value) {
        $this->inCastsAttributes($attribute) == true ? $object->$attribute = $this->castDecodeValue($attribute, $value) : $object->$attribute = $value;
    }

    /**
     * Every record is one of the array keys
     *
     * @param array $array
     * @param null $object
     * @return mixed
     */
    protected function arrayToAttributes(array $array, $object = null) {
        if (!$object) {
            $className = get_called_class();
            $object = new $className;
        }
        foreach ($array as $attribute => $value) {
            if ($this->inHiddenAttributes($attribute))
                continue;
            $this->registerAttribute($object, $attribute, $value);
        }
        return $object;
    }

    /**
     * Casts sql returned array to object and import into the collection
     *
     * @param array $array
     */
    protected function arrayToObjects(array $array) {
        $collection = [];
        foreach ($array as $value) {
            $object = $this->arrayToAttributes($value);
            array_push($collection, $object);
        }
        $this->collection = $collection;
    }

    /**
     * Hides attributes are not necessary to show
     *
     * @param $attribute
     * @return bool
     */
    private function inHiddenAttributes($attribute) {
        return in_array($attribute, $this->hidden);
    }

    /**
     * Casts the attribute before store in database
     *
     * @param $attribute
     * @return bool
     */
    private function inCastsAttributes($attribute) {
        return in_array($attribute, array_keys($this->casts));
    }

    /**
     * Decodes value before fetch operate from database
     *
     * @param $attributeKey
     * @param $value
     * @return mixed
     */
    private function castDecodeValue($attributeKey, $value) {
        if ($this->casts[$attributeKey] == 'array' || $this->casts[$attributeKey] == 'object')
            return unserialize($value);
        return $value;
    }

    /**
     * Encodes value before store operate into database
     *
     * @param $attributeKey
     * @param $value
     * @return string
     */
    private function castEncodeValue($attributeKey, $value) {
        if ($this->casts[$attributeKey] == 'array' || $this->casts[$attributeKey] == 'object')
            return serialize($value);
        return $value;
    }

    /**
     * Returns an array of encoded values
     *
     * @param $values
     * @return array
     */
    private function arrayToCastEncodeValue($values) {
        $newArray = [];
        foreach ($values as $attribute => $value)
            $this->inCastsAttributes($attribute) == true ? $newArray[$attribute] = $this->castEncodeValue($attribute, $value) : $newArray[$attribute] = $value;
        return $newArray;
    }
}

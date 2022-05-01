<?php

namespace System\Request\Traits;

trait HasRunValidation {
    /**
     * When an Error occurs by, system will redirects back the user to the referrer route using the
     * global back helper function.
     *
     * @return mixed
     */
    protected function errorRedirect() {
        if ($this->errorExist == false)
            return $this->request;
        return back();
    }

    private function checkFirstError($name) {
        if (!errorExists($name) && !in_array($name, $this->errorVariablesName))
            return true;
        return false;
    }

    /**
     * Sometimes you may wish to stop running validation rules on an attribute after the first
     * validation failure
     *
     * @param $name
     * @return bool
     */
    private function checkFieldExist($name) {
        return (isset($this->request[$name]) && !empty($this->request[$name])) ? true : false;
    }

    /**
     * Check if column exist in Laravel model's table and then apply condition.
     *
     * @param $name
     * @return bool
     */
    private function checkFileExist($name) {
        if (isset($this->files[$name]['name']))
            if (!empty($this->files[$name]['name']))
                return true;
        return false;
    }

    /**
     * Determine if file exists.
     *
     * @param $name
     * @return bool
     */
    private function setError($name, $errorMessage) {
        array_push($this->errorVariablesName, $name);
        error($name, $errorMessage);
        $this->errorExist = true;
    }
}
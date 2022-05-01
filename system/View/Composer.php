<?php

namespace System\View;

class Composer {
    private static $instance;
    private $vars = [];
    private $viewArray = [];
    private $registeredViewArray = [];

    /**
     * Composer constructor.
     */
    private function __construct() {
    }

    /**
     * Registers views in viewArray array.
     *
     * @param $name
     * @param $callback
     */
    private function registerView($name, $callback) {
        $this->registeredViewArray[$name] = $callback;
    }

    /**
     * Sets views.
     *
     * @param $viewArray
     */
    private function setViewArray($viewArray) {
        $this->viewArray = $viewArray;
    }

    /**
     * Gets views.
     *
     * @return array
     */
    private function getViewVars() {
        foreach ($this->viewArray as $viewName) {
            if (isset($this->registeredViewArray[str_replace('/', '.', $viewName)])) {
                $callback = $this->registeredViewArray[str_replace('/', '.', $viewName)];
                $viewVars = $callback();
                foreach ($viewVars as $key => $value) {
                    $this->vars[$key] = $value;
                }
            }
        }
        return $this->vars;
    }

    /**
     * Static call Composer class functions.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments) {
        $instance = self::getInstance();
        switch ($name) {
            case "view":
                return call_user_func_array(array($instance, "registerView"), $arguments);
                break;
            case "setViews":
                return call_user_func_array(array($instance, "setViewArray"), $arguments);
                break;
            case "getVars":
                return call_user_func_array(array($instance, "getViewVars"), $arguments);
                break;
        }
    }

    /**
     * Singleton design pattern
     *
     * @return Composer
     */
    private static function getInstance() {
        if (empty(self::$instance))
            self::$instance = new self;
        return self::$instance;
    }
}
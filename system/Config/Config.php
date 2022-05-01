<?php

namespace System\Config;

class Config {

    private static $instance;
    private $config_nested_array = [];
    private $config_dot_array = [];

    /**
     * Config constructor.
     */
    private function __construct() {
        $this->initialConfigArrays();
    }

    /**
     * Configs arrays and reads nested arrays.
     */
    private function initialConfigArrays() {
        $configPath = dirname(dirname(__DIR__)) . '/config/';
        foreach (glob($configPath . '*.php') as $fileName) {
            $config = require $fileName;
            $key = $fileName;
            $key = str_replace($configPath, '', $key);
            $key = str_replace('.php', '', $key);
            $this->config_nested_array[$key] = $config;
        }
        $this->initialDefaultValues();
        $this->config_dot_array = $this->array_dot($this->config_nested_array);
    }

    /**
     * This path is the current path that the user is currently on. This is used when the
     * framework needs to place the user's current route in a notification or
     * any other location as required by the application or its packages.
     */
    private function initialDefaultValues() {
        $temporary = str_replace($this->config_nested_array['app']['BASE_URL'], '', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $temporary === "/" ? $temporary = "" : $temporary = substr($temporary, 1);
        $this->config_nested_array['app']['CURRENT_ROUTE'] = $temporary;
    }

    /**
     * Reads array separated with dot.
     *
     * @param $array
     * @param array $return_array
     * @param string $return_key
     * @return array
     */
    private function array_dot($array, $return_array = array(), $return_key = '') {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $return_array = array_merge($return_array, $this->array_dot($value, $return_array, $return_key . $key . '.'));
            } else {
                $return_array[$return_key . $key] = $value;
            }
        }
        return $return_array;
    }

    /**
     * Singleton design pattern
     *
     * @return Config
     */
    private static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get method.
     *
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public static function get($key) {
        $instance = self::getInstance();
        if (isset($instance->config_dot_array[$key])) {
            return $instance->config_dot_array[$key];
        } else {
            throw new \Exception('"' . $key . '" not exist in config array');
        }
    }
}
<?php

namespace System\Session;

class Session {
    /**
     * Set session.
     *
     * @param $name
     * @param $value
     */
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    /**
     * Get session.
     *
     * @param $name
     * @return bool|mixed
     */
    public function get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }

    /**
     * Unset session.
     *
     * @param $name
     */
    public function remove($name) {
        if (isset($_SESSION[$name]))
            unset($_SESSION[$name]);
    }

    /**
     * Call in static.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments) {
        $instance = new self();
        return call_user_func_array([$instance, $name], $arguments);
    }
}
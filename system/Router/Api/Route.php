<?php

namespace System\Router\Api;

class Route {
    /**
     * Register a new GET api route with the router.
     *
     * @param string $url
     * @param array|string $executeMethod
     * @param string|null $name
     * @return \System\Router\Route
     */
    public static function get($url, $executeMethod, $name = null) {
        $executeMethod = explode('@', $executeMethod);
        $class = $executeMethod[0];
        $method = $executeMethod[1];
        global $routes;
        array_push($routes['get'], array('url' => "api/" . trim($url, "/ "), 'class' => $class, 'method' => $method, 'name' => $name));
    }

    /**
     * Register a new POST api route with the router.
     *
     * @param string $url
     * @param array|string $executeMethod
     * @param string|null $name
     * @return \System\Router\Route
     */
    public static function post($url, $executeMethod, $name = null) {
        $executeMethod = explode('@', $executeMethod);
        $class = $executeMethod[0];
        $method = $executeMethod[1];
        global $routes;
        array_push($routes['post'], array('url' => "api/" . trim($url, "/ "), 'class' => $class, 'method' => $method, 'name' => $name));
    }
}


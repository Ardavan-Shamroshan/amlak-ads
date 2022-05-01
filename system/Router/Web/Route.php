<?php

namespace System\Router\Web;

class Route {
    /**
     * Register a new GET route with the router.
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
        array_push($routes['get'], array('url' => trim($url, "/ "), 'class' => $class, 'method' => $method, 'name' => $name));
    }

    /**
     * Register a new POST route with the router.
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
        array_push($routes['post'], array('url' => trim($url, "/ "), 'class' => $class, 'method' => $method, 'name' => $name));
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param string $url
     * @param array|string $executeMethod
     * @param string|null $name
     * @return \System\Router\Route
     */
    public static function put($url, $executeMethod, $name = null) {
        $executeMethod = explode('@', $executeMethod);
        $class = $executeMethod[0];
        $method = $executeMethod[1];
        global $routes;
        array_push($routes['put'], array('url' => trim($url, "/ "), 'class' => $class, 'method' => $method, 'name' => $name));
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param string $url
     * @param array|string $executeMethod
     * @param string|null $name
     * @return \System\Router\Route
     */
    public static function delete($url, $executeMethod, $name = null) {
        $executeMethod = explode('@', $executeMethod);
        $class = $executeMethod[0];
        $method = $executeMethod[1];
        global $routes;
        array_push($routes['delete'], array('url' => trim($url, "/ "), 'class' => $class, 'method' => $method, 'name' => $name));
    }
}
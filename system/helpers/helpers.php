<?php
/*
 |--------------------------------------------------------------------------
 | Helpers
 |--------------------------------------------------------------------------
 |
 | Foenix includes a variety of global "helper" PHP functions. Many of these functions are used by
 | the framework itself; however, you are free to use them in your own applications if you find
 | them convenient.
 |
 */

/**
 * The dd function dumps the given variables and ends execution of the script.
 *
 * @param $value
 * @param bool $die
 */
function dd($value, $die = true) {
    var_dump($value);
    if ($die)
        exit();
}

/**
 * The view function retrieves a view instance.
 *
 * @param $dir
 * @param array $vars
 * @throws Exception
 */
function view($dir, $vars = []) {
    $viewBuilder = new \System\View\ViewBuilder();
    $viewBuilder->run($dir);
    $viewVars = $viewBuilder->vars;
    $content = $viewBuilder->content;
    empty($viewVars) ?: extract($viewVars);
    empty($vars) ?: extract($vars);
    eval(" ?> " . html_entity_decode($content));
}

/**
 * Decodes html contents.
 *
 * @param $text
 * @return string
 */
function html($text) {
    return html_entity_decode($text);
}

/**
 * The old function retrieves an old input value flashed into the session.
 *
 * @param $name
 * @return mixed|null
 */
function old($name) {
    if (isset($_SESSION["temporary_old"][$name])) {
        return $_SESSION["temporary_old"][$name];
    } else {
        return null;
    }
}

/**
 * @param $name
 * @param null $message
 * @return bool|mixed
 */
function flash($name, $message = null) {
    if (empty($message))
        if (isset($_SESSION["temporary_flash"][$name])) {
            $temporary = $_SESSION["temporary_flash"][$name];
            unset($_SESSION["temporary_flash"][$name]);
            return $temporary;
        } else
            return false;
    else
        $_SESSION["flash"][$name] = $message;
}

/**
 * @param $name
 * @return bool
 */
function flashExists($name) {
    return isset($_SESSION["temporary_flash"][$name]) === true ? true : false;
}

/**
 * @return bool|mixed
 */
function allFlashes() {
    if (isset($_SESSION["temporary_flash"])) {
        $temporary = $_SESSION["temporary_flash"];
        unset($_SESSION["temporary_flash"]);
        return $temporary;
    } else {
        return false;
    }
}

/**
 * @param $name
 * @param null $message
 * @return bool|mixed
 */
function error($name, $message = null) {
    if (empty($message))
        if (isset($_SESSION["temporary_errorFlash"][$name])) {
            $temporary = $_SESSION["temporary_errorFlash"][$name];
            unset($_SESSION["temporary_errorFlash"][$name]);
            return $temporary;
        } else
            return false;
    else
        $_SESSION["errorFlash"][$name] = $message;
}

/**
 * @param $name
 * @return bool
 */
function errorExists($name = null) {
    if ($name === null)
        return isset($_SESSION['temporary_errorFlash']) === true ? count($_SESSION['temporary_errorFlash']) : false;
    else
        return isset($_SESSION['temporary_errorFlash'][$name]) === true ? true : false;
}

/**
 * @return bool|mixed
 */
function allErrors() {
    if (isset($_SESSION["temporary_errorFlash"])) {
        $temporary = $_SESSION["temporary_errorFlash"];
        unset($_SESSION["temporary_errorFlash"]);
        return $temporary;
    } else
        return false;
}

/**
 * This path is the current domain that the system is currently on. This is used when the
 * framework needs to place the current domain in a notification or
 * any other location as required by the application or its packages.
 *
 * @return string
 */
function currentDomain() {
    $httpProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on") ? "https://" : "http://";
    $currentUrl = $_SERVER['HTTP_HOST'];
    return $httpProtocol . $currentUrl;
}

/**
 * The redirect function returns a redirect HTTP response, or returns the redirector instance if
 * called with no arguments:
 *
 * @param $url
 */
function redirect($url) {
    $url = trim($url, '/ ');
    $url = strpos($url, currentDomain()) === 0 ? $url : currentDomain() . '/' . $url;
    header("Location: " . $url);
    exit;
}

/**
 * The back function generates a redirect HTTP response to the user's previous location:
 */
function back() {
    $http_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    redirect($http_referer);
}

/**
 * The asset function generates a URL for an asset using the
 * current scheme of the request (HTTP or HTTPS).
 *
 * @param $src
 * @return string
 */
function asset($src) {
    return currentDomain() . ("/" . trim($src, "/ "));
}

/**
 * The url function generates a fully qualified URL to the given path.
 *
 * @param $url
 * @return string
 */
function url($url) {
    return currentDomain() . ("/" . trim($url, "/ "));
}

/**
 * Finds routes by the name you define.
 *
 * @param $name
 * @return mixed|null
 */
function findRouteByName($name) {
    global $routes;
    $allRoutes = array_merge($routes['get'], $routes['post'], $routes['put'], $routes['delete']);
    $route = null;
    foreach ($allRoutes as $element)
        if ($element['name'] == $name && $element['name'] !== null) {
            $route = $element['url'];
            break;
        }
    return $route;
}

/**
 * The route function generates a URL for a given named route.
 *
 * @param $name
 * @param array $params
 * @return string
 * @throws Exception
 */
function route($name, $params = []) {
    if (!is_array($params))
        throw new Exception('route params must be array!');
    $route = findRouteByName($name);
    if ($route === null)
        throw new Exception('route not found');
    $params = array_reverse($params);
    $routeParamsMatch = [];
    preg_match_all("/{[^}.]*}/", $route, $routeParamsMatch);
    if (count($routeParamsMatch[0]) > count($params))
        throw new Exception('route params not enough!!');
    foreach ($routeParamsMatch[0] as $key => $routeMatch)
        $route = str_replace($routeMatch, array_pop($params), $route);
    return currentDomain() . "/" . trim($route, " /");
}

/**
 * The generateToken function retrieves the value of the current token using bin2hex function.
 *
 * @return string
 */
function generateToken() {
    return bin2hex(openssl_random_pseudo_bytes(32));
}

/**
 * The method_field function generates an HTML hidden input field containing the spoofed value of
 * the form's HTTP verb. For example, using Blade syntax.
 *
 * @return string
 */
function methodField() {
    $method_field = strtolower($_SERVER['REQUEST_METHOD']);
    if ($method_field == 'post')
        if (isset($_POST['_method']))
            if ($_POST['_method'] == 'put')
                $method_field = 'put';
            elseif ($_POST['_method'] == 'delete')
                $method_field = 'delete';
    return $method_field;
}

/**
 * Reads array separated with dot.
 *
 * @param $array
 * @param array $return_array
 * @param string $return_key
 * @return array
 */
function array_dot($array, $return_array = array(), $return_key = '') {
    foreach ($array as $key => $value)
        if (is_array($value))
            $return_array = array_merge($return_array, array_dot($value, $return_array, $return_key . $key . '.'));
        else
            $return_array[$return_key . $key] = $value;
    return $return_array;
}

/**
 * This path is the current url that the user is currently on. This is used when the
 * framework needs to place the current url in a notification or
 * any other location as required by the application or its packages.
 */
function currentUrl() {
    return currentDomain() . $_SERVER['REQUEST_URI'];
}
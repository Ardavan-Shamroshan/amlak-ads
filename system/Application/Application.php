<?php

namespace System\Application;

class Application {
    /**
     * Application constructor.
     */
    public function __construct() {
        $this->loadProviders();
        $this->loadHelpers();
        $this->registerRoutes();
        $this->routing();
    }

    /**
     * Loads registered Providers.
     */
    private function loadProviders() {
        $appConfigs = require dirname(dirname(__DIR__)) . '/config/app.php';
        $providers = $appConfigs['providers'];
        foreach ($providers as $provider) {
            $providerObject = new $provider();
            $providerObject->boot();
        }
    }

    /**
     * Loads register helpers.
     */
    private function loadHelpers() {
        require_once(dirname(__DIR__) . '/helpers/helpers.php');
        if (file_exists(dirname(dirname(__DIR__)) . '/app/Http/Helpers.php'))
            require_once(dirname(dirname(__DIR__)) . '/app/Http/Helpers.php');
    }

    /** --------------------------------------------------------------------------
     * HTTP Verbs
     * --------------------------------------------------------------------------
     * HTTP defines a set of request methods to indicate the desired action to be performed for
     * a given resource.
     * Web applications commonly use two methods to handle the incoming requests from the client.
     */
    private function registerRoutes() {
        global $routes;
        $routes = [
            'get' => [],
            'post' => [],
            'put' => [],
            'delete' => []
        ];
        require_once(dirname(dirname(__DIR__)) . '/routes/web.php');
        require_once(dirname(dirname(__DIR__)) . '/routes/api.php');
    }

    /**
     *  Run Routing System
     */
    private function routing() {
        $routing = new \System\Router\Routing();
        $routing->run();
    }
}
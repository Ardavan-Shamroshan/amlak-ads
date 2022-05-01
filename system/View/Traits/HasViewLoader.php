<?php

namespace System\View\Traits;

trait HasViewLoader {
    private $viewNameArray = [];

    /**
     * Since this view is stored at resources/views/..., it loads with the view loader function.
     *
     * @param $dir
     * @return false|string
     * @throws \Exception
     */
    private function viewLoader($dir) {
        $dir = trim($dir, " .");
        $dir = str_replace(".", "/", $dir);
        if (file_exists(dirname(dirname(dirname(__DIR__))) . "/resources/view/$dir.blade.php")) {
            $this->registerView($dir);
            $content = htmlentities(file_get_contents(dirname(dirname(dirname(__DIR__))) . "/resources/view/$dir.blade.php"));
            return $content;
        } else
            throw new \Exception('view not Found!!!!');
    }

    /**
     * Register views in the viewNameArray array.
     *
     * @param $view
     */
    private function registerView($view) {
        array_push($this->viewNameArray, $view);
    }
}

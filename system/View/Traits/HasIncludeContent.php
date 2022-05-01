<?php

namespace System\View\Traits;

trait HasIncludeContent {
    /**
     * Check if @include is in view page.
     */
    private function checkIncludesContent() {
        while (1) {
            $includesNamesArray = $this->findIncludesNames();
            if (!empty($includesNamesArray))
                foreach ($includesNamesArray as $includeName)
                    $this->initialIncludes($includeName);
            else
                break;
        }
    }

    /**
     * find @iclude in view page.
     */
    private function findIncludesNames() {
        $includesNamesArray = [];
        preg_match_all("/@include+\('([^)]+)'\)/", $this->content, $includesNamesArray, PREG_UNMATCHED_AS_NULL);
        return isset($includesNamesArray[1]) ? $includesNamesArray[1] : false;
    }

    /**
     * Runs @include contents.
     *
     * @param $includeName
     */
    private function initialIncludes($includeName) {
        $this->content = str_replace("@include('$includeName')", $this->viewLoader($includeName), $this->content);
    }
}
<?php

namespace System\Request\Traits;

trait HasFileValidationRules {
    /**
     * File validation.
     *
     * @param $name
     * @param $ruleArray
     */
    protected function fileValidation($name, $ruleArray) {
        foreach ($ruleArray as $rule)
            if ($rule == "required")
                $this->fileRequired($name);
            elseif (strpos($rule, "mimes:") === 0) {
                $rule = str_replace('mimes:', "", $rule);
                $rule = explode(',', $rule);
                $this->fileType($name, $rule);
            } elseif (strpos($rule, "max:") === 0) {
                $rule = str_replace('max:', "", $rule);
                $this->maxFile($name, $rule);
            } elseif (strpos($rule, "min:") === 0) {
                $rule = str_replace('min:', "", $rule);
                $this->minFile($name, $rule);
            }
    }

    /**
     * The field under validation must be present in the input file type data and not empty.
     *
     * @param $name
     */
    protected function fileRequired($name) {
        if (!isset($this->files[$name]['name']) || empty($this->files[$name]['name']) && $this->checkFirstError($name)) {
            $this->setError($name, "$name is required");
        }
    }

    /**
     * The field under validation must be a successfully uploaded file.
     *
     * @param $name
     * @param $typesArray
     */
    protected function fileType($name, $typesArray) {
        if ($this->checkFirstError($name) && $this->checkFileExist($name)) {
            $currentFileType = explode('/', $this->files[$name]['type'])[1];
            if (!in_array($currentFileType, $typesArray))
                $this->setError($name, "$name type must be " . implode(', ', $typesArray));
        }
    }

    /**
     * The field under validation must be less than or equal to a maximum file size value.
     *
     * @param $name
     * @param $size
     */
    protected function maxFile($name, $size) {
        $size = $size * 1024;
        if ($this->checkFirstError($name) && $this->checkFileExist($name))
            if ($this->files[$name]['size'] > $size)
                $this->setError($name, "$name size must be lower than " . ($size / 1024) . " kb");
    }

    /**
     * The field under validation must have a minimum file size value.
     *
     * @param $name
     * @param $size
     */
    protected function minFile($name, $size) {
        $size = $size * 1024;
        if ($this->checkFirstError($name) && $this->checkFileExist($name))
            if ($this->files[$name]['size'] < $size)
                $this->setError($name, "$name size must be upper than " . ($size / 1024) . " kb");
    }
}
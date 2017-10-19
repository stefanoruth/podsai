<?php

if (!function_exists('formatInput')) {
    /**
     * Formats a value
     * @param  string $value
     * @return mixed
     */
    function formatInput($value)
    {
        if ($value instanceof \SimpleXMLElement) {
            $value = (string) $value;
        }
        
        if (strlen(trim($value)) > 0) {
            return trim($value);
        }
    }
}
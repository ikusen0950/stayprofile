<?php

namespace App\Validation;

class CustomRules
{
    /**
     * Validates that a field is either valid JSON or a valid array
     * 
     * @param string|array|null $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function valid_json_or_array($str = null, string $fields = null, array $data = []): bool
    {
        // Allow null or empty values
        if (is_null($str) || $str === '' || (is_array($str) && empty($str))) {
            return true;
        }
        
        // If it's an array, it's valid (will be converted to JSON later)
        if (is_array($str)) {
            return true;
        }
        
        // If it's a string, check if it's valid JSON
        if (is_string($str)) {
            json_decode($str);
            return json_last_error() === JSON_ERROR_NONE;
        }
        
        return false;
    }
    
    /**
     * Validates that array contains only numeric values
     * 
     * @param string|array|null $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function valid_numeric_array($str = null, string $fields = null, array $data = []): bool
    {
        // Allow null or empty values
        if (is_null($str) || $str === '' || (is_array($str) && empty($str))) {
            return true;
        }
        
        // If it's an array, check all values are numeric
        if (is_array($str)) {
            foreach ($str as $value) {
                if (!is_numeric($value)) {
                    return false;
                }
            }
            return true;
        }
        
        // If it's a string, try to decode and validate
        if (is_string($str)) {
            $decoded = json_decode($str, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return false;
            }
            
            if (!is_array($decoded)) {
                return false;
            }
            
            foreach ($decoded as $value) {
                if (!is_numeric($value)) {
                    return false;
                }
            }
            return true;
        }
        
        return false;
    }
}
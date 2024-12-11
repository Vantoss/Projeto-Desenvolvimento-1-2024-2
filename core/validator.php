<?php 

class Validator{
    public static function string($value, $min, $max = INF){

        $value = trim(preg_replace('/\s+/', ' ',$value));

        return strlen($value) >= $min && strlen($value) >= $max;
    }
}
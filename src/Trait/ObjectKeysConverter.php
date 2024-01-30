<?php

namespace App\Trait;

trait ObjectKeysConverter
{

    public function snakeCaseToCamelCase($string): string
    {
        return lcfirst(str_replace('_', '', ucwords($string, '_')));
    }

    private function camelCaseToSnakeCase($input): string
    {
        preg_match_all('/[A-Z][a-z]+|[a-z]+/', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ?
                strtolower($match) :
                lcfirst($match);
        }
        return implode('_', $ret);
    }


}
<?php

namespace App\Service;

class RequestService
{

    public function getBody(string ...$keys): array
    {
        if (empty($_POST)) {
            return [];
        }

        $data = [];
        foreach ($keys as $key) {
            if (isset($_POST[$key])) {
                $data[$key] = $_POST[$key];
            }
        }

        return $data;
    }

    public function getParams(string ...$keys): array
    {
        $data = [];

        foreach ($keys as $key) {
            if (isset($_GET[$key])) {
                $data[$key] = $_GET[$key];
            }
        }

        return $data;
    }

}
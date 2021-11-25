<?php

namespace App\Controllers;

trait CheckMernisTrait
{
    public function checkMernis($name = null, $birthDate = null, $identity = null): \stdClass
    {
        $explodedFullName = explode(" ", $name);
        $lastName = end($explodedFullName);
        array_pop($explodedFullName);
        $firstName = implode(" ", $explodedFullName);
        $birth_year = date("Y", strtotime($birthDate));
        $data = new \stdClass();
        $data->firstName = $firstName;
        $data->lastName = $lastName;
        $data->identity = $identity;
        $data->birthYear = $birth_year;
        return $data;
    }
}
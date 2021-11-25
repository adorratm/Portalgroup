<?php

namespace App\Controllers;

use Exception;
use function helper;
use function validateJWTFromRequest;

trait CompanyTrait
{
    /**
     * @throws Exception
     */
    public function getCompany($authenticationHeader): object|array
    {
        helper('jwt');
        return validateJWTFromRequest(getJWTFromRequest($authenticationHeader));
    }
}
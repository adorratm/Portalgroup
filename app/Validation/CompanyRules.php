<?php

namespace App\Validation;

use App\Models\CompanyModel;
use Exception;

class CompanyRules
{
    public function validateCompany(string $str, string $fields, array $data): bool
    {
        try {
            $model = new CompanyModel();
            $company = $model->findCompanyByEmailAddress($data['email']);
            return password_verify($data['password'], $company['password']);
        } catch (Exception $e) {
            return false;
        }
    }
}
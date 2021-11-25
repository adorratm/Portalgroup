<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Auth extends BaseController
{
    /**
     * Register a new company
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function register(): ResponseInterface
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[companies.email]',
            'password' => 'required|min_length[8]|max_length[255]'
        ];

        $input = $this->getRequestInput($this->request);
        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $companyModel = new CompanyModel();
        $companyModel->save($input);




        return $this
            ->getJWTForCompany(
                $input['email'],
                ResponseInterface::HTTP_CREATED
            );
    }

    /**
     * Authenticate Existing Company
     * @return ResponseInterface
     */
    public function login(): ResponseInterface
    {
        $rules = [
            'email' => 'required|min_length[6]|max_length[50]|valid_email',
            'password' => 'required|min_length[8]|max_length[255]|validateCompany[email, password]'
        ];

        $errors = [
            'password' => [
                'validateCompany' => 'Invalid login credentials provided'
            ]
        ];

        $input = $this->getRequestInput($this->request);


        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }
        return $this->getJWTForCompany($input['email']);
    }

    private function getJWTForCompany(
        string $emailAddress,
        int $responseCode = ResponseInterface::HTTP_OK
    ): ResponseInterface
    {
        try {
            $model = new CompanyModel();
            $company = $model->findCompanyByEmailAddress($emailAddress);
            unset($company['password']);

            helper('jwt');

            return $this
                ->getResponse(
                    [
                        'message' => 'Company authenticated successfully',
                        'company' => $company,
                        'access_token' => getSignedJWTForCompany($emailAddress)
                    ]
                );
        } catch (Exception $exception) {
            return $this
                ->getResponse(
                    [
                        'error' => $exception->getMessage(),
                    ],
                    $responseCode
                );
        }
    }
}

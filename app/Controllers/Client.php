<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\CompanyModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Client extends MernisChecker
{
    use CheckMernisTrait;
    use CompanyTrait;
    /**
     * Get all Clients
     * @return ResponseInterface
     * @throws Exception
     */
    public function index(): ResponseInterface
    {
        $model = new ClientModel();

        $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $company = $this->getCompany($authenticationHeader);
        return $this->getResponse(
            [
                'message' => 'Clients retrieved successfully',
                'clients' => $model->getAllClients($company["id"])
            ]
        );
    }

    /**
     * Create a new Client
     * @throws Exception
     */
    public function store(): ResponseInterface
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[clients.email]',
            'identity' => 'required|min_length[11]|max_length[11]|is_unique[clients.identity]',
            'birth_date' => 'required|check_date_format'
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $clientEmail = $input['email'];

        $model = new ClientModel();
        $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $company = $this->getCompany($authenticationHeader);
        // Check Mernis
        if(!empty($input['checkMernis']) && $input['checkMernis'] == "true")
        {
            // Call Trait
            $mernisTrait = $this->checkMernis($input["name"],$input["birth_date"],$input["identity"]);
            $result = $this->checkMernisState($mernisTrait->identity,$mernisTrait->firstName,$mernisTrait->lastName,$mernisTrait->birthYear);
            if($result){
                unset($input["checkMernis"]);
                $input["mernis_status"] = 1;
                $model->saveClient($company["id"],$input);
            }else{
                return $this->getResponse(
                    [
                        'message' => 'Client Mernis Identification Error.',
                    ]
                );
            }
        }else{
            unset($input["checkMernis"]);
            $input["mernis_status"] = 0;
            $model->saveClient($company["id"],$input);
        }

        $client = $model->where('email', $clientEmail)->first();
        if ($client){
            return $this->getResponse(
                [
                    'message' => 'Client added successfully',
                    'client' => $client
                ]
            );
        }else{
            return $this->getResponse(
                [
                    'message' => 'Error while adding client',
                ]
            );
        }
    }

    /**
     * Get a single client by ID
     */
    public function show($id): ResponseInterface
    {
        try {

            $clientModel = new ClientModel();
            $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');
            $company = $this->getCompany($authenticationHeader);
            $client = $clientModel->findClientById($id,$company["id"]);

            return $this->getResponse(
                [
                    'message' => 'Client retrieved successfully',
                    'client' => $client
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find client for specified ID'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    // Update Client
    public function update($id): ResponseInterface
    {
        try {

            $model = new ClientModel();
            $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');
            $company = $this->getCompany($authenticationHeader);
            $model->findClientById($id,$company["id"]);

            $input = $this->getRequestInput($this->request);
            // Check Mernis
            if(!empty($input['checkMernis']) && $input['checkMernis'] == "true")
            {
                // Call Trait
                $mernisTrait = $this->checkMernis($input["name"],$input["birth_date"],$input["identity"]);
                $result = $this->checkMernisState($mernisTrait->identity,$mernisTrait->firstName,$mernisTrait->lastName,$mernisTrait->birthYear);
                if($result){
                    unset($input["checkMernis"]);
                    $input["mernis_status"] = 1;
                    $model->updateClient($id,$company["id"], $input);
                }else{
                    return $this->getResponse(
                        [
                            'message' => 'Client Mernis Identification Error.',
                        ]
                    );
                }
            }else{
                unset($input["checkMernis"]);
                $input["mernis_status"] = 0;
                $model->updateClient($id,$company["id"], $input);
            }
            $client = $model->findClientById($id,$company["id"]);

            return $this->getResponse(
                [
                    'message' => 'Client updated successfully',
                    'client' => $client
                ]
            );
        } catch (Exception $exception) {

            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    // Destroy Client
    public function destroy($id): ResponseInterface
    {
        try {

            $model = new ClientModel();
            $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');
            $company = $this->getCompany($authenticationHeader);
            $client = $model->findClientById($id,$company["id"]);
            $model->delete($client);

            return $this
                ->getResponse(
                    [
                        'message' => 'Client deleted successfully',
                    ]
                );
        } catch (Exception $exception) {
            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }
}

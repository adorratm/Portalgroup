<?php

namespace App\Models;

use CodeIgniter\Model;

use Exception;

class ClientModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'email',
        'identity',
        'mernis_status',
        'birth_date',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * @param $id
     * @return array
     * @throws Exception
     * Get All Clients
     */
    public function getAllClients($id): array
    {
        $clients = $this
            ->asArray()
            ->join("client_w_company cwc", "cwc.client_id = clients.id")
            ->where(["cwc.company_id" => $id])
            ->findAll();

        if (!$clients) throw new Exception('Could not find clients');

        return $clients;
    }

    /**
     * @throws Exception
     * Find Client By ID
     */
    public function findClientById($id, $company_id): object|array
    {
        $client = $this
            ->asArray()
            ->join("client_w_company cwc", "cwc.client_id = clients.id")
            ->where(['clients.id' => $id, "company_id" => $company_id])
            ->first();

        if (!$client) throw new Exception('Could not find client for specified ID');

        return $client;
    }

    /**
     * @throws Exception
     */
    public function saveClient($company_id, $data): bool
    {
        if($this->db->table('clients')->insert($data)){
            $clientID = $this->db->insertID();
            $this->db->table("client_w_company")->insert(["client_id" => $clientID, "company_id" => $company_id]);
            return true;
        }else{
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function updateClient($id, $company_id,$data): bool
    {
        $client = $this->findClientById($id,$company_id);
        if(!empty($client)){
            return $this->update($id,$data);
        }
        return false;
    }
}

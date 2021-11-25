<?php

namespace App\Controllers;

use Exception;
use SoapClient;

abstract class MernisChecker extends BaseController implements ImernisChecker
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkMernisState(string $TCKimlikNo, string $Ad, string $Soyad, string $DogumYili): bool
    {
        // TODO: Implement checkMernisState() method.
        $soap = new SoapClient("https://tckimlik.nvi.gov.tr/service/kpspublic.asmx?wsdl");
        try {
            $result = $soap->TCKimlikNoDogrula([
                'TCKimlikNo' => $TCKimlikNo,
                'Ad' => $Ad,
                'Soyad' => $Soyad,
                'DogumYili' => $DogumYili
            ]);
            if ($result->TCKimlikNoDogrulaResult) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
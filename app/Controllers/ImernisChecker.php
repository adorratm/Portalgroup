<?php

namespace App\Controllers;

interface ImernisChecker
{
    public function checkMernisState(string $TCKimlikNo, string $Ad, string $Soyad, string $DogumYili): bool;
}
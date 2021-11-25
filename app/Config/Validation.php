<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use App\Validation\CompanyRules;
use DateTime;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CompanyRules::class,
        MyRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

}

// Custom Validation Rules
class MyRules {
    public function check_date_format(string $date, string &$error = null): bool
    {
        $format = 'Y-m-d';
        $d = DateTime::createFromFormat($format,$date);
        if(($d && $d->format($format) === $date)){
            return TRUE;
        }else{
            $error = "'$date' is not a valid date format. The valid date format is : Y-m-d'";
            return FALSE;

        }
    }
}

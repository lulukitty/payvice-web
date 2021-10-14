<?php

namespace App\Utils;


class RequestRules
{
    private static $rules = [
        'MULTICHOICE_LOOKUP' => [
            'card' => 'required',
            'cable_unit' => 'required',
            'biller' => 'nullable'
        ],
        'STARTIMES_LOOKUP' => [
            'selectedBouquet' => 'required',
            'cycle' => 'required',
            'smartCardCode' => 'required',
            'phone' => 'required',
            'unit' => 'required',
            'pin' => 'required'
        ],
        'MOBILE_DATA' => [
            'service' => 'required',
        ],
        'EKO_ELECTRIC_METER_LOOKUP' => [
            'meter' => 'required',
            'service' => 'required'
        ],
        'IKEJA_ELECTRIC_LOOKUP' => [
            'meter' => 'required',
            'service' => 'required'
        ],
        'IBADAN_ELECTRIC_LOOKUP' => [
            'meter' => 'required',
            'service' => 'required'
        ],
        'ENUGU_ELECTRIC_LOOKUP' => [
            'meter' => 'required',
            'service' => 'required'
        ],
        'PH_ELECTRIC_LOOKUP' => [
            'meter' => 'required',
            'service' => 'required'
        ],
        'ABUJA_ELECTRIC_LOOKUP' => [
            'meter' => 'required',
            'service' => 'required'
        ],
        'KADUNA_ELECTRIC_LOOKUP' => [
            'meter' => 'required',
            'service' => 'required'
        ],
        'KANO_ELECTRIC_LOOKUP' => [
            'meter' => 'required',
            'service' => 'required'
        ],
        'AGENT_ONBOARDING' => [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'profession' => 'required',
            'business_name' => 'required',
            'position' => 'required',
            'outlet' => 'required',
            'office_address' => 'required',
            'cash_in_cash_out' => 'required_with:bvn',
            'bvn' => 'nullable',
            'tp_code' => 'required',
            'bank_account' => 'required',
            'vendorBankCode' => 'required'
        ],

    ];

    public static function getRule($name)
    {
        return self::$rules[$name];
    }

}
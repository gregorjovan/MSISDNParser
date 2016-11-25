<?php
/**
 * Takes MSISDN as an input and returns MNO identifier, country dialling code, subscriber number and country identifier as defined with ISO 3166-1-alpha-2
 *
 * Parser description.
 *
 * @version 1.0
 * @author Gregor Jovan
 * some scripts by https://github.com/dominikznidar/msisdn-parser
 */
require_once 'JSonRPC.php';

class MSISDNStruct
{
    public $MNOIdentifier;
    public $CountryDialingCode;
    public $SubscriberNumber;
    public $CountryIdentifier;
}

class MSISDNParser
{
    function __construct()
    {
        $this->parsedNumber = new MSIsdnStruct();
        $this->dataReader = new DataReader();
    }

    public function getData($msisdn)
    {
        $this->num = $this->validate($msisdn);
        return $num === false ? $msisdn : $this->lookup($msisdn);
    }
    public $parsedNumber;
    protected $dataReader;
    private function lookup($msisdn)
    {
        $countryData = $this->lookupCountry($msisdn);
        if ($countryData !== false) {
            return(json_encode($this->parsedNumber));
        }
        return false;
    }
    private function lookupCountry($countryCode, $subscriberNumber = '')
    {
        $countries = $this->dataReader->get('countries');
        //script by https://github.com/dominikznidar/msisdn-parser
        do {
            if (isset($countries[$countryCode])) {
                $this->parsedNumber->CountryDialingCode = (int)$countryCode;
                $this->parsedNumber->SubscriberNumber = (int)$subscriberNumber;
                $this->parsedNumber->CountryIdentifier = $countries[$countryCode];
                $this->parsedNumber->MNOIdentifier = $this->getMnoIdentifier((int)$subscriberNumber, $countries[$countryCode]);
                return($this->parsedNumber);
            }
            $subscriberNumber = substr($countryCode, -1).$subscriberNumber;
            $countryCode = floor($countryCode/10);
        } while ($countryCode > 0);
        return false;
    }
    protected function getMnoIdentifier($operatorCode, $country)
    {
        //script by https://github.com/dominikznidar/msisdn-parser
        $operatorData = $this->dataReader->get($country);
        if (!$operatorData) {
            return false;
        }
        do {
            if (isset($operatorData[$operatorCode])) {
                return $operatorData[$operatorCode];
            }
            $operatorCode = floor($operatorCode/10);
        } while ($operatorCode > 0);
        return false;
    }
    private  function validate($msisdn)
    {
        $msisdn = trim($msisdn);
        if ($msisdn === '') {
            return false;
        }
        if(!preg_match('/\+\d+/', $msisdn)){
            return false;
        }
        return (float)trim($msisdn, '+');
    }
}

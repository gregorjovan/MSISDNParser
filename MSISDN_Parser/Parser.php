<?php

/**
 * - takes MSISDN as an input and returns MNO identifier, country dialling code, subscriber number and country identifier as defined with ISO 3166-1-alpha-2
 *
 * Parser description.
 *
 * @version 1.0
 * @author Gregor
 */

class Parser
{
    protected $data;
    public $opr;

    public function __construct()
    {
        //$this->cache = new Cache();
        $this->data = new Data;
    }
    /**
     * Parses a msisdn and returns info about it.
     * @param  String $msisdn A msisdn (ex: +38640751751)
     * @return mixed          An array with msisdn's info or false
     */
    public function parse($msisdn)
    {
        $msisdn = $this->validate($msisdn);
        return $msisdn === false ? $msisdn : $this->lookup($msisdn);
    }
    public function getOperator() {
        return $this->opr;
    }
    private function setOperator($_opr) {
        $this->opr = $_opr;
        return $this;
    }

    protected function validate($msisdn)
    {
        $msisdn = trim($msisdn);
        if ($msisdn === '') {
            return false;
        }
        if (!preg_match('/\+\d+/', $msisdn)) {
            return false;
        }
        return (float)trim($msisdn, '+');
    }
    protected function lookup($msisdn)
    {
        $countryData = $this->lookupCountry($msisdn);
        if ($countryData !== false) {
            $data = array(
                'msisdn' => '+' . $msisdn,
                'countryDialingCode' => $countryData['countryCode'],
                'country' => $countryData['country'],
                'subscriberNumber' => $countryData['subscriberNumber']
            );
            $operator = $this->lookupOperator(
                $countryData['subscriberNumber'],
                $countryData['country']
            );
            if ($operator !== false) {
                $data['operator'] = $operator;
            }
            return $data;
        }
        return false;
    }
    protected function lookupCountry($countryCode, $subscriberNumber = '')
    {
        $countries = $this->getCountriesData();
        do {
            if (isset($countries[$countryCode])) {
                return array(
                    'country' => $countries[$countryCode],
                    'countryCode' => (int)$countryCode,
                    'subscriberNumber' => (int)$subscriberNumber
                );
            }
            $subscriberNumber = substr($countryCode, -1).$subscriberNumber;
            $countryCode = floor($countryCode/10);
        } while ($countryCode > 0);
        return false;
    }

    protected function lookupOperator($operatorCode, $country)
    {
        $operatorData = $this->getOperatorData($country);
        if (!$operatorData) {
            return false;
        }
        do {
            if (isset($operatorData[$operatorCode])) {
                $this->setOperator($operatorData[$operatorCode]);
                return $operatorData[$operatorCode];
            }
            $operatorCode = floor($operatorCode/10);
        } while ($operatorCode > 0);

        return false;
    }
    protected function getCountriesData()
    {
        return $this->data->get('countries');
    }
    protected function getOperatorData($country)
    {
        return $this->data->get($country);
    }
}
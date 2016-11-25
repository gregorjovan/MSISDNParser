<?php

/**
 * DataReader takes name of json file as input. Returns json formatted conted of the file.
 *
 *
 *
 * @version 1.0
 * script: https://github.com/dominikznidar/msisdn-parser
 */

class DataReader
{
    public function get($dataSourceName)
    {
        $rawData = $this->readData($dataSourceName);
        return $this->parseData($rawData);
    }
    protected function readData($dataType)
    {
        $path = dirname(__FILE__).'/' . $dataType . '.json';
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        return false;
    }
    protected function parseData($rawData)
    {
        if ($rawData === false) {
            return false;
        }
        return json_decode($rawData, true);
    }
}
<?php

/**
 * CodeReader short summary.
 *
 * CodeReader description.
 *
 * @version 1.0
 * @author Gregor
 */
//namespace Msisdn;
class CodeReader
{

/**
 * Reads data from component's data folder.
 * Contents of those files should contain data in JSON format.
 */

    /**
     * Fetches data from provided file.
     * False is returned if the file is not found.
     * @param  string $dataType Name of the file
     * @return mixed            Contents of the file or false
     */
    public function get($dataType)
    {
        $rawData = $this->readData($dataType);
        $rr= $this->parseData($rawData);

        return $rr;
    }
    protected function readData($dataType)
    {
        $path = dirname(__FILE__).'/' . $dataType . '.json';
        echo $path;
        if (file_exists($path)){
            $dd = file_get_contents($path);
            return $dd;
        }
        return false;
    }
    protected function parseData($rawData)
    {
        if ($rawData === false) {
            return false;
        }
        return(json_decode($rawData, true));        
    }
}


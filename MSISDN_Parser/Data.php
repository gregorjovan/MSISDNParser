<?php

/**
 * Reads data from component's data folder.
 * Contents of those files should contain data in JSON format.
 */
class Data
{
    /**
     * Fetches data from provided file.
     * False is returned if the file is not found.
     * @param  string $dataType Name of the file
     * @return mixed            Contents of the file or false
     */
    public function get($dataSourceName)
    {
        $rawData = $this->readData($dataType);
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
<?php

class Parser
{
    private $data;

    public function createFromCsvFile($path)
    {
        $handle = fopen($path, "r");
        while (($data = fgetcsv($handle)) !== false) {
            $this->data[] = [
                'name'  => trim($data[0]),
                'email' => trim($data[1]),
                'body'  => isset($data[2]) ? trim($data[2]) : null,
            ];
        }
    }

    public function getData()
    {
        return $this->data;
    }
}
<?php
namespace App\Classes\Model;

class ModelCollection 
{
    private Array $dataCollection;
    function __construct($dataCollection)
    {
        $this->dataCollection = $dataCollection;
    }

    public function transform(BaseModel $class)
    {
        $objects = collect([]);
        foreach($this->dataCollection as $key => $data) {
            $objects->push($class::fromJson($data));
        }

        return $objects;
    }
}
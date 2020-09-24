<?php

namespace App\Classes\Model;

use Carbon\Carbon;


class BaseModel
{
    private $properties;
    protected $data;

    public static function fromJson($dataJson)
    {
        $object = new TaskModel;
        foreach ($dataJson as $key => $value) {
            $object->{$key} = $value;
        }
        return $object;
    }


    public function __get($propertyName)
    {
        if (array_key_exists($propertyName, $this->properties)) {
            return $this->properties[$propertyName];
        }
    }
    public function __set($propertyName, $propertyValue)
    {

        $this->properties[$propertyName] = $propertyValue;
    }

    public function toJson() 
    {
        $array = [];
        foreach($this->properties as $key => $value)
        {   
            $array[$key] = $value;
        }
        return json_encode($array);
    }
}

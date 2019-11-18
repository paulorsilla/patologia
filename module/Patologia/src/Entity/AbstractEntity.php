<?php
/**
 * Entity class
 * @package    Core\Model
 * @author     Elton Minetto<eminetto@coderockr.com>
 */
namespace Patologia\Entity;

abstract class AbstractEntity 
{
    
    /**
     * Set and validate field values
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function __set($key, $value) 
    {
        $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        if (method_exists($this, $setter )) {
            $this->$setter($value);	   
        } else {
            $this->$key = $value;
        }
    }

    /**
     * @param string $key
     * @return mixed 
     */
    public function __get($key) 
    {
        return $this->$key;
    }

    /**
     * Set all entity data based in an array with data
     *
     * @param array $data
     * @return void
     */
    public function setData($data)
    {
        foreach($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    /**
     * Return all entity data in array format
     *
     * @return array
     */
    public function getData()
    {
        $data = get_object_vars($this);
        foreach($data as $k => $v) {
            error_log($k." => ".$v);
        }
        return array_filter($data);
    }

    /**
     * Used by TableGateway
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getData();
    }
}
<?php
namespace App\Models;

use App\Services\DB;

abstract class Model
{
    public $id;
    public $attributes = [];

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attributes[$name];
    }
    
    public static function findAll()
    {
        $db = DB::getInstance();
        $sql = 'SELECT * FROM `' . static::getTable() . '`';
        return $db->query($sql, null, static::class);
    }
    
    public static function getById(int $id)
    {
        $db = DB::getInstance();
        $sql = 'SELECT * from `' . static::getTable() . '` WHERE id = ' . (int)$id;
        $result = $db->query($sql, null, static::class);
        if ($result) {
            return $result[0];
        }
        else {
            return null;
        }
    }
    
    public static function getByColumn($column, $value)
    {
        $db = DB::getInstance();

        $sql = 'SELECT *
            FROM `'.static::getTable().'`
            WHERE `'.$column.'` = :value
            LIMIT 1';
        
        $values = [':value' => $value];

        $result = $db->query($sql, $values, static::class);
        if ($result) {
            return $result[0];
        }
    }
    
    public static function useAttributes(array $objects): array
    {
        /* Создание стандартных объектов из объектов модели. Свойство attributes
        переводится в свойства объекта. Используется для отправки по API */

        $responseObjects = [];

        foreach ($objects as $object) {
            $newObject = (object)$object->attributes;

            if (isset($object->id)) {
                $newObject->id = $object->id;
            }

            $responseObjects[] = $newObject;
        }

        return $responseObjects;
    }
    abstract protected static function getTable(): string;
    
    public function save()
    {
        $mappedProperties = $this->mapProperties();

        if ($this->id) {
            return $this->update($mappedProperties);
        } else {
            return $this->insert($mappedProperties);
        }
    }
    
    public static function update($request)
    {
        $id = $request->id;
        unset($request->id);

        $columns = [];
        $values = [];

        foreach ($request as $key => $value) {
            $columns[] = '`' . $key . '` = :' . $key;
            $values[':' . $key] = $value;
        }
        
        $sql = 'UPDATE `' . static::getTable() .
            '` SET ' . implode(', ', $columns) .
            ' WHERE id=' . $id;
        
        $db = DB::getInstance();
        $result = $db->query($sql, $values, static::class);
        return $result;
    }
    
    public static function create($request)
    {
        $sqlNames = [];
        $sqlValues = [];
        $values = [];

        foreach($request as $key => $value) {
            $sqlNames [] = '`' . $key . '`';
            $sqlValues [] = ':' . $key;
            $values[':' . $key] = $value;
        }
        
        $sql = 'INSERT INTO `' . static::getTable() . '` 
            ('. implode(', ', $sqlNames).')
            VALUES ('. implode(', ', $sqlValues).')';

        $db = DB::getInstance();
        $result = $db->query($sql, $values, static::class);
        if ($result) {
            return $db->getLastInsertId();
        }
    }

    private function insert(array $properties)
    {
        $filtered_properties = array_filter($properties);
        
        $columns = [];
        $parametrs = [];
        $values = [];

        foreach ($filtered_properties as $column => $value) {
            $columns[] = $column;
            $parametr = ':'.$column;
            $parametrs[] = $parametr;
            $values[$parametr] = $value;
        }
        
        $sql = 'INSERT INTO `' . static::getTable() . '` 
            ('. implode(', ', $columns).')
            VALUES ('. implode(', ', $parametrs).')';
        
        $db = DB::getInstance();
        $result = $db->query($sql, $values, static::class);
        if ($result) {
            $this->id = $db->getLastInsertId();
        }
        return $result;
    }
    
    public static function delete(int $id)
    {
        $db = DB::getInstance();
        $sql = 'DELETE FROM `'.static::getTable().'` WHERE id = :id';
        $values = [':id' => $id];
        $db->query($sql, $values);
    }

    private function mapProperties(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $property_name = $property->getName();
            $mappedProperties[$property_name] = $this->$property_name;
        }
        
        return $mappedProperties;
    }
}

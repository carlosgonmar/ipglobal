<?php

namespace App\Entity;

use App\Repository\Repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

interface EntityInterface
{
    public function __construct(array $values = []);
}

class Entity implements EntityInterface
{

    /**
     * @desc The attributes that aren't visible in the model
     *
     * @var array
     */
    protected array $hidden = [];

    /**
     * @desc The attributes that aren't visible in the model
     *
     * @var array
     */
    protected array $fillable = [];

    /**
     * @desc The relationships that should be loaded by default
     *
     * @var array
     */
    protected array $with = [];

    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value){

            if(
                in_array($key, $this->fillable)
                || $key == 'id'
            ){
                $this->{$key} = $value;
            }
        }
    }

    /*
     * @desc Returns an array representation of the entity
     *
     * @return array
     */
    public function toArray(): array
    {

        $response = array_merge(
            $this->availableFields(),
            $this->availableRelationship()
        );
        return $response;

    }


    /*
     * @desc Returns an array representation of the entity
     *
     * @return array
     */
    private function availableFields(): array
    {

        $response = [];
        foreach (get_class_methods(get_called_class()) as $method){

            if(preg_match('/^get/', $method)){
                $field = lcfirst(substr($method, 3));
                if(in_array($field, $this->hidden)){
                    continue;
                }
                $response[$field] = $this->$method();
            }

        }
        return $response;

    }


    /*
     * @desc Returns an array representation of the entity
     *
     * @return array
     */
    public function availableRelationship(): array
    {

        $response = [];
        foreach ($this->with as $relationship){

            if(method_exists($this, $relationship)){
                $value = $this->$relationship();
                $response[$relationship] = $value?$value->toArray():null;
            }

        }
        return $response;

    }

    /*
     * @desc Makes the given field hidden
     *
     * @return self
     */
    public function makeHidden(string $field): self
    {

        $this->hidden[] = $field;
        return $this;

    }

    /*
     * @desc Makes the given field visible
     *
     * @return self
     */
    public function makeVisible(string $field): self
    {

        if(in_array($field, $this->hidden)){
            $key = array_search($field, $this->hidden);
            unset($this->hidden[$key]);
        }
        return $this;

    }

    /*
     * @desc Add the given relationship to the with array
     * @param string $relationship The name of the relationship method
     *
     * @return self
     */
    public function with(string $relationship): self
    {

        if(!in_array($relationship, $this->with) && method_exists(get_called_class(), $relationship)){
            $this->with[] = $relationship;
        }
        return $this;

    }

    /*
     * @desc Remove the given relationship to the with array
     * @param string $relationship The name of the relationship method
     *
     * @return self
     */
    public function without(string $relationship): self
    {

        if(in_array($relationship, $this->with)){
            unset($this->with[$relationship]);
        }
        return $this;

    }

    /*
     * @desc Generate a new entity from the given values
     * @param array $data The data to create the entity from
     *
     * @return self
     */
    public static function generate(array $values): self
    {

        $entity = new static();
        foreach ($values as $key => $value){
            dd(isset($entity->{$key}));
            if(
                isset($entity->{$key})
                && in_array($key, $entity->fillable)
            ){
                $entity->{$key} = $value;
            }
        }
        return $entity;

    }

    /*
     * @desc Generate a new entity from the given values
     * @param array $data The data to create the entity from
     *
     * @return self
     */
//    public static function all(): self
//    {
//
//        $entity = new static();
//        foreach ($values as $key => $value){
//            if(isset($entity->fillable[$key])){
//                $method = "set" . ucfirst($key);
//                if(method_exists($entity, $method)){
//                    $entity->$method($value);
//                }
//            }
//        }
//        return $entity;
//
//    }

}

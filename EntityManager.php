<?php
namespace Moniq;
use Config\MainConfig;
class EntityManager {
    private $query;
    private $db;
    private $limit;
    private $entity;
    private $queryType;
    public function __construct($entity) {
        $db=new MainConfig();
        $db->Connection();
        $this->setDb($db);
        $entityName=get_class($entity);
        $this->entity=$entityName;

        
    }
    private function getQuery() {
        return $this->query;
    }

    public function setQuery($query) {
        $this->query = $query;
    }
    private function getDb() {
        return $this->db;
    }

    private function setDb($db) {
        $this->db = $db;
    }
    public function getLimit() {
        return $this->limit;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
    }
    private function setQueryType($queryType){
        $this->queryType=$queryType;
    }
    private function getQueryType(){
       return $this->queryType;
    }
    private function findQueryType(){
        if(strstr($this->getQuery(),'select')){
            $this->setQueryType('select');
        }
        elseif(strstr($this->getQuery(),'update')){
            $this->setQueryType('update');
        }
        elseif(strstr($this->getQuery(),'insert')){
            $this->setQueryType('insert');
        }
        elseif(strstr($this->getQuery(),'delete')){
            $this->setQueryType('delete');
        }
        else{
            $this->setQueryType(null);
        }
    }
    private function prepareQuery(){
        $this->findQueryType();
        if($this->getLimit()){
            $query=$this->getQuery().' limit '.$this->getLimit();
        }
        else{
            $query=$this->getQuery();
        }
    }
    public function execute(){
        $this->setDb($this->getDb()->getConnection());
        $this->prepareQuery();
        $query=$this->getDb()->prepare($this->getQuery());
        $query->execute();
        $this->setQuery($query);
        
    }
    public function getResults(){
        if($this->getQueryType()==='select'){
            if($this->getLimit()===1){
            $results=$this->getQuery()->fetch();
            $results=$this->setValues($results);
        }
        else {
            $results=$this->getQuery()->fetchAll();
            $results=$this->setAllValues($results);
            
        }
        return $results;
        }
        elseif($this->getQueryType()==='update'){}
        elseif($this->getQueryType()==='insert'){
            return $this->getDb()->lastInsertId();       
        }
        elseif($this->getQueryType()==='delete'){
            return 'deleted';
        }
        else{
            return null;
        }
        }
    private function getSetterName($input, $separator='_'){
        $string = str_replace($separator, '', ucwords($input, $separator));
        $string= 'set'.$string;
        return $string;
        
    }
    public function setAllValues($results){
        $array=array();
        foreach($results as $result){
            
            $array[]=$this->setValues($result);
        }
        return $array;
    }
    private function setValues($values){
        $object = new $this->entity();
        if($values){
        foreach($values as $key => $value){
              if(is_string($key)){
                  $setter=$this->getSetterName($key);
                  $object->$setter($value);    
              }
        }
        }
        return $object;
    }
    public function getResult($values) {
        if($this->getLimit()===1){
            $results=$this->setValues($values);
        }
        else{
            $this->setValues(values);
        }
    }



}

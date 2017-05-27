<?php
namespace Moniq;
use Moniq\Router;
use Moniq\Request;
class Core {

    private $path;
    private $request;
    public function __construct() {
        $this->request=new Request();
        $this->executeRequest();
    }
    public function getRequest(){
        return $this->request;
    } 
    private function getClassName() {
        return rtrim($this->getPath(), '/') . 'Controller';
    }
    private function getClearPath(){
        return rtrim($this->getPath(), '/');
    }

    private function executeRequest() {
        new Router($this);
    }

    private function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }
    private function getPage(){
        return 'test';
    }
}

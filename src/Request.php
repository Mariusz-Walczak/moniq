<?php
namespace Moniq;
class Request {
    private $path;
    private $slug;
    private $method;
    private $requestBody;
    public function __construct() {
    $request=$_SERVER;
    if(isset($request['REDIRECT_URL'])){
    $this->setPath($request['REDIRECT_URL']);
    }
    $this->setMethod($request['REQUEST_METHOD']);
    $this->setRequestBody($_REQUEST);
    }
    
    public function getPath() {
        return $this->path;
    }
    public function getClearPath(){
        $path= str_replace('/', '', $this->path);
        return $path;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getRequestBody() {
        return $this->requestBody;
    }

    private function setPath($path) {
        $this->path = $path;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    private function setMethod($method) {
        $this->method = $method;
    }

    public function setRequestBody($requestBody) {
        $this->requestBody = $requestBody;
    }


}

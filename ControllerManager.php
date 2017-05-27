<?php
namespace Moniq;

use Config\MainConfig;


class ControllerManager {

    private $response;
    private $entityManager;
    private $request;
    private $router;

    public function __construct($request, $router) {
        
        $this->setRequest($request);
        $this->setRouter($router);
        $this->getResponseByMethod();
    }

    private function getResponseByMethod() {
        $method = $this->getRequest()->getMethod();
        if ($method === 'GET') {
            $response = $this->getRouter()->getController()->get($this->getRequest());
        } elseif ($method === 'POST') {
            $response = $this->getRouter()->getController()->add($this->getRequest());
        } elseif ($method === 'PUT') {
            $response = $this->getRouter()->getController()->edit($this->getRequest());
        } elseif ($method === 'DELETE') {
            $response = $this->getRouter()->getController()->delete($this->getRequest());
        }
        $this->setResponse($response);
    }

    public function getResponse() {
        return $this->response;
    }

    private function setResponse($response) {
        $this->response = $response;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    private function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    function getConfig() {
        return new MainConfig();
    }

    function getRequest() {
        return $this->request;
    }

    function setRequest($request) {
        $this->request = $request;
    }

    public function getRouter() {
        return $this->router;
    }

    public function setRouter($router) {
        $this->router = $router;
    }

}

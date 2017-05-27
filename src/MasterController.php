<?php

namespace Moniq;

use Moniq\TemplateService;
use Moniq\ServiceManager;

class MasterController {

    private $template;
    private $module;
    private $controller;

    function __construct() {
        $moduleName = $this->getModuleName(get_called_class());
        $controllerName = $this->getControllerName(get_called_class());
        $template = new TemplateService();
        $this->setTemplate($template);
        $this->setModule($moduleName);
        $this->setController($controllerName);
        $this->getServies();
    }

    function getModule() {
        return $this->module;
    }

    function getControllerName($callClassNamespace) {
        $namespaceArray = explode('\\', $callClassNamespace);
        return $namespaceArray[3];
    }

    function getModuleName($callClassNamespace) {
        $namespaceArray = explode('\\', $callClassNamespace);
        return $namespaceArray[1];
    }

    function setModule($module) {
        $this->module = $module;
    }

    function getTemplate() {
        return $this->template;
    }

    function setTemplate($template) {
        $this->template = $template;
    }

    function getHtml($template, $variables = array(), $twigFilesSource = array()) {
        $this->template->addTwigFilesSource($twigFilesSource);
        $this->template->getHtml($template, $variables, $this->getModule());
    }

    function getJson($data) {
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json; charset=utf-8');
        $json = json_encode($data);
        echo $json;
        die;
    }

    function getServies() {
        $servicesManager = new ServiceManager($this->getModule(), $this->getController());
        $services = $servicesManager->getServices();
        if (!is_null($services)) {
            foreach ($services as $service) {
                $serviceToAdd = '\\Services\\' . $service;
                $this->$service = new $serviceToAdd();
            }
        }
    }

    function getController() {
        return $this->controller;
    }

    function setController($controller) {
        $this->controller = $controller;
    }
    function getResponse($object,$data): array {
        include "src/Entities/Client/generated-conf/config.php";
        $data = $data->getRequestBody();
        $object = $this->getCredentials($object,$data);
        if (is_string($object)) {
            $response = array('error' => $object);
        } else {
            $response = $object->find()->toArray();
        }
        return $response;
    }

    private function getCredentials($object,$data) {

        if (isset($data['limit'])) {
            $limit = $data['limit'];
            if (ctype_digit($limit) && $limit > 0) {
                $object->limit($limit);
            } else {
                return 'nie poprawna wartość limit';
            }
        }
        if (isset($data['orderBy'])) {
            $orderBy = $data['orderBy'];
            if (TableMap::getTableMap()->hasColumn($orderBy)) {
                $object->orderBy($orderBy);
            } else {
                return 'niepoprawna nazwa tabeli';
            }
        }
        return $object;
    }

}

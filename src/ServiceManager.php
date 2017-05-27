<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Moniq;

/**
 * Description of ServiceManager
 *
 * @author hp
 */

class ServiceManager {

    private $services;

    public function __construct($moduleName, $controllerName) {
        $servicesConfig = 'Modules\\'.$moduleName . '\\Config\\ServiceConfig';
        $servicesConfig = new $servicesConfig();
        $services = $servicesConfig->getServices();
        if (isset($services[$moduleName][$controllerName])) {
            $this->services = $services[$moduleName][$controllerName];
        } else {
            $this->services = null;
        }
    }

    public function getServices() {
        return $this->services;
    }

}

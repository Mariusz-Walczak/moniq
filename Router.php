<?php

namespace Moniq;

use Moniq\ControllerManager;
use Config\Modules;

class Router {

    private $routes;
    private $path;
    private $controller;
    private $module;

    public function __construct($parameters) {
        $this->setRoutes();
        $this->setPath($parameters->getRequest()->getPath());
        $this->resolvePath();
        $this->setupController();
        $parameters->getRequest()->setSlug($this->getRequestWithSlug());

        new ControllerManager($parameters->getRequest(), $this);
    }

    private function setupRouter() {
        $routes = $this->getRoutes();
        if ($routes != null) {
            foreach ($routes as $route) {

                foreach ($route['routes'] as $specificRoute) {
                    if ($specificRoute['path'] == $this->getFirstUrlPartial()) {

                        $this->setModule($route['module']);
                        $this->setController($specificRoute['controller']);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function getFirstUrlPartial() {
        $partials = explode('/', $this->getPath());
        if (count($partials) > 1) {
            $result = $partials[1];
        } else {
            $result = null;
        }
        return $result;
    }

    private function resolvePath() {
        if ($this->setupRouter()) {
            return $this->getFirstUrlPartial();
        }
        echo 404;
        die;
    }

    private function setupController() {
        $controller = $this->getController();
        $controller = 'Modules\\'.$this->getModule() . '\\Controllers\\' . $controller;
        $controller = new $controller();
        $this->setController($controller);
    }

    private function getRequestWithSlug() {
        $slug = $this->getFirstUrlPartial();
        $slug = str_replace('/' . $slug . '/', '', $this->getPath());
        if ($slug === $this->getPath()) {
            $slug = null;
        }
        return $slug;
    }

    function setPath($path) {
        $this->path = $path;
    }

    private function getRoutesPerModule($module) {
        $router = 'Modules\\'.$module . '\\Config\Router';
        $router = new $router();
        return $router->getRouterConfig();
    }

    private function setRoutes() {
        $routeArray = array();
        foreach ($this->getModules() as $module) {
            $moduleRouterArray = $this->getRoutesPerModule($module);
            $routeArray[] = $moduleRouterArray;
        }
        $this->routes = $routeArray;
    }

    private function getRoutes() {
        return $this->routes;
    }

    private function getPath() {
        return $this->path;
    }

    public function getController() {
        return $this->controller;
    }

    private function setController($controller) {
        $this->controller = $controller;
    }

    function getModule() {
        return $this->module;
    }

    function setModule($module) {
        $this->module = $module;
    }

    function getModules() {
        
        $modules = new Modules();
        return $modules->getModules();
    }

}

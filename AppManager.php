<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Moniq;

/**
 * Description of AppManager
 *
 * @author hp
 */
class AppManager {
    private $appArray=array();
    
    public function __construct() {
        $this->addAppArray($_SERVER,'server');
        $this->addAppArray($_SESSION,'session');
        $this->addAppArray($_COOKIE,'cookie');
    }
    public function getAppArray() {
        return $this->appArray;
    }

    function addAppArray($appArray,$name) {
        $this->appArray[$name] = $appArray;
    }
    

}

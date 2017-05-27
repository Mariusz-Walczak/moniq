<?php

namespace Moniq;

class TemplateService {

    private $twigFilesSource = array();

    public function __construct() {
        require_once 'vendor/Twig/Autoloader.php';
        \Twig_Autoloader::register();
    }

    public function getHtml($template, $variables = array(), $module) {
        $this->addTwigFilesSource('src/Modules/' . $module . '/Views');
        $loader = new \Twig_Loader_Filesystem($this->twigFilesSource);
        $twig = new \Twig_Environment($loader, array(
            'debug' => true));
        $twig->addExtension(new \Twig_Extension_Debug());
        echo $twig->render($template, $variables);
    }

    public function addTwigFilesSource($twigSource) {
        
        if (is_array($twigSource)) {
            $this->twigFilesSource= array_merge($twigSource,$this->twigFilesSource);
        } else {
            $this->twigFilesSource[] = $twigSource;
        }
    }

}

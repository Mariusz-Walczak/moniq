<?php
namespace Moniq;
class PageGenerator {

    private $head;
    private $body;
    private $globalJavascripts = array();
    private $globalCss = array();

    public function __construct($parameters) {
        $this->setBody($parameters['body']);
        $this->setGlobalJavascripts($parameters['globalJavascripts']);
        $this->setGlobalCss($parameters['globalCss']);
        $this->setHead($parameters['head']);
        $this->getHtml();
    }

    private function getHead() {
        return $this->head;
    }

    private function getGlobalJavascripts() {
        return $this->globalJavascripts;
    }

    private function getGlobalCss() {
        return $this->globalCss;
    }

    private function setGlobalJavascripts($globalJavascripts) {
        $globalJavascripts = '';
        foreach ($globalJavascripts as $globalJavascript) {
            $globalJavascripts.='lib/js/' . $globalJavascript . 'js';
        }
        $this->globalJavascripts = $globalJavascripts;
    }

    private function setGlobalCss($globalCsss) {
        $globalCss = '';
        foreach ($globalCsss as $css) {
            $globalCss.='lib/css/' . css . 'css';
        }
        $this->globalCss = $globalCss;
    }

    private function getBody() {
        return $this->body;
    }

    private function setHead($head) {
        $this->head = $this->globalJavascripts . $this->globalCss . $head;
    }

    private function setBody($body) {
        $this->body = $body;
    }

    private function getHtml() {
        $html = '<html>';
        $html.='<head>' . $this->getHead() . '</head>';
        $html.='<body>' . $this->getBody() . '/<body>';
        echo $html;
    }

}

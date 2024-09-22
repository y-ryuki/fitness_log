<?php


class View
{
    protected $baseDir;
    public function __construct($baseDir){
        $this->baseDir = $baseDir;
    }
    public function render($path,$variables,$layout = false)
    {
        
        extract($variables);

        ob_start();
        require $this->baseDir . '/' . $path . '.php';
        //'views/login/index.php
        //requireの内容を変数にする
        $content = ob_get_clean();

        ob_start();
        require $this->baseDir . '/' . $layout . '.php';
        $layout = ob_get_clean();
        return $layout;

    }

}
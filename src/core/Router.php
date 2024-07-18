<?php

//アクセスしたパスの対応関係を担う
class Router
{
    private $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }
    public function resolve($pathInfo)
    {
        //パスの一致を判定
        foreach($this->routes as $path => $pattern){
            if($path === $pathInfo){
                return $pattern;
            }
        }

        return false;
    }

}
<?php

class Controller
{
    public function run($action)
    {
        
        if(!method_exists($this,$action)){
            throw new HTTPNotFoundException();
        }
        $this->$action();

    }
}
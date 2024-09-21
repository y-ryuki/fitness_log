<?php


// use fitness_log\Response;
//アプリケーション全体の管理
class Application
{

    private $router;
    protected $response;
    public function __construct()
    {
        $this->router = new Router($this->registerRoutes());
        $this->response = new Response();
    }

    public function run()
    {
        
        try{

            //名前解決
            $params = $this->router->resolve($this->getPathInfo());
            if (!$params){
                throw new HTTPNotFoundException();
            }
            // var_export($params);
            $controller = $params['controller'];//制御するクラス名
            $action = $params['action'];//コントローラーの中のメソッド名
            $this->runAction($controller,$action);
        }catch(HTTPNotFoundException){
            $this->render404Page();
        }

        $this->response->send();
            
    }

    private function runAction($controllerName,$action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';//クラスの名前を作成する
        if(!class_exists($controllerClass)){
            throw new HTTPNotFoundException();
        }
        
        $controller = new $controllerClass();
        $content = $controller->run($action);
        $this->response->setContent($content);
    }

    private function registerRoutes()
    {
        //ルーティングの登録
        return [
            '/' => ['controller' => 'login','action' => 'index'],
            '/login' => ['controller' => 'login','action' => 'login'],
            '/logout' => ['controller' => 'login','action' => 'logout'],
            '/edit' => ['controller' => 'login','action' => 'edit'],
            '/update' => ['controller' => 'login','action' => 'update'],
            '/delete' => ['controller' => 'login','action' => 'delete'],
            '/mypage' => ['controller' => 'login','action' => 'mypage'],
            '/signup' => ['controller' => 'signup','action' => 'index'],
            '/signup/register' => ['controller' => 'signup','action' => 'register'],
            '/record' => ['controller' => 'record','action' => 'index'],
            '/record/create' => ['controller' => 'record','action' => 'create'],
            '/record/register' => ['controller' => 'record','action' => 'register'],
            '/record/edit' => ['controller' => 'record','action' => 'edit'],
            '/record/update' => ['controller' => 'record','action' => 'update'],
            '/record/delete' => ['controller' => 'record','action' => 'delete'],
        ];
    }

private function getPathInfo()
{
    //パスを取ってくる
    return $_SERVER['REQUEST_URI'];
}

private function render404Page()
{
    $this->response->setStatusCode(404,'Not Found');
    $this->response->setContent(
    <<<EOF
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.css">
        <title>404</title>
    </head>
    <body>
    
        <h1>
            404 Page Not Found
        </h1>
        
    
    </body>
    </html>
    EOF
    );

}

}


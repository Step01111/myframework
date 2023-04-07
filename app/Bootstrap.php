<?php
namespace App;

class Bootstrap
{
    private $route;
    private $controllerName = '';
    private $actionName;
    private $parametrs;

    public function __construct()
    {
        $siteRoutes = require('routes.php');

        //ЧПУ для статей
        $artRoutes = [
            ['/^([\w\-]+)$/', \App\Controllers\ArtController::class, 'show'],
        ];

        $useArtRoutes = false; // Использовать ЧПУ
    
        $this->route = $_GET['route'] ?? '';

        $this->getControllerName($siteRoutes);
        if (!$this->controllerName && $useArtRoutes) {
            $this->getControllerName($artRoutes);
        }
        
        try {
            if (!$this->controllerName) {
                throw new \App\Exceptions\NotFoundException();
            }
            
            $controllerName = $this->controllerName;
            $actionName = $this->actionName;
            $parametrs = $this->parametrs;

            $controller = new $controllerName();
            $controller->$actionName(...$parametrs);
        } catch (\App\Exceptions\NotFoundException $e) {
            $view = new \App\View\View();
            $view->renderHTML('errors/404.php');
        }
    }

    private function getControllerName($routes)
    {
        foreach ($routes as $value) {
            preg_match($value[0], $this->route, $matches);
            if ($matches) {
                $this->controllerName = $value[1];
                $this->actionName = $value[2];
                
                unset($matches[0]);
                $this->parametrs = $matches;
                return;
            }
        }
    }
}

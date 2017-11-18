<?php

namespace Core;

/**
 * This is Description of App class
 *
 */
class App
{

    protected $controller = 'Controllers\HomeController';

    protected $method = 'indexAction';

    protected $params = [];

    /**
     * Description:
     *
     */
    public function __construct()
    {
        // Parse URI and split it into: controller name, action name, array of params value
        $uri = Helpers::parseURI();

        // Check if exists file with passed controller name
        $controllerName = isset($uri[0]) ? ucwords($uri[0]) . 'Controller' : '';
        if (isset($uri[0]) && !empty($uri[0]) && file_exists('./app/Controllers/' . $controllerName . '.php')) {
            $this->controller = 'Controllers\\' . $controllerName;
            unset($uri[0]);
        }

        // Instantiate Controller object
        $this->controller = new $this->controller;

        // Check if controller class has passed action method
        if (isset($uri[1])) {
            $actionName = $uri[1] . 'Action';
            if (method_exists($this->controller, $actionName)) {
                $this->method = $actionName;
                unset($uri[1]);
            }
        }

        // Other URI params
        if ($uri) {
            $this->params = array_values($uri);
        }

        // Execute controller action method and pass params in this controller action method.
        call_user_func_array([$this->controller, $this->method], $this->params);

        // Logout Admin if not on UsersTable page (To Protect Users Table Page by password)
        if (!Helpers::isCurrentURI('users/table')
            && !Helpers::isCurrentURI('users/delete')
        ) {
            Helpers::adminLogout();
        }
   }

}
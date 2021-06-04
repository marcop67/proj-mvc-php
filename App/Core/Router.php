<?php

class Router
{
    private $url_controller = null;
    private $url_action = null;
    private $myRoutes = [
    'nodes' => 'NodeController'
    ];

    public function __construct()
    {
        // create array with URL parts in $url
        $this->splitUrl();
        $controllerName = $this->myRoutes[$this->url_controller];

        if (isset($controllerName))
        {
            require './App/Controllers/' . $controllerName . '.php';
            $this->url_controller = new $controllerName();

            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $this->url_action))
            {
                // if no parameters given, just call the method without parameters, like $this->home->method();
                $this->url_controller->{$this->url_action}();
            }
        }
    }

    private function splitUrl()
    {
        $url = $_SERVER['REQUEST_URI'];

        if (isset($url))
        {
            // split URL
            $url = ltrim($url, '/');
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->url_controller = ($url[0] ?? null);

            $this->url_action = explode('?',$url[1]);
            $this->url_action = ($this->url_action[0] ?? null);

        }
    }
}

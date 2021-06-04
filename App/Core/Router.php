<?php

class Router
{
    /** @var null The controller */
    private $url_controller = null;

    /** @var null The method (of the above controller), often also named "action" */
    private $url_action = null;

    private $myRoutes = [
    'nodes' => 'NodeController'
    ];

    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct()
    {

        // create array with URL parts in $url
        $this->splitUrl();

        $controllerName = $this->myRoutes[$this->url_controller];

        if (isset($controllerName)) {

            require './App/Controllers/' . $controllerName . '.php';
            $this->url_controller = new $controllerName();

            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $this->url_action)) {
                // if no parameters given, just call the method without parameters, like $this->home->method();
                $this->url_controller->{$this->url_action}();
            }
        }

    }

    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        $url = $_SERVER['REQUEST_URI'];

        if (isset($url)) {
            // split URL
            $url = ltrim($url, '/');
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            // Put URL parts into according Properties
            // By the way, the syntax here is just a short form of if/else, called "Ternary Operators"
            // @see http://davidwalsh.name/php-shorthand-if-else-ternary-operators
            $this->url_controller = ($url[0] ?? null);

            $this->url_action = explode('?',$url[1]);
            $this->url_action = ($this->url_action[0] ?? null);

        }
    }
}

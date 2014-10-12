<?php

class Application
{
    /** @var null The controller */
    private $url_controller = null;

    /** @var null The method (of the above controller), often also named "action" */
    private $url_action = null;

    /** @var null Parameter one */
    private $url_parameter_1 = null;

    /** @var null Parameter two */
    private $url_parameter_2 = null;

    /** @var null Parameter three */
    private $url_parameter_3 = null;

    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct()
    {
        // if mod_rewrite is activated (define this in application/config/config.php), then the URL looks different
        // than without, so we decide which way to go here. These methods will split the URL to its parts, putting
        // the results into $url_controller, $url_action, $url_parameter_1 etc.
        if (MOD_REWRITE) {
            $this->getUrlWithModRewrite();
        } else {
            $this->getUrlWithoutModRewrite();
        }

        // check for controller: does such a controller exist ?
        if (file_exists('./application/controller/' . $this->url_controller . '.php')) {

            // if so, then load this file and create this controller
            // example: if controller would be "car", then this line would translate into: $this->car = new car();
            require './application/controller/' . $this->url_controller . '.php';
            $this->url_controller = new $this->url_controller();

            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $this->url_action)) {

                // call the method and pass the arguments to it
                if (isset($this->url_parameter_3)) {
                    // will translate to something like $this->home->method($param_1, $param_2, $param_3);
                    $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
                } elseif (isset($this->url_parameter_2)) {
                    // will translate to something like $this->home->method($param_1, $param_2);
                    $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
                } elseif (isset($this->url_parameter_1)) {
                    // will translate to something like $this->home->method($param_1);
                    $this->url_controller->{$this->url_action}($this->url_parameter_1);
                } else {
                    // if no parameters given, just call the method without parameters, like $this->home->method();
                    $this->url_controller->{$this->url_action}();
                }
            } else {
                // default/fallback: call the index() method of a selected controller
                $this->url_controller->index();
            }

        } else if (!$this->url_controller) {
            // we don't have a controller, so the user is on the homepage
            require './application/controller/home.php';
            $page = new Home();
            $page->index();
        } else {
            // invalid URL, so simply show error/index
            require './application/controller/error.php';
            $page = new Error();
            $page->index();
        }
    }

    /**
     * Get and split the URL when mod_rewrite is NOT activated
     */
    private function getUrlWithoutModRewrite()
    {
        // get URL ($_SERVER['REQUEST_URI'] gets everything after domain and domain ending), something like
        // array(6) { [0]=> string(0) "" [1]=> string(9) "index.php" [2]=> string(10) "controller" [3]=> string(6) "action" [4]=> string(6) "param1" [5]=> string(6) "param2" }
        // split on "/"
        $url = explode('/', $_SERVER['REQUEST_URI']);

        // also remove everything that's empty or "index.php", so the result is a cleaned array of URL parts, like
        // array(4) { [2]=> string(10) "controller" [3]=> string(6) "action" [4]=> string(6) "param1" [5]=> string(6) "param2" }
        $url = array_diff($url, array('', 'index.php'));

        // to keep things clean we reset the array keys, so we get something like
        // array(4) { [0]=> string(10) "controller" [1]=> string(6) "action" [2]=> string(6) "param1" [3]=> string(6) "param2" }
        $url = array_values($url);

        // if first element of our URL is the sub-folder (defined in config/config.php), then remove it from URL
        if (defined('URL_SUBFOLDER') && $url[0] == URL_SUBFOLDER) {
            // remove first element (that's obviously the sub-folder)
            unset($url[0]);
            // reset keys again
            $url = array_values($url);
        }

        // Put URL parts into according properties
        // By the way, the syntax here is just a short form of if/else, called "Ternary Operators"
        // @see http://davidwalsh.name/php-shorthand-if-else-ternary-operators
        $this->url_controller = (isset($url[0]) ? $url[0] : null);
        $this->url_action = (isset($url[1]) ? $url[1] : null);
        $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
        $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
        $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null);

        // for debugging. uncomment this if you have problems with the URL
         echo 'Controller: ' . $this->url_controller . '<br />';
         echo 'Action: ' . $this->url_action . '<br />';
         echo 'Parameter 1: ' . $this->url_parameter_1 . '<br />';
         echo 'Parameter 2: ' . $this->url_parameter_2 . '<br />';
         echo 'Parameter 3: ' . $this->url_parameter_3 . '<br />';
    }

    /**
     * Get and split the URL when mod_rewrite is activated
     */
    private function getUrlWithModRewrite()
    {
        if (isset($_GET['url'])) {

            // split URL
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Put URL parts into according properties
            // By the way, the syntax here is just a short form of if/else, called "Ternary Operators"
            // @see http://davidwalsh.name/php-shorthand-if-else-ternary-operators
            $this->url_controller = (isset($url[0]) ? $url[0] : null);
            $this->url_action = (isset($url[1]) ? $url[1] : null);
            $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
            $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
            $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null);

            // for debugging. uncomment this if you have problems with the URL
            // echo 'Controller: ' . $this->url_controller . '<br />';
            // echo 'Action: ' . $this->url_action . '<br />';
            // echo 'Parameter 1: ' . $this->url_parameter_1 . '<br />';
            // echo 'Parameter 2: ' . $this->url_parameter_2 . '<br />';
            // echo 'Parameter 3: ' . $this->url_parameter_3 . '<br />';
        }
    }
}

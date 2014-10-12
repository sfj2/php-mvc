<?php

class Error extends Controller
{
    /**
     * PAGE: error
     * This method handles what happens when you move to http://yourproject/error (or error/index)
     * This page is also shown automatically when a URL route does not exist, like when you do
     * http://www.yourproject.com/xxxxx/xxxxxx/xxx
     */
    public function index()
    {
        // simple message to show where you are
        echo 'Message from Controller: You are in the Controller: Error, using the method index().';

        // load view(s)
        require 'application/views/_templates/header.php';
        require 'application/views/error/index.php';
        require 'application/views/_templates/footer.php';
    }
}
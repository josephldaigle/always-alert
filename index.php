<?php
/**
 * This file should start the session, setup global constants, and configure
 * autoloading, and error reporting and exception handling.
 */
session_start();

/*========== CONTSTANTS ===========*/

define('HOST', filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_STRING));

/*=================================*/


/*====== ERROR REPORTING ========*/
//error_reporting(0);
/*=================================*/


/*====== AUTOLOAD CLASSES ========*/
    function __autoload($class_name) {
        //class directories
        $directories = array(
            './',
            'model/',
            'model/dao/',
            'view/',
            'view/parts/',
            'controller/'
        );

        //for each directory
        foreach($directories as $directory)
        {
            //see if the file exsists
            if(file_exists($directory.$class_name . '.php'))
            {
                require ($directory.$class_name . '.php');
                return;
            }
        }
        
        die("Could not find class: " . $class_name . ".php");
    }
/*=============================*/

    
    
/*========== ROUTING ==========*/

MainController::getInstance();
MainController::route();

/*=============================*/
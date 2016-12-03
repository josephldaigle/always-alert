<?php
/**
 * MainController.
 * 
 * Responsible for routing, and instantiation of sub-controllers.
 *
 * @author Joseph Daigle
 */


class MainController {
    
    private static $instance;
    private static $HttpRequest;
    
    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance() {

        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }
    
    /**
     * Routes an HTTP Request to the appropriate controller.
     */
    public static function route() {
        //create HttpRequest object
        self::$HttpRequest = new HttpRequest();
        
        $action = self::$HttpRequest->get_arg('action');
        //route the request to the appropriate sub-controller
        switch ($action) {
            case 'init':            //go to the student lookup form.
                $view = new LookupView();
                echo $view->output();
                break;
            
            case 'find-student':    //user entered GCID to lookup
                $controller = new StudentController();
                $controller->do_request(self::$HttpRequest);
                break;
            
            case 'access-denied':   //user cannot pass authentication
                $view = new AccessDeniedView();
                echo $view->output();
                break;
            
            default:    //user has requested resource that doesn't exist.
                $view = new LookupView();
				//$view = new ResourcesNotAvailableView();
                echo $view->output();
                break;
        }
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    
    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    
    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}

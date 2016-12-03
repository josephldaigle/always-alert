<?php
/**
 * StudentController.
 * 
 * Controller for the student lookup feature.
 *
 * @author Joseph Daigle
 */
class StudentController {
    private $view;
    private $AlwaysAlertDao;
    
    public function __construct() {
        $this->AlwaysAlertDao = new AlwaysAlertDaoImpl();
    }
    
    public function do_request($httpRequest) {
        
        //route request
        switch($httpRequest->get_arg('action')) {
            
            case 'find-student':
                
                //search for student using user-entered gcid
                $alwaysAlertRecord = $this->AlwaysAlertDao->fetchAlwaysAlertRecord($httpRequest->get_arg('student-gcid'), $httpRequest->get_arg('term'));
                                
                //display view
                if (empty($alwaysAlertRecord)) {
                    //could not find student - display error message
                    $this->view = new LookupView();
                    $this->view->set_error_message("I'm sorry, but I can't find that student." .
                            " If you feel this is an error, please check that you are using the correct GCID (929xxxxxx).");
                    echo $this->view->output();
                } else {
                    $this->view = new LookupView();
                    $this->view->setAlwaysAlertDetail($alwaysAlertRecord);
                    echo $this->view->output();
                }
                
                break;
            
            default:
                $this->view = new ResourcesNotAvailableView();
                echo $this->view->output();
                break;
        }
    }
       
}

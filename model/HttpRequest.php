<?php
/**
 * HttpRequest.
 *
 * @author Joseph Daigle
 */
class HttpRequest {
    
    private $args;
    private $type;
    
    public function __construct() {
        //fetch and set request type
        $type = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
        
        if (!is_null($type) && !empty($type)) {
            $this->type = $type;
        }
        
        //parse request args
        $this->parse_args();
    }
    
    /**
     * Fetch, filter, and set the url arguments (GET or POST).
     * Only uses default string filter. Further validation should be
     * performed before consuming the user inputs.
     */
    private function parse_args() {
        
        switch($this->type) {
            case 'GET':
                $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
                if (!is_null($get) && !empty($get)) {
                    $this->args  = $get;
                }
                break;
            case 'POST':
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if (!is_null($post) && !empty($post)) {
                    $this->args  = $post;
                }
                
                //try to parse the action from the url
                if (!$this->get_arg('action')) {
                    $url = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);

                    $action = substr($url, strpos($url, "?action="));
                    $action = preg_replace('/(\?action\=)/', '', $action);
                    $this->args['action'] = $action;
                }
                break;
                
            default:
                $this->args = null;
                break;
        }
        
        
    }
    
    public function get_all_args() {
        return $this->args;
    }
    
    public function get_arg($key = null) {
        return (array_key_exists($key, $this->args) ? $this->args[$key] : false);
    }

    public function get_type() {
        return $this->type;
    }

    private function set_args($args) {
        $this->args = $args;
    }

    private function set_type($type) {
        $this->type = $type;
    }



}

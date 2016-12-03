<?php

/**
 * Description of View
 *
 * @author Joseph Daigle
 */
abstract class View {
    private $header;
    private $footer;
    private $notification;
    
    public function __construct() {
        $this->header = file_get_contents('view/parts/header.php');
//        $this->footer = file_get_contents('view/parts/footer.php');
        $this->footer = "</div></div></body></html>";
    }
    
    public function get_header() {
        return $this->header;
    }

    public function get_footer() {
        return $this->footer;
    }
   
    public function get_notification() {
        return $this->notification;
    }

    public function set_notification($notification) {
        if (is_null($notification) || empty($notification)) {
            throw new InvalidArgumentException("View notification cannot be null or empty.");
        }
        
        $this->notification = $notification;
    }
}
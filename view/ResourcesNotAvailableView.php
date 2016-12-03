<?php
/**
 * ResourcesNotAvailableView.
 * 
 * This is the standard 404 view.
 *
 * @author Joseph Daigle
 */

class ResourcesNotAvailableView extends View {
    
    public function __consruct($message = null) {
        parent::__construct();
        
        if (!is_null($message) && !empty($message)) {
            parent::set_notification($message);
        }
        
    }
    
    public function output() {
        header("HTTP/1.0 404 Not Found");
        $html = parent::get_header();
        
        $html .= "<div>Unfortunately, I can't seem to find the page you're looking" .
                " for. Please try again, or contact the IT Staff.</div>";
                    
        $html .= parent::get_footer();
        
        return $html;
    }
}

<?php
/**
 * Description of AccessDenied
 *
 * @author Joseph Daigle
 */
class AccessDeniedView extends View {
    
    public function __contstruct() {
        parent::__construct();
    }
    
    public function output() {
        header("HTTP/1.0 403 Forbidden");
        //get the page header
        $html = parent::get_header();
        
        //inject view-specific content
        $html .= <<<HTML
                    <i class="fa fa-times-circle"></i>
                    <p id="access-denied">Access to this page is denied. 
                        If you believe you have received this message in error, 
                    <a href="mailto: helpstar@gordonstate.edu" >Submit a help ticket</a> to
                Information Technology.</p>
HTML;
        
        //get the page footer
        $html .= parent::get_footer();
        
        //return the view
        return $html;
    }
}

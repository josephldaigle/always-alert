<?php

/**
 * This view outputs the query form for Always Alert.
 *
 * @author Joseph Daigle
 */
class LookupView extends View{
    
    private $errorMessage;
    private $alwaysAlertDetail;
  
    public function __construct() {
        parent::__construct();   
    }
    
    public function set_error_message($message) {
        if (!is_null($message) && !empty($message)) {
            $this->errorMessage = $message;
        }
    }
    
    /**
     * This method sets the students early alert record for the view.
     * @param mixed $detail - the student's always alert data set
     */
    public function setAlwaysAlertDetail($alwaysAlertDetail) {
        $this->alwaysAlertDetail = $alwaysAlertDetail;
    }
    
    public function output() {
        //get the page header
        $html = parent::get_header();
        
        //check for message to display
        if (isset($this->errorMessage)) {
            //inject error messages
            $html .= <<<HTML
                    <div class="user-message">
                        $this->errorMessage
                    </div>
HTML;
        } else {
            //inject welcome message
            $html .= <<<HTML
                    <span></span>
HTML;
        }
        
        //inject the content
        $html .= <<<HTML
                
                <form id="always-alert-form" method="post" action="./?action=find-student" >

                <span class="form-row">
                    <fieldset>
                        <legend>Student Lookup</legend>
                        
                        <label for="student-gcid">What is the student's GCID?</label>
                        <input name="student-gcid" type="text" pattern="^(929)([0-9]{6})" max-length="9"  
                               title="Please enter the student's GCID (929xxxxxx)." required="required" 
                               aria-required="required" placeholder="929xxxxxx"
                                   value="{$_POST['student-gcid']}" />
                        <br />           
                        <label for="term">Which term would you like to search?</label>
                        <select name="term">
HTML;
             
        $finalYear = 2010;                        
        $currentYear = (int)date("Y");
        $optionsList = array();
        
        do {
            array_push($optionsList, $currentYear . "08");
            array_push($optionsList, $currentYear . "05");
            array_push($optionsList, $currentYear . "02");
            
            $currentYear -= 1;
        } while ($finalYear <= $currentYear);
        
        $optionString = '';
        
        foreach ($optionsList as $listValue) {
            $optionString .= "<option value=\"$listValue\">$listValue</option>";
        }
        
        $html .= <<<HTML
                            $optionString;
                        </select> 
                        
                        <input type="submit" class="button" value="Submit" />
                    </fieldset>
                </span>
            </form>
HTML;
        
        

        if(isset($this->alwaysAlertDetail)) {
            $pidm = substr($this->alwaysAlertDetail[1], 1);
            
            $html .= "<div class=\"student-card\">";
            $html .= <<<HTML
                <img class="student-photo" src="/images/idimage.asp?id={$pidm}" alt="student-photo" />
                
HTML;
                
                //form student snapshot
            $html .= "<ul class=\"student-snapshot\"><li><span class=\"student-snapshot-label\">Name:</span>" . $this->alwaysAlertDetail[2] . "</li><li>" .
                "<span class=\"student-snapshot-label\">GCID:</span>" . $this->alwaysAlertDetail[0] . "</li><li>" .
                "<span class=\"student-snapshot-label\">Instructor:</span>" . $this->alwaysAlertDetail[3] . "</li><li>" .
                "<span class=\"student-snapshot-label\">CRN:</span>" . $this->alwaysAlertDetail[5] . "</li><li>" .
                "<span class=\"student-snapshot-label\">Advisor:</span>" . $this->alwaysAlertDetail[4] . "</li><li>" .
                "<span class=\"student-snapshot-label\">Reason:</span>" . $this->alwaysAlertDetail[6] . "</li><li>" .
                "<span class=\"student-snapshot-label\">Comment:</span>" . $this->alwaysAlertDetail[7] . "</li></ul>";
            
            $html .= "</div>";
        }
            
                        
        
        //get the page footer
        $html .= parent::get_footer();
        
        //return the view
        return $html;
    }
}

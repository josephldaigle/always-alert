<?php

/**
 * @author Joseph Daigle
 */
class Student {
    
    private $gcid;              //gcid
    private $first_name;
    private $last_name;
    private $portrait;          //student's photo from Gordon ID System
    
    function get_gcid() {
        return $this->gcid;
    }

    function get_pidm() {
        return $this->pidm;
    }

    function get_first_name() {
        return $this->first_name;
    }

    function get_last_name() {
        return $this->last_name;
    }

    function get_major() {
        return $this->major;
    }
    
    function get_class_level() {
        return $this->class_level;
    }

    function get_course_schedule() {
        return $this->course_schedule;
    }
    
    function get_student_portrait() {
        return $this->portrait;
    }

    function set_gcid($gcid) {
        $this->gcid = $gcid;
    }

    function set_pidm($pidm) {
        $this->pidm = $pidm;
    }

    function set_first_name($first_name) {
        $this->first_name = $first_name;
    }

    function set_last_name($last_name) {
        $this->last_name = $last_name;
    }

    function set_major($major) {
        $this->major = $major;
    }

    function set_course_schedule($course_schedule) {
        $this->course_schedule = $course_schedule;
    }
    
    function set_class_level($level) {
        $this->class_level = $level;
    }
    
    function set_student_portrait($portrait_html) {
        $this->portrait = $portrait_html;
    }
    
    function print_student_info() {
         return $string = $this->get_last_name() . ", " .
                 $this->get_first_name() . ": " . 
                 $this->get_gcid();
    }
    
    /**
     * Searches the student's course schedule for the course
     * corresponding to the crn passed as argument.
     * 
     * @param String $crn the id for the course
     * @return boolean
     */
    function get_course($crn) {
        if (!isset($this->course_schedule)) {
            return false;
        }
        
        foreach($this->course_schedule as $course) {
            if (strcasecmp($crn, $course['CRN']) === 0) {
                return $course;
            }
        }
        
        return false;
    }
    
}

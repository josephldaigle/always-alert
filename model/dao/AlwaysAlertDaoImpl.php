<?php
/**
 * Class AlwaysAlertDaoImpl.
 *
 * @author Joseph Daigle
 */
class AlwaysAlertDaoImpl implements AlwaysAlertDao{
    private $dbConn;      //connection object
    
    public function __construct() {
       try {
            //get the db connection file path
            $connection_file = $_SERVER['DOCUMENT_ROOT'] . '\includes\connection.inc.php';

            //load the file
            require_once($connection_file);
            
            //fetch connection object
            $this->dbConn = dbConnect('read');
            if (!$this->dbConn) {
                throw new Exception(oci_error());
            }

        } catch (Exception $ex) {
            die("Fatal error in StudentDAO: Cannot establish connection to " .
                    "the Banner Database. Please contact Information Technology ".
                    " at (678) 359-5008, if you feel you have reached this message in error.");
        }
    }
    
    public function fetchAlwaysAlertRecord($gcid, $term) {
        try {
            //query for active student
            $qry = "SELECT STUDENT.ID (W.PIDM, 'ND') ID,
                        W.PIDM,
                        STUDENT.NAME (W.PIDM, 13) STUDENT,
                        STUDENT.NAME (VC.INST_PIDM, 13) INSTRUCTOR,
                        STUDENT.NAME (STUDENT.ADVISOR_PIDM (W.PIDM), 13) STUDENT_ADVISOR,
                        W.CRN,
                        DECODE (STVGCMT_DESCRIPTION, 'All of the Above', 'Poor Attendance, Grades, Participation, WARNING', STVGCMT_DESCRIPTION) REASON,
                        NVL (REPLACE (REPLACE (REMARKS, '/', '-'), '%', 'percent'), 'NONE') COMMENTS,
                        W.TERM
                    FROM   BANINST1.WEALERT W, STVGCMT, V_COURSE VC
                    WHERE W.GCMT_CODE = STVGCMT_CODE
                        AND VC.TERM_CODE = W.TERM 
                        AND VC.TERM_CODE = :TERM
                        AND VC.CRN = W.CRN
                        AND STUDENT.ID(W.PIDM, 'ND') = :GCID";
            
            //Setup prepared statement
            $stid = oci_parse($this->dbConn, $qry);
            
            //bind data to query object
            oci_bind_by_name($stid, ':TERM', $term);
            oci_bind_by_name($stid, ':GCID', $gcid);

            //execute query
            $r = oci_execute($stid);
            
//            die(print_r(oci_error($stid)));
            
            //return false if query fails to commit
            if (!$r) {
                $r =  "Failed to retrieve records from Banner: ";
                //TODO log statement that db query did not retrieve results
            } else {
                $r = oci_fetch_array($stid, OCI_EXACT_FETCH);
            }

            //release connection objects and return false
            oci_free_statement($stid);
            
            return $r;
            
        } catch (Exception $e) {
            //close connections and return false on error
            oci_free_statement($stid);

            return null;
        }
    }
}

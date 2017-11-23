<?php
##############################################
# @DESCRIPTION : MARKETING MODULE 
# @AUTHOR      : NIRUSHIKA
# @CLASS       : Dealer Issues
# $designation_id=22(Supervisor)
# $designation_id=17(Manager),18(Assistant Manager),1(Incharge)
##############################################
date_default_timezone_set('America/New_York');

class DealerIssue {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }
    
    
    public function addNewDealerIssue($issue_rep,$order_dealer_code,$issue_date,$issue_category,$issue_details,$issue_emailto,$issue_emailcc,$issue_note_taken){

        $query = "INSERT INTO ".RDAMS_DEALER_ISSUES." (issue_rep,issue_dealer_code,issue_date,issue_category,issue_details,issue_to,issue_cc,issue_note_taken_by) VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $this->db->prepare($query);
 
        $stmt->bindParam(1, $issue_rep);
        $stmt->bindParam(2, $order_dealer_code);
        $stmt->bindParam(3, $issue_date);
        $stmt->bindParam(4, $issue_category);
        $stmt->bindParam(5, $issue_details);
        $stmt->bindParam(6, $issue_emailto);
        $stmt->bindParam(7, $issue_emailcc);
        $stmt->bindParam(8, $issue_note_taken);
        
        $stmt->execute();

        $results = $stmt->rowCount();
        return $results;
    }
    
    
    ############## view Dealer Issue List Start #################################
    
    public function viewPendingDealerList() {
        $designation_id = $_SESSION['user_type_id'];
        $dep_id = $_SESSION['user_dep_id'];
        $user_id = $_SESSION['user_id'];
        
        if(($designation_id=="1")||($designation_id=="3")||($designation_id=="4")||($designation_id=="17")||($designation_id=="18")){
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=1 ORDER BY issue_id DESC";
        }else if($designation_id=="22"){
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=1 AND emp_suprvisor='".$user_id."' ORDER BY issue_id DESC";
        }else{
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=1 AND issue_note_taken_by='".$user_id."' ORDER BY issue_id DESC";    
        }
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewResolvedDealerList() {
        $designation_id = $_SESSION['user_type_id'];
        $user_id = $_SESSION['user_id'];
        
        if(($designation_id=="1")||($designation_id=="3")||($designation_id=="4")||($designation_id=="17")||($designation_id=="18")){
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=2 ORDER BY issue_id DESC";
        }else if($designation_id=="22"){
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=2 AND emp_suprvisor='".$user_id."' ORDER BY issue_id DESC";
        }else{
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=2 AND issue_note_taken_by='".$user_id."' ORDER BY issue_id DESC";    
        }
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewClosedDealerList() {
        $designation_id = $_SESSION['user_type_id'];
        $user_id = $_SESSION['user_id'];
        
        if(($designation_id=="1")||($designation_id=="3")||($designation_id=="4")||($designation_id=="17")||($designation_id=="18")){
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=3 ORDER BY issue_id DESC";
        }else if($designation_id=="22"){
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=3 AND emp_suprvisor='".$user_id."' ORDER BY issue_id DESC";
        }else{
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                  WHERE issue_active=3 AND issue_note_taken_by='".$user_id."' ORDER BY issue_id DESC";    
        }
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    ############## view Dealer Issue List End #################################
    
    public function viewSelectedDealerIssue($id) {
        
        $query = "SELECT * FROM ".RDAMS_DEALER_ISSUES."
                 LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".RDAMS_DEALER_ISSUES.".issue_note_taken_by = ".RDAMS_EMPLOYEE.".user_id)
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 LEFT  JOIN ".COMM_DEALER." ON  (".RDAMS_DEALER_ISSUES.".issue_dealer_code = ".COMM_DEALER.".dealer_code)
                 LEFT  JOIN ".RDAMS_DEALER_MARKET." ON  (".COMM_DEALER.".dealer_market_id = ".RDAMS_DEALER_MARKET.".market_id)
                 WHERE issue_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $id);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    
    public function UpdateDealer($dealer_type,$dealer_fname,$dealer_lname,$dealer_store_name,$dealer_telephone,$dealer_fax,$dealer_address,$dealer_city,$dealer_postal_code,$dealer_state,$db_address,$db_city,$db_state,$db_postal_code,$ds_address,$ds_city,$ds_state,$ds_postal_code,$dealer_system_no,$dealer_bl_code,$dealer_active_no,$dealer_region,$dealer_market,$dealer_mark_exe,$dealer_sales_rep,$dealer_area_manager,$dealer_reg_manager,$dealer_code,$dealer_image,$id){

        $query = "UPDATE ".COMM_DEALER." SET dealer_type_id=?,dealer_fname=?,dealer_lname=?,dealer_store_name=?,dealer_contact_no=?,dealer_fax=?,dealer_address=?,dealer_city=?,dealer_zip_code=?,dealer_state=?,dealer_billing_addrs=?,dealer_billing_city=?,dealer_billing_state=?,dealer_billing_zip=?,dealer_shipping_addrs=?,dealer_shipping_city=?,dealer_shipping_state=?,dealer_shipping_zip=?,dealer_system_nr=?,dealer_bl_code=?,active=?,dealer_region=?,dealer_market_id=?,dealer_marketing_exe=?,dealer_sales_rep_id=?,dealer_area_manager=?,dealer_regional_manager=?,dealer_code=?,dealer_prof_picture=? WHERE dealer_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $dealer_type);
        $stmt->bindParam(2, $dealer_fname);
        $stmt->bindParam(3, $dealer_lname);
        $stmt->bindParam(4, $dealer_store_name);
        $stmt->bindParam(5, $dealer_telephone);
        $stmt->bindParam(6, $dealer_fax);
        $stmt->bindParam(7, $dealer_address);
        $stmt->bindParam(8, $dealer_city);
        $stmt->bindParam(9, $dealer_postal_code);
        $stmt->bindParam(10, $dealer_state);
        $stmt->bindParam(11, $db_address);
        $stmt->bindParam(12, $db_city);
        $stmt->bindParam(13, $db_state);
        $stmt->bindParam(14, $db_postal_code);
        $stmt->bindParam(15, $ds_address);
        $stmt->bindParam(16, $ds_city);
        $stmt->bindParam(17, $ds_state);
        $stmt->bindParam(18, $ds_postal_code);
        $stmt->bindParam(19, $dealer_system_no);
        $stmt->bindParam(20, $dealer_bl_code);
        $stmt->bindParam(21, $dealer_active_no);
        $stmt->bindParam(22, $dealer_region);
        $stmt->bindParam(23, $dealer_market);
        $stmt->bindParam(24, $dealer_mark_exe);
        $stmt->bindParam(25, $dealer_sales_rep);
        $stmt->bindParam(26, $dealer_area_manager);
        $stmt->bindParam(27, $dealer_reg_manager);
        $stmt->bindParam(28, $dealer_code);
        $stmt->bindParam(29, $dealer_image);
	$stmt->bindParam(30, $id);

        $stmt->execute();
        
        $results = $this->updateUser($dealer_type,$dealer_fname,$dealer_lname,$dealer_telephone,$dealer_fax,$db_address,$db_city,$db_state,$db_postal_code,$ds_address,$ds_city,$ds_state,$ds_postal_code,$dealer_code);
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
        
    }
    
    
    public function DeleteDealerIssue($iid) {

        $query = "UPDATE ".RDAMS_DEALER_ISSUES." SET issue_active=0 WHERE issue_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $stmt->rowCount();
    }	   
    
    
    public function updateIssueResolved($note,$id){
        session_start();
        $callingName = $_SESSION['user_calling_name'];
        
        $query = "UPDATE ".RDAMS_DEALER_ISSUES." SET issue_active=2, resolved_note_entered='".$callingName."', issue_resolved_note=? WHERE issue_id=?";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $note);
        $stmt->bindParam(2, $id);
        $stmt->execute();
         
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    public function updateIssueClosed($note,$id){
        session_start();
        $callingName = $_SESSION['user_calling_name'];
        
        $query = "UPDATE ".RDAMS_DEALER_ISSUES." SET issue_active=3, closed_note_entered='".$callingName."',issue_closed_note=? WHERE issue_id=?";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $note);
        $stmt->bindParam(2, $id);
        $stmt->execute();
         
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    public function SelectUserDetails($entered_by){
        
      $query = "SELECT * FROM ".RDAMS_EMPLOYEE." 
                LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                LEFT  JOIN ".RDAMS_EMP_DESIGNATION." ON  (".RDAMS_EMPLOYEE.".user_des_id = ".RDAMS_EMP_DESIGNATION.".des_id)
                LEFT  JOIN ".RDAMS_EMP_DEPARTMENT." ON  (".RDAMS_EMPLOYEE.".user_dept_id = ".RDAMS_EMP_DEPARTMENT.".dep_id)
		WHERE   user_id=? ";
        
        
        $stmt = $this->db->prepare($query);
   
        $stmt->bindParam(1, $entered_by);
        $stmt->execute();
     
        $results = $stmt->rowCount();

        if ($results > 0) {
            $rows = $stmt->fetch();
            return $rows;
        } else {
            return $rows = "No records found";
        }
    }
    
    public function viewSelectedDealerDetails($order_bl_code){
        
        $query = "SELECT * FROM ".COMM_DEALER." "
                . " LEFT  JOIN ".COMM_CUSTOMER_TYPE." ON  (".COMM_DEALER.".dealer_type_id = ".COMM_CUSTOMER_TYPE.".cus_type_id)"
                . " LEFT  JOIN ".RDAMS_DEALER_MARKET." ON  (".COMM_DEALER.".dealer_market_id = ".RDAMS_DEALER_MARKET.".market_id)"
                . " WHERE dealer_bl_code=? ";
        
        		     
        $stmt = $this->db->prepare($query);
   
        $stmt->bindParam(1, $order_bl_code);
        $stmt->execute();
     
        $results = $stmt->rowCount();

        if ($results > 0) {
            $rows = $stmt->fetch();
            return $rows;
        } else {
            return $rows = "No records found";
        }
    } 
   
}
?>

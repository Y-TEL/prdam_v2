<?php
##############################################
# @DESCRIPTION : MARKETING MODULE 
# @AUTHOR      : JALIYA LAMAHEWA
# @CLASS       : Dealer 
# @METHODS     : addNewDealer,viewDealerList,viewDistrubutorList,
#                viewSelectedDealerDetails
##############################################

date_default_timezone_set('America/New_York');

class Dealer {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }
    
    public function verifyUsername($user_name) {

        $query = "SELECT * FROM ".COMM_DEALER." WHERE dealer_email=? AND dealer_active=1 LIMIT 1";
		
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $user_name);
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            $row = $stmt->fetch();
            return $row;
        } else {
            return false;
        }
    }
    
//    public function addNewUser($user_name,$password,$user_type,$user_fname,$user_lname,$user_store_name,
//            $telephone,$fax,$permanent_address,$user_city,$user_postal_code,$billing_address,
//            $shipping_address,$area_manager,$sales_rep,$supervisor){
//     
//            $results = $this->addNewDealer($user_name,$password,$user_type,$user_fname,$user_lname,$user_store_name,
//            $telephone,$fax,$permanent_address,$user_city,$user_postal_code,$billing_address,
//            $shipping_address,$area_manager,$sales_rep,$supervisor);
//
//        if ($results > 0) {
//            return $msg = "Successfully Added";
//        } else {
//            return $msg = "Something went wrong. Try again";
//        }
//    }
    
    public function getLastDealerCode(){
        
        $query = "SELECT dealer_code FROM ".COMM_DEALER." ORDER BY dealer_id DESC LIMIT 1";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
          
	if ($results > 0) {
            $rows = $stmt->fetchAll();
            return $rows;
        } else {
            return $rows = "No records found";
        }
    }
    
    
    public function addNewDealer($dealer_user_name,$dealer_password,$dealer_code,$dealer_type,$dealer_fname,$dealer_lname,$dealer_store_name,$dealer_telephone,$dealer_fax,$dealer_address,$dealer_city,$dealer_postal_code,$dealer_state,$db_address,$db_city,$db_state,$db_postal_code,$ds_address,$ds_city,$ds_state,$ds_postal_code,$dealer_bl_code,$dealer_region,$dealer_states,$dealer_market,$dealer_mark_exe,$dealer_sales_rep,$dealer_area_manager,$dealer_reg_manager,$dealer_verifi_code,$dealer_image,$active){

        $query = "INSERT INTO ".COMM_DEALER." (
                 dealer_email,
                 dealer_password,
                 dealer_code,
                 dealer_type_id,
                 dealer_fname,
                 dealer_lname,
                 dealer_store_name,
                 dealer_contact_no,
                 dealer_fax,
                 dealer_address,
                 dealer_city,
                 dealer_zip_code,
                 dealer_state,
                 dealer_billing_addrs,
                 dealer_billing_city,
                 dealer_billing_state,
                 dealer_billing_zip,
                 dealer_shipping_addrs,
                 dealer_shipping_city,
                 dealer_shipping_state,
                 dealer_shipping_zip,
                 dealer_bl_code,
                 dealer_region,
                 dealer_states,
                 dealer_market_id,
                 dealer_marketing_exe,
                 dealer_sales_rep_id,
                 dealer_area_manager,
                 dealer_regional_manager,
                 dealer_verify_code,
                 dealer_prof_picture,
                 dealer_active) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->db->prepare($query);
 
        $stmt->bindParam(1, $dealer_user_name);
        $stmt->bindParam(2, $dealer_password);
        $stmt->bindParam(3, $dealer_code);
        $stmt->bindParam(4, $dealer_type);
        $stmt->bindParam(5, $dealer_fname);
        $stmt->bindParam(6, $dealer_lname);
        $stmt->bindParam(7, $dealer_store_name);
        $stmt->bindParam(8, $dealer_telephone);
        $stmt->bindParam(9, $dealer_fax);
        $stmt->bindParam(10, $dealer_address);
        $stmt->bindParam(11, $dealer_city);
        $stmt->bindParam(12, $dealer_postal_code);
        $stmt->bindParam(13, $dealer_state);
        $stmt->bindParam(14, $db_address);
        $stmt->bindParam(15, $db_city);
        $stmt->bindParam(16, $db_state);
        $stmt->bindParam(17, $db_postal_code);
        $stmt->bindParam(18, $ds_address);
        $stmt->bindParam(19, $ds_city);
        $stmt->bindParam(20, $ds_state);
        $stmt->bindParam(21, $ds_postal_code);
        $stmt->bindParam(22, $dealer_bl_code);
        $stmt->bindParam(23, $dealer_region);
        $stmt->bindParam(24, $dealer_states);
        $stmt->bindParam(25, $dealer_market);
        $stmt->bindParam(26, $dealer_mark_exe);
        $stmt->bindParam(27, $dealer_sales_rep);
        $stmt->bindParam(28, $dealer_area_manager);
        $stmt->bindParam(29, $dealer_reg_manager);
        $stmt->bindParam(30, $dealer_verifi_code);
        $stmt->bindParam(31, $dealer_image);
        $stmt->bindParam(32, $active);

        $stmt->execute();

        $results = $this->addNewUser($dealer_code,$dealer_type,$dealer_password,$dealer_user_name,$dealer_fname,$dealer_lname,$dealer_telephone,$dealer_fax,$db_address,$db_city,$db_state,$db_postal_code,$ds_address,$ds_city,$ds_state,$ds_postal_code,$active);
        
        $results = $stmt->rowCount();
        return $results;
    }
    
    private function addNewUser($dealer_code,$dealer_type,$dealer_password,$dealer_user_name,$dealer_fname,$dealer_lname,$dealer_telephone,$dealer_fax,$db_address,$db_city,$db_state,$db_postal_code,$ds_address,$ds_city,$ds_state,$ds_postal_code,$active){

        $query = "INSERT INTO ".COMM_USERS." (
                 user_ref_id,
                 user_type_id,
                 user_password,
                 user_name,
                 first_name,
                 last_name,
                 contact_no,
                 fax,
                 billing_addrs,
                 billing_city,
                 billing_state,
                 billing_zip,
                 shipping_addrs,
                 shipping_city,
                 shipping_state,
                 shipping_zip,
                 user_active) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->db->prepare($query);
 
        $stmt->bindParam(1, $dealer_code);
        $stmt->bindParam(2, $dealer_type);
        $stmt->bindParam(3, $dealer_password);
        $stmt->bindParam(4, $dealer_user_name);
        $stmt->bindParam(5, $dealer_fname);
        $stmt->bindParam(6, $dealer_lname);
        $stmt->bindParam(7, $dealer_telephone);
        $stmt->bindParam(8, $dealer_fax);
        $stmt->bindParam(9, $db_address);
        $stmt->bindParam(10, $db_city);
        $stmt->bindParam(11, $db_state);
        $stmt->bindParam(12, $db_postal_code);
        $stmt->bindParam(13, $ds_address);
        $stmt->bindParam(14, $ds_city);
        $stmt->bindParam(15, $ds_state);
        $stmt->bindParam(16, $ds_postal_code);
        $stmt->bindParam(17, $active);

        $stmt->execute();

        $results = $stmt->rowCount();
        return $results;
    }
    
    ############## view Dealer List Start #################################
    
    public function viewDealerList(){
        
        $query = "SELECT * FROM ".COMM_DEALER." "
                . "LEFT  JOIN ".COMM_CUSTOMER_TYPE." ON (".COMM_DEALER.".dealer_type_id = ".COMM_CUSTOMER_TYPE.".cus_type_id)"
                . "LEFT  JOIN ".RDAMS_DEALER_MARKET." ON  (".COMM_DEALER.".dealer_market_id = ".RDAMS_DEALER_MARKET.".market_id)"
                . "ORDER BY ".COMM_DEALER.".dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
   /* 
    public function viewDistrubutorList(){
        
        $query = "SELECT * FROM ".COMM_DEALER."
                 WHERE dealer_type_id=2 ORDER BY ".COMM_DEALER.".dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewMomPopList(){
        
        $query = "SELECT * FROM ".COMM_DEALER."
                 WHERE dealer_type_id=4 ORDER BY ".COMM_DEALER.".dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    */
    public function viewMyDealerList($user_id) {
        
        $query = "SELECT * FROM ".COMM_DEALER."
                  LEFT  JOIN ".COMM_CUSTOMER_TYPE." ON (".COMM_DEALER.".dealer_type_id = ".COMM_CUSTOMER_TYPE.".cus_type_id)
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".COMM_DEALER.".dealer_marketing_exe = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  WHERE (dealer_marketing_exe='".$user_id."' OR dealer_sales_rep_id='".$user_id."' OR dealer_area_manager='".$user_id."' OR dealer_regional_manager='".$user_id."' OR emp_suprvisor='".$user_id."') ORDER BY dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);
        
        //$stmt->bindParam(1, $user_id);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    /*
    public function viewMyDistrubutorList($user_id) {
        
        $query = "SELECT * FROM ".COMM_DEALER."
                 WHERE dealer_type_id=2 AND (dealer_marketing_exe='".$user_id."' OR dealer_sales_rep_id='".$user_id."' OR dealer_area_manager='".$user_id."' OR dealer_regional_manager='".$user_id."') ORDER BY dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);
        
        //$stmt->bindParam(1, $user_id);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewMyMomPopList($user_id) {
        
        $query = "SELECT * FROM ".COMM_DEALER."
                 WHERE dealer_type_id=4 AND (dealer_marketing_exe='".$user_id."' OR dealer_sales_rep_id='".$user_id."' OR dealer_area_manager='".$user_id."' OR dealer_regional_manager='".$user_id."') ORDER BY dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);
        
        //$stmt->bindParam(1, $user_id);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    */
    public function selectDealerME($ME){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $ME);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function selectDealerACM($ACM){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $ACM);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function selectDealerRM($RM){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $RM);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function selectDealerRep($REP){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $REP);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function viewSupervisorDealerList($user_id) {
        
        $query = "SELECT * FROM ".COMM_DEALER."
                  LEFT  JOIN ".COMM_CUSTOMER_TYPE." ON (".COMM_DEALER.".dealer_type_id = ".COMM_CUSTOMER_TYPE.".cus_type_id)
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".COMM_DEALER.".dealer_marketing_exe = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  WHERE dealer_active=1 AND emp_suprvisor='".$user_id."' ORDER BY dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);
        
        //$stmt->bindParam(1, $user_id);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewSupervisorDealerListWithoutME($market){
        
        $query = "SELECT * FROM ".COMM_DEALER."
                  LEFT  JOIN ".COMM_CUSTOMER_TYPE." ON (".COMM_DEALER.".dealer_type_id = ".COMM_CUSTOMER_TYPE.".cus_type_id)
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".COMM_DEALER.".dealer_marketing_exe = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  WHERE dealer_active=1 AND dealer_market_id='".$market."' AND (dealer_marketing_exe = '' OR user_active =0) ORDER BY dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);
        
        //$stmt->bindParam(1, $user_id);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewSupervisorDistrubutorList($user_id) {
        
        $query = "SELECT * FROM ".COMM_DEALER."
                 LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".COMM_DEALER.".dealer_marketing_exe = ".RDAMS_EMPLOYEE.".user_id)
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE dealer_type_id=2 AND emp_suprvisor='".$user_id."' ORDER BY dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);
        
        //$stmt->bindParam(1, $user_id);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewSupervisorMomPopList($user_id){
        
        $query = "SELECT * FROM ".COMM_DEALER."
                 LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".COMM_DEALER.".dealer_marketing_exe = ".RDAMS_EMPLOYEE.".user_id)
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE dealer_type_id=4 AND emp_suprvisor='".$user_id."' ORDER BY dealer_id DESC";
        		     
        $stmt = $this->db->prepare($query);
        
        //$stmt->bindParam(1, $user_id);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    ############## view Dealer List End #################################
    
    public function viewSelectedUserDetails($id) {
        
        $query = "SELECT * FROM ".COMM_DEALER."
                 LEFT  JOIN ".RDAMS_EMPLOYEE." ON  (".COMM_DEALER.".dealer_marketing_exe = ".RDAMS_EMPLOYEE.".user_id)
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 LEFT  JOIN ".RDAMS_DEALER_MARKET." ON  (".COMM_DEALER.".dealer_market_id = ".RDAMS_DEALER_MARKET.".market_id)
                 WHERE dealer_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $id);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function viewSelectedSalesRep($RepID){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $RepID);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function viewSelectedAreaMg($AreaMgID){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $AreaMgID);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function viewSelectedRegMg($RegMgID){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $RegMgID);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function UpdateDealer($dealer_type,$dealer_fname,$dealer_lname,$dealer_store_name,$dealer_telephone,$dealer_fax,$dealer_address,$dealer_city,$dealer_postal_code,$dealer_state,$db_address,$db_city,$db_state,$db_postal_code,$ds_address,$ds_city,$ds_state,$ds_postal_code,$dealer_bl_code,$dealer_region,$dealer_states,$dealer_market,$dealer_mark_exe,$dealer_sales_rep,$dealer_area_manager,$dealer_reg_manager,$dealer_code,$dealer_image,$id){

        $query = "UPDATE ".COMM_DEALER." SET dealer_type_id=?,dealer_fname=?,dealer_lname=?,dealer_store_name=?,dealer_contact_no=?,dealer_fax=?,dealer_address=?,dealer_city=?,dealer_zip_code=?,dealer_state=?,dealer_billing_addrs=?,dealer_billing_city=?,dealer_billing_state=?,dealer_billing_zip=?,dealer_shipping_addrs=?,dealer_shipping_city=?,dealer_shipping_state=?,dealer_shipping_zip=?,dealer_bl_code=?,dealer_region=?,dealer_states=?,dealer_market_id=?,dealer_marketing_exe=?,dealer_sales_rep_id=?,dealer_area_manager=?,dealer_regional_manager=?,dealer_code=?,dealer_prof_picture=? WHERE dealer_id=?";
        
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
        $stmt->bindParam(19, $dealer_bl_code);
        $stmt->bindParam(20, $dealer_region);
        $stmt->bindParam(21, $dealer_states);
        $stmt->bindParam(22, $dealer_market);
        $stmt->bindParam(23, $dealer_mark_exe);
        $stmt->bindParam(24, $dealer_sales_rep);
        $stmt->bindParam(25, $dealer_area_manager);
        $stmt->bindParam(26, $dealer_reg_manager);
        $stmt->bindParam(27, $dealer_code);
        $stmt->bindParam(28, $dealer_image);
	$stmt->bindParam(29, $id);

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
    
    private function updateUser($dealer_type,$dealer_fname,$dealer_lname,$dealer_telephone,$dealer_fax,$db_address,$db_city,$db_state,$db_postal_code,$ds_address,$ds_city,$ds_state,$ds_postal_code,$dealer_code){

        $query = "UPDATE ".COMM_USERS." SET user_type_id=?,first_name=?,last_name=?,contact_no=?,fax=?,billing_addrs=?,billing_city=?,billing_state=?,billing_zip=?,shipping_addrs=?,shipping_city=?,shipping_state=?,shipping_zip=? WHERE user_ref_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $dealer_type);
        $stmt->bindParam(2, $dealer_fname);
        $stmt->bindParam(3, $dealer_lname);
        $stmt->bindParam(4, $dealer_telephone);
        $stmt->bindParam(5, $dealer_fax);
        $stmt->bindParam(6, $db_address);
        $stmt->bindParam(7, $db_city);
        $stmt->bindParam(8, $db_state);
        $stmt->bindParam(9, $db_postal_code);
        $stmt->bindParam(10, $ds_address);
        $stmt->bindParam(11, $ds_city);
        $stmt->bindParam(12, $ds_state);
        $stmt->bindParam(13, $ds_postal_code);
	$stmt->bindParam(14, $dealer_code);

        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
        
    }
    
    public function DeleteDealer($iid) {

        $query = "UPDATE ".COMM_DEALER." SET dealer_active=0 WHERE dealer_code=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $this->DeleteUser($iid);

        $results = $stmt->rowCount();
    }	   
    
    public function DeleteUser($iid) {

        $query = "UPDATE ".COMM_USERS." SET user_active=0 WHERE user_ref_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $stmt->rowCount();
    }	
    
    public function ActivateDealer($dealer_active,$dealer_code){

        $query = "UPDATE ".COMM_DEALER." SET dealer_active=? WHERE dealer_code=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $dealer_active);
	$stmt->bindParam(2, $dealer_code);

        $stmt->execute();
             
        $results = $this->ActivateUser($dealer_active,$dealer_code);
         
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    public function ActivateUser($dealer_active,$dealer_code){

        $query = "UPDATE ".COMM_USERS." SET user_active=? WHERE user_ref_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $dealer_active);
	$stmt->bindParam(2, $dealer_code);

        $stmt->execute();
             
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    public function updateDealerME($dealer_new_ME,$dealer_code){
  
        $query = "UPDATE ".COMM_DEALER." SET dealer_marketing_exe=? WHERE dealer_code=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $dealer_new_ME);
	$stmt->bindParam(2, $dealer_code);

        $stmt->execute();
             
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    public function updateDealerNoME($new_no_dealer_ME,$market,$dealer_count){
        echo $dealer_count;
  
        $query = "UPDATE ".COMM_DEALER." "
                ."SET dealer_marketing_exe=? WHERE dealer_market_id=? AND dealer_type_id=1 AND (dealer_marketing_exe = '') ORDER BY dealer_id DESC LIMIT ".$dealer_count." ";
        
       /* $query = "SELECT * FROM ".COMM_DEALER."
                  LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".COMM_DEALER.".dealer_marketing_exe = ".RDAMS_EMPLOYEE.".user_id)
                  LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                  WHERE dealer_type_id=1 AND dealer_market_id='".$market."' AND (dealer_marketing_exe = '' OR user_active =0) ORDER BY dealer_id DESC"; */
        
        echo $query;
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $new_no_dealer_ME);
        $stmt->bindParam(2, $market);
        //$stmt->bindParam(3, $dealer_count);

        $stmt->execute();
             
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    
}
?>

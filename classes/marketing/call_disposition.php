<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

date_default_timezone_set('America/New_York');


class CLDisposition {

   private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    
    public function addActivation($act_agent_name,$act_dealer_type,$exs_dealer_bl,$act_store_name,$act_phone_no,$act_market,$act_market_cat,$act_call_type,$act_outcome,$act_comments,$act_dealer_status,$created_date,$created_time){
          
        $query = "INSERT INTO ".RDAMS_CALL_DISPOSITION." (activation_agent_name,activation_dealer_type,activation_dealer_id,activation_store_name,activation_phone_no,activation_market_id,activation_market_type,activation_call_type,activation_outcome,activation_comments,activation_dealer_status,activation_entered_date,activation_entered_time) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $act_agent_name);
        $stmt->bindParam(2, $act_dealer_type);
        $stmt->bindParam(3, $exs_dealer_bl);
        $stmt->bindParam(4, $act_store_name);
        $stmt->bindParam(5, $act_phone_no);
        $stmt->bindParam(6, $act_market);
        $stmt->bindParam(7, $act_market_cat);
        $stmt->bindParam(8, $act_call_type);
        $stmt->bindParam(9, $act_outcome);
        $stmt->bindParam(10, $act_comments);
        $stmt->bindParam(11, $act_dealer_status);
        $stmt->bindParam(12, $created_date);
        $stmt->bindParam(13, $created_time);

        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }

    public function updateDealerPhoneNoReachable($phone_no_1_reachable,$phone_no_2_reachable,$phone_no_3_reachable,$phone_no_1_date,$phone_no_2_date,$phone_no_3_date,$exs_dealer_bl){

        $query = "UPDATE ".COMM_DEALER." SET dealer_contact_no1_reachable=?,dealer_contact_no2_reachable=?,dealer_contact_no3_reachable=?,dealer_contact_no1_check_date=?,dealer_contact_no2_check_date=?,dealer_contact_no3_check_date=? WHERE dealer_bl_code=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $phone_no_1_reachable);
        $stmt->bindParam(2, $phone_no_2_reachable);
        $stmt->bindParam(3, $phone_no_3_reachable);
        $stmt->bindParam(4, $phone_no_1_date);
        $stmt->bindParam(5, $phone_no_2_date);
        $stmt->bindParam(6, $phone_no_3_date);
        $stmt->bindParam(7, $exs_dealer_bl);

        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    

    public function viewActivationList() {

        $query = "SELECT * FROM ".RDAMS_CALL_DISPOSITION." 
                  WHERE activation_active != 0 and activation_entered_date BETWEEN '".date("Y-m-d")."' AND '".date('Y-m-d')."' 
                  ORDER BY activation_id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        //$stmt->debugDumpParams();

        $results = $stmt->rowCount();

        $rows = $stmt->fetchAll();

        return $rows;

    }
    
    public function viewSelectedCallDisposition($id) {
        
      $query = "SELECT * FROM ".RDAMS_CALL_DISPOSITION." "
              . "LEFT  JOIN ".RDAMS_DEALER_MARKET." ON  (".RDAMS_CALL_DISPOSITION.".activation_market_id = ".RDAMS_DEALER_MARKET.".market_id)"
              . " WHERE activation_id='$id' ";
        
        $stmt = $this->db->prepare($query);
   
        $stmt->bindParam(1, $id);
        $stmt->execute();
     
        $results = $stmt->rowCount();

        if ($results > 0) {
            $rows = $stmt->fetch();
            return $rows;
        } else {
            return $rows = "No records found";
        }
    }

	
    public function viewActivationListRange($start_from, $end_to) {

        $query = "SELECT * FROM ".RDAMS_CALL_DISPOSITION." 
                  WHERE activation_active != 0 and activation_entered_date BETWEEN '".$start_from."' AND '".$end_to."' 
                  ORDER BY activation_id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        //$stmt->debugDumpParams();

        $results = $stmt->rowCount();

        $rows = $stmt->fetchAll();

        return $rows;
    }

	public function viewSelectedActivationList($start_from,$end_to) {

	$query = "SELECT * FROM ".RDAMS_CALL_DISPOSITION." "
                . "LEFT  JOIN ".RDAMS_DEALER_MARKET." ON  (".RDAMS_CALL_DISPOSITION.".activation_market_id = ".RDAMS_DEALER_MARKET.".market_id)"
                . " WHERE activation_active != 0 AND (activation_entered_date BETWEEN '".$start_from."' AND '".$end_to."') ORDER BY activation_id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        //$stmt->debugDumpParams();

        $results = $stmt->rowCount();


        $rows = $stmt->fetchAll();

        return $rows;
    }
    
    
    public function deleteActivation($iid) {

        $query = "UPDATE ".RDAMS_CALL_DISPOSITION." SET activation_active=0 WHERE activation_id=?";

        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $iid);

        $stmt->execute();

        $results = $stmt->rowCount();
        return $results;
    }
    
    public function viewSelectedDealerDetails($dealer_bl_code){
        
        $query = "SELECT * FROM ".COMM_DEALER." "
                . " LEFT  JOIN ".COMM_CUSTOMER_TYPE." ON  (".COMM_DEALER.".dealer_type_id = ".COMM_CUSTOMER_TYPE.".cus_type_id)"
                . " LEFT  JOIN ".RDAMS_DEALER_MARKET." ON  (".COMM_DEALER.".dealer_market_id = ".RDAMS_DEALER_MARKET.".market_id)"
                . " WHERE dealer_bl_code=? ";
        
        $stmt = $this->db->prepare($query);
   
        $stmt->bindParam(1, $dealer_bl_code);
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

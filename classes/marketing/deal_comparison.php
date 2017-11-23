<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

class DealComparison {

    private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addNewCarrierDeal($comp_carrier,$comp_plan,$deal_sim_price,$deal_activation_spiff,$deal_2nd_spiff,$deal_3rd_spiff,$deal_residual,$deal_atr,$deal_note,$created_date){
             
        $query = "INSERT INTO ".RDAMS_DEALS_CARRIER_COMPARISON." (deal_carrier_id,deal_plan_id,deal_sim_price,deal_activation_spiff,deal_2nd_spiff,deal_3rd_spiff,deal_residual,deal_atr,deal_note,deal_entered_date) VALUES (?,?,?,?,?,?,?,?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $comp_carrier); 
        $stmt->bindParam(2, $comp_plan);
        $stmt->bindParam(3, $deal_sim_price);
        $stmt->bindParam(4, $deal_activation_spiff);
        $stmt->bindParam(5, $deal_2nd_spiff);
        $stmt->bindParam(6, $deal_3rd_spiff);
        $stmt->bindParam(7, $deal_residual);
        $stmt->bindParam(8, $deal_atr);
        $stmt->bindParam(9, $deal_note);
        $stmt->bindParam(10, $created_date);
        
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    

    public function viewAllCarrierDeals() {
        
        $query = "SELECT * FROM ".RDAMS_DEALS_CARRIER_COMPARISON." "
                . "LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_DEALS_CARRIER_COMPARISON.".deal_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)"
                . "LEFT  JOIN ".RDAMS_PLAN_DETAILS." ON (".RDAMS_DEALS_CARRIER_COMPARISON.".deal_plan_id = ".RDAMS_PLAN_DETAILS.".plan_id)"
                . "WHERE deal_active=1 ORDER BY deal_carrier_id DESC";
        
        		     
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
          
		  
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    
    public function viewSelectedCarrierDeal($id) {
        
      $query = "SELECT * FROM ".RDAMS_DEALS_CARRIER_COMPARISON." "
              . "LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_DEALS_CARRIER_COMPARISON.".deal_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)"
              . "LEFT  JOIN ".RDAMS_PLAN_DETAILS." ON (".RDAMS_DEALS_CARRIER_COMPARISON.".deal_plan_id = ".RDAMS_PLAN_DETAILS.".plan_id)"
              . "WHERE deal_id='$id' ";
        
        
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

    public function UpdateCarrierDeal($comp_carrier,$comp_plan,$deal_sim_price,$deal_activation_spiff,$deal_2nd_spiff,$deal_3rd_spiff,$deal_residual,$deal_atr,$deal_note,$id){

        $query = "UPDATE ".RDAMS_DEALS_CARRIER_COMPARISON." SET deal_carrier_id=?,deal_plan_id=?,deal_sim_price=?,deal_activation_spiff=?,deal_2nd_spiff=?,deal_3rd_spiff=?,deal_residual=?,deal_atr=?,deal_note=? WHERE deal_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $comp_carrier); 
        $stmt->bindParam(2, $comp_plan);
        $stmt->bindParam(3, $deal_sim_price);
        $stmt->bindParam(4, $deal_activation_spiff);
        $stmt->bindParam(5, $deal_2nd_spiff);
        $stmt->bindParam(6, $deal_3rd_spiff);
        $stmt->bindParam(7, $deal_residual);
        $stmt->bindParam(8, $deal_atr);
        $stmt->bindParam(9, $deal_note);
	$stmt->bindParam(10, $id);

        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
        
    }
	
	 public function DeleteCarrierDeal($iid) {

        $query = "UPDATE ".RDAMS_DEALS_CARRIER_COMPARISON." SET deal_active=0 WHERE deal_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $stmt->rowCount();

    }
    
    public function viewSelectedFirstCarrierDeal($comp_carrier_1, $comp_plan_1){
       
      $query = "SELECT * FROM ".RDAMS_DEALS_CARRIER_COMPARISON." "
              . "LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_DEALS_CARRIER_COMPARISON.".deal_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)"
              . "LEFT  JOIN ".RDAMS_PLAN_DETAILS." ON (".RDAMS_DEALS_CARRIER_COMPARISON.".deal_plan_id = ".RDAMS_PLAN_DETAILS.".plan_id)"
              . "WHERE deal_carrier_id=? AND deal_plan_id=? ";
        
        $stmt = $this->db->prepare($query);
   
        $stmt->bindParam(1, $comp_carrier_1);
        $stmt->bindParam(2, $comp_plan_1);
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            $rows = $stmt->fetch();
            return $rows;
        } else {
            return $rows = "No records found";
        }
    }
    
    public function viewSelectedSecondCarrierDeal($comp_carrier_2, $comp_plan_2){
       
      $query = "SELECT * FROM ".RDAMS_DEALS_CARRIER_COMPARISON." "
              . "LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_DEALS_CARRIER_COMPARISON.".deal_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)"
              . "LEFT  JOIN ".RDAMS_PLAN_DETAILS." ON (".RDAMS_DEALS_CARRIER_COMPARISON.".deal_plan_id = ".RDAMS_PLAN_DETAILS.".plan_id)"
              . "WHERE deal_carrier_id=? AND deal_plan_id=? ";
        
        $stmt = $this->db->prepare($query);
   
        $stmt->bindParam(1, $comp_carrier_2);
        $stmt->bindParam(2, $comp_plan_2);
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

<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

class Comparison {

    private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addNewComparison($comp_carrier,$comp_plan,$com_validity,$com_data,$com_talk,$com_text,$com_interntnl,$com_features,$com_note,$created_date){
             
        $query = "INSERT INTO ".RDAMS_CARRIER_COMPARISON." (com_carrier_id,com_plan_id,com_validity,com_data,com_talk,com_text,com_international,com_features,com_note,com_entered_date) VALUES (?,?,?,?,?,?,?,?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $comp_carrier); 
        $stmt->bindParam(2, $comp_plan);
        $stmt->bindParam(3, $com_validity);
        $stmt->bindParam(4, $com_data);
        $stmt->bindParam(5, $com_talk);
        $stmt->bindParam(6, $com_text);
        $stmt->bindParam(7, $com_interntnl);
        $stmt->bindParam(8, $com_features);
        $stmt->bindParam(9, $com_note);
        $stmt->bindParam(10, $created_date);
        
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    

    public function viewAllCarrierCopmarison() {
        
        $query = "SELECT * FROM ".RDAMS_CARRIER_COMPARISON." "
                . "LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_CARRIER_COMPARISON.".com_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)"
                . "LEFT  JOIN ".RDAMS_PLAN_DETAILS." ON (".RDAMS_CARRIER_COMPARISON.".com_plan_id = ".RDAMS_PLAN_DETAILS.".plan_id)"
                . "WHERE com_active=1 ORDER BY com_carrier_id DESC";
        
        		     
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
          
		  
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    
    public function viewSelectedCarrierComparison($id) {
        
      $query = "SELECT * FROM ".RDAMS_CARRIER_COMPARISON." "
              . "LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_CARRIER_COMPARISON.".com_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)"
              . "LEFT  JOIN ".RDAMS_PLAN_DETAILS." ON (".RDAMS_CARRIER_COMPARISON.".com_plan_id = ".RDAMS_PLAN_DETAILS.".plan_id)"
              . "WHERE com_id='$id' ";
        
        
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

    public function UpdateCarrierCopmarison($comp_carrier,$comp_plan,$com_validity,$com_data,$com_talk,$com_text,$com_interntnl,$com_features,$com_note,$created_date,$id){

        $query = "UPDATE ".RDAMS_CARRIER_COMPARISON." SET com_carrier_id=?,com_plan_id=?,com_validity=?,com_data=?,com_talk=?,com_text=?,com_international=?,com_features=?,com_note=?,com_entered_date=? WHERE com_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $comp_carrier);
        $stmt->bindParam(2, $comp_plan);
        $stmt->bindParam(3, $com_validity);
        $stmt->bindParam(4, $com_data);
        $stmt->bindParam(5, $com_talk);
        $stmt->bindParam(6, $com_text);
        $stmt->bindParam(7, $com_interntnl);
        $stmt->bindParam(8, $com_features);
        $stmt->bindParam(9, $com_note);
        $stmt->bindParam(10, $created_date);
	$stmt->bindParam(11, $id);

        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
        
    }
	
	 public function DeleteCarrierComparison($iid) {

        $query = "UPDATE ".RDAMS_CARRIER_COMPARISON." SET com_active=0 WHERE com_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $stmt->rowCount();

    }
    
    public function viewSelectedFirstCarrier($comp_carrier_1, $comp_plan_1){
       
      $query = "SELECT * FROM ".RDAMS_CARRIER_COMPARISON." "
              . "LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_CARRIER_COMPARISON.".com_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)"
              . "LEFT  JOIN ".RDAMS_PLAN_DETAILS." ON (".RDAMS_CARRIER_COMPARISON.".com_plan_id = ".RDAMS_PLAN_DETAILS.".plan_id)"
              . "WHERE com_carrier_id=? AND com_plan_id=? ";
        
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
    
    public function viewSelectedSecondCarrier($comp_carrier_2, $comp_plan_2){
       
      $query = "SELECT * FROM ".RDAMS_CARRIER_COMPARISON." "
              . "LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_CARRIER_COMPARISON.".com_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)"
              . "LEFT  JOIN ".RDAMS_PLAN_DETAILS." ON (".RDAMS_CARRIER_COMPARISON.".com_plan_id = ".RDAMS_PLAN_DETAILS.".plan_id)"
              . "WHERE com_carrier_id=? AND com_plan_id=? ";
        
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

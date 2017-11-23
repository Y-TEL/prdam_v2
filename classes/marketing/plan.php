<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

class Plan {

    private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addNewPlan($carrier_name,$plan_name){
             
        $query = "INSERT INTO ".RDAMS_PLAN_DETAILS." (plan_carrier_id,plan_name) VALUES (?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $carrier_name); 
        $stmt->bindParam(2, $plan_name);
        
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    

    public function viewPlanList() {
        
        $query = "SELECT * FROM ".RDAMS_PLAN_DETAILS." 
                  LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_PLAN_DETAILS.".plan_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)
                  WHERE plan_active=1 ORDER BY plan_id DESC";
        
        		     
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
          
		  
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    
    public function viewSelectedPlan($id) {
        
      $query = "SELECT * FROM ".RDAMS_PLAN_DETAILS."
                LEFT  JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_PLAN_DETAILS.".plan_carrier_id = ".RDAMS_CARRIER_DETAILS.".carrier_id)
                WHERE plan_id='$id' ";
        
        
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

    public function UpdatePlan($carrier_name,$plan_name, $id){

        $query = "UPDATE ".RDAMS_PLAN_DETAILS." SET plan_carrier_id=?,plan_name=? WHERE plan_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $carrier_name);
        $stmt->bindParam(2, $plan_name);
	$stmt->bindParam(3, $id);

        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
        
    }
	
	 public function DeletePlan($iid) {

        $query = "UPDATE ".RDAMS_PLAN_DETAILS." SET plan_active=0 WHERE plan_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $stmt->rowCount();

    }	       
  
}

?>
